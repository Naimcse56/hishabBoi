<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Accounts\App\Models\AccountConfiguration;
use Modules\Accounts\App\Models\Ledger;
use Modules\Accounts\App\Models\LedgerBalance;
use Modules\Accounts\App\Models\SubLedger;
use Modules\Accounts\App\Models\Transaction;
use Modules\Accounts\App\Models\Voucher;
use Modules\Accounts\App\Models\WorkOrder;
use Modules\Accounts\App\Models\DayCloseFiscalYear;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LedgerDetailsReportController extends Controller
{
    public function __construct()
    {
        // Permission will be added
    }

    protected function getDataFormatLedger($transactions, $report_type = null, $approval = 0)
    {
        $tr_data = array();
        foreach ($transactions as $key => $transaction) {
            $new_data['date'] = $transaction->date;
            $new_data['voucher_id'] = $transaction->voucher_id;
            $new_data['is_opening'] = $transaction->voucher->is_opening;
            $new_data['particular'] = '('.$transaction->ledger->code.') '.$transaction->ledger->name;
            $new_data['voucher_type'] = $transaction->voucher->type;
            $new_data['txn_id'] = $transaction->voucher->TypeName;
            $new_data['type'] = $transaction->type;
            $new_data['amount'] = $transaction->amount;
            $new_data['narration'] = $transaction->narration;
            $new_data['party_id'] = $transaction->sub_ledger_id;
            $new_data['party'] = $transaction->sub_ledger->name;
            $new_data['work_order_id'] = $transaction->work_order_id;
            $new_data['work_order'] = '('.$transaction->work_order->order_name.') '.$transaction->work_order->order_no;
            $new_data['work_order_client'] = $transaction->work_order->sub_ledger->name;
            $new_data['work_order_site'] = $transaction->work_order_site_detail->site_name;
            foreach ($transaction->voucher->transactions->where('type', '!=',$transaction->type) as $k => $opposite_data) {
                $new_data['opposite_data'][$k]['info_type'] = $opposite_data->type.' Info';
                $new_data['opposite_data'][$k]['ledger'] = ' ('.$opposite_data->ledger->code.') '.$opposite_data->ledger->name;
                $new_data['opposite_data'][$k]['party'] =  $opposite_data->sub_ledger->name;
            }
            array_push($tr_data, $new_data);
            $new_data['opposite_data'] = [];
        }
        return $tr_data;
    }

    // This function is for Balane Sheet & Income Statement details report
    public function detail_report_ledger(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|numeric|gt:0',
        ],
        [
            'account_id.gt' => 'Please Select An Account',
        ]);
        $start_date = $request->start_date ? $request->start_date : app('day_closing_info')['from_date'];
        $end_date = $request->end_date ?  $request->end_date : now()->format('Y-m-d');
        $account_id = $request->account_id > 0 ? $request->account_id : 5;
        $approval = $request->approval ? $request->approval : 0;
        $work_order = $request->work_order_id ? $request->work_order_id : 0;
        $reciept_payment = $request->reciept_payment ? $request->reciept_payment : 'all';
        
        if ($account_id > 0) {
            $data['filtered_account'] = Ledger::find($account_id,['id','name','type']);
            $accounts = Ledger::with('categories:id,parent_id,name,type')->where('id', $account_id)->get(['id','name','type']);
            $infos = array();
            $infos = $this->getChildrenID($accounts, $infos, $start_date, $approval);            
            $data['opening'] = collect($infos)->sum('opening_balance');
            $accounts_ids = collect($infos)->pluck(['id']);
            if ($request->approval == "no") {
                $transactions = Transaction::whereHas('voucher', function($query) use($accounts_ids,$start_date,$end_date,$request,$reciept_payment){
                    $query->when($reciept_payment != 'all', function ($q) use ($request,$reciept_payment) {
                        return $q->where('type', $reciept_payment);
                    });
                })->when($request->party_id > 0, function ($q) use ($request) {
                    return $q->where('sub_ledger_id', $request->party_id);
                })->when($request->work_order_id > 0, function ($q) use ($request) {
                    return $q->where('work_order_id', $request->work_order_id);
                })->whereIn('ledger_id', $accounts_ids)->whereBetween('date',[$start_date,$end_date])
                ->with(['ledger:id,name,code', 'voucher:id,type,txn_id,f_year,is_opening,date','voucher.transactions:id,voucher_id,type,amount,ledger_id,sub_ledger_id','voucher.transactions.ledger:id,name,code','work_order:id,order_name,order_no,sub_ledger_id','work_order.sub_ledger:id,name','work_order_site_detail:id,site_name'])
                ->orderBy('voucher_id')->get(['id','date','voucher_id','ledger_id','sub_ledger_id','type','amount','narration','work_order_id','work_order_site_detail_id']);
            } else {
                $transactions = Transaction::whereHas('voucher', function($query) use($accounts_ids,$start_date,$end_date,$request,$reciept_payment){
                    $query->where('is_approve', 1)->when($reciept_payment != 'all', function ($q) use ($request,$reciept_payment) {
                        return $q->where('type', $reciept_payment);
                    });
                })->when($request->party_id > 0, function ($q) use ($request) {
                    return $q->where('sub_ledger_id', $request->party_id);
                })->when($request->work_order_id > 0, function ($q) use ($request) {
                    return $q->where('work_order_id', $request->work_order_id);
                })->whereIn('ledger_id', $accounts_ids)->whereBetween('date',[$start_date,$end_date])
                ->with(['ledger:id,name,code', 'voucher:id,type,txn_id,f_year,is_opening,date','voucher.transactions:id,voucher_id,type,amount,ledger_id,sub_ledger_id','voucher.transactions.ledger:id,name,code','work_order:id,order_name,order_no,sub_ledger_id','work_order.sub_ledger:id,name','work_order_site_detail:id,site_name'])
                ->orderBy('voucher_id')->get(['id','date','voucher_id','ledger_id','sub_ledger_id','type','amount','narration','work_order_id','work_order_site_detail_id']);
            }
            $data['transactions'] = collect($this->getDataFormatLedger($transactions), $approval);
        }
        $data['dateFrom'] = $start_date;
        $data['dateTo'] = $end_date;
        if ($request->has('print')) {
            return view('accounts::reports.ledger_details.print', $data);
        }
        return view('accounts::reports.ledger_details.index', $data);
    }

    protected function getChildrenId($accounts, $tr_data, $start_date, $approval = 0)
    {
        foreach ($accounts as $key => $child) {
            $new_data['id'] = $child->id;
            $new_data['name'] = $child->name;
            $new_data['opening_balance'] = $child->BalanceAmountTillDate($start_date);
        
            array_push($tr_data, $new_data);
            if (count($child->categories) > 0) {
                $tr_data = $this->getChildrenId($child->categories, $tr_data, $start_date);
            }
        }
        return $tr_data;
    }
}
