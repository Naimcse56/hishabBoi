<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Accounts\App\Models\AccountConfiguration;
use Modules\Accounts\App\Models\Ledger;
use Modules\Accounts\App\Models\SubLedger;
use Modules\Accounts\App\Models\Voucher;
use Modules\Accounts\App\Models\Transaction;
use Modules\Accounts\App\Models\WorkOrder;
use Carbon\Carbon;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function report_config()
    {
        $data['settings'] = AccountConfiguration::get();
        return view('accounts::configs.report_config', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function general_config_store(Request $request): RedirectResponse
    {
        try {
            foreach ($request->field_name as $key => $field_name) {
                AccountConfiguration::where('name', $field_name)->first()->update(['value'=> $request->get($field_name)]);
            }
            return redirect()->back()->with('success','Updated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function cashbook(Request $request)
    {
        $start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : app('day_closing_info')['from_date'];
        $end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : now()->format('Y-m-d');
        $cash_account_id = $request->cash_account_id > 0 ? $request->cash_account_id : 5;
        
        if ($cash_account_id > 0) {
            $data['filtered_account'] = Ledger::find($cash_account_id,['id','name']);
            $cash_account = Ledger::with('categories:id,parent_id,name,type')->where('acc_type','cash')->where('id', $cash_account_id)->get(['id','name','type']);
            $infos = array();
            $infos = $this->getChildrenID($cash_account, $infos, $start_date);            
            $data['opening'] = collect($infos)->sum('opening_balance');
            $cash_account_ids = collect($infos)->pluck(['id']);
            
            $transactions = Transaction::whereHas('voucher', function($query) use($cash_account_ids,$start_date,$end_date){
                                            $query->where('is_approve', 1);
                                        })->when($request->party_id > 0, function ($q) use ($request) {
                                            return $q->where('sub_ledger_id', $request->party_id);
                                        })->whereIn('ledger_id', $cash_account_ids)->whereBetween('date',[$start_date,$end_date])
                                        ->with(['ledger:id,name,code', 'voucher:id,type,txn_id,f_year,is_opening,date','voucher.transactions:id,voucher_id,type,amount,ledger_id,sub_ledger_id','voucher.transactions.ledger:id,name,code','work_order:id,order_name,order_no,sub_ledger_id','work_order.sub_ledger:id,name','work_order_site_detail:id,site_name'])
                                        ->orderBy('voucher_id')->get(['id','date','voucher_id','ledger_id','sub_ledger_id','type','amount','narration','work_order_id','work_order_site_detail_id']);
            $data['transactions'] = collect($this->getDataFormatCashBankBookLedger($transactions));
        }
        $data['dateFrom'] = $start_date;
        $data['dateTo'] = $end_date;
        if ($request->has('print')) {
            return view('accounts::reports.cashbook.cashbook_print', $data);
        }
        
        return view('accounts::reports.cashbook.cashbook', $data);
    }

    public function bankbook(Request $request)
    {
        $start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : app('day_closing_info')['from_date'];
        $end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : now()->format('Y-m-d');
        $bank_id = $request->bank_id > 0 ? $request->bank_id : 4;
        if ($bank_id > 0) {
            $data['filtered_account'] = Ledger::find($bank_id,['id','name','ac_no']);
            $bank_account = Ledger::with('categories:id,parent_id,name,type')->where('acc_type','bank')->where('id', $bank_id)->get(['id','name','type']);
            $infos = array();
            $infos = $this->getChildrenID($bank_account, $infos, $start_date);
            $data['opening'] = collect($infos)->sum('opening_balance');
            $bank_account_ids = collect($infos)->pluck(['id']);
            $transactions = Transaction::whereHas('voucher', function($query) use($bank_account_ids,$start_date,$end_date){
                                            $query->where('is_approve', 1)->whereBetween('date',[$start_date,$end_date]);
                                        })->when($request->party_id > 0, function ($q) use ($request) {
                                            return $q->where('sub_ledger_id', $request->party_id);
                                        })->whereIn('ledger_id',$bank_account_ids)
                                        ->with(['ledger:id,name,code', 'voucher:id,type,txn_id,f_year,is_opening','voucher.transactions:id,voucher_id,type,amount,ledger_id,sub_ledger_id','voucher.transactions.ledger:id,name,code','work_order:id,order_name,order_no,sub_ledger_id','work_order.sub_ledger:id,name','work_order_site_detail:id,site_name'])
                                        ->orderBy('voucher_id')->get(['id','date','voucher_id','ledger_id','sub_ledger_id','type','amount','narration','work_order_id','work_order_site_detail_id']);
            $data['transactions'] = collect($this->getDataFormatCashBankBookLedger($transactions));
        }
        $data['dateFrom'] = $start_date;
        $data['dateTo'] = $end_date;
        if ($request->has('print')) {
            return view('accounts::reports.bankbook.bankbook_print', $data);
        }
        return view('accounts::reports.bankbook.bankbook', $data);
    }

    protected function getDataFormatCashBankBookLedger($transactions, $report_type = null)
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

    protected function getChildrenId($accounts, $tr_data, $start_date)
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
