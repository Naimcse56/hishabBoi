<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Accounts\App\Models\AccountConfiguration;
use Modules\Accounts\App\Models\Ledger;
use Modules\Accounts\App\Models\SubLedger;
use Modules\Accounts\App\Models\Transaction;
use Modules\Accounts\App\Models\Voucher;
use Modules\Accounts\App\Models\DayCloseFiscalYear;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BalanceSheetController extends Controller
{
    public function balancesheet(Request $request)
    {
        $start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : app('day_closing_info')['from_date'];
        $end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : now()->format('Y-m-d');
        $data['prve_date_end'] = null;
        $data['prve_date_from'] = null;

        $ledgers = Ledger::with(['categories:id,parent_id,name,code,type,acc_type,level'])->whereNotIn('id',[app('account_configurations')['retail_earning_account']])->get(['id','name','code','parent_id','acc_type','level','type']);

        $data['dateFrom'] = $start_date;
        $data['dateTo'] = $end_date;
        $tr_data = array();
        $parent_data = array();
        $first_section = $this->getChildrenSummary($ledgers->where('id',app('account_configurations')['balance_sht_first_section']), $tr_data, $start_date, $end_date, $data['prve_date_from'], $data['prve_date_end'], 'report');
        $data['first_section'] = collect($first_section);
        $second_section = $this->getChildrenSummary($ledgers->where('id',app('account_configurations')['balance_sht_second_section']), $tr_data, $start_date, $end_date, $data['prve_date_from'], $data['prve_date_end'], 'report');
        $data['second_section'] = collect($second_section);
        $third_section = $this->getChildrenSummary($ledgers->where('id',app('account_configurations')['balance_sht_third_section']), $tr_data, $start_date, $end_date, $data['prve_date_from'], $data['prve_date_end'], 'report');
        $data['third_section'] = collect($third_section);
        $fourth_section = $this->getChildrenSummary($ledgers->where('id',app('account_configurations')['balance_sht_fourth_section']), $tr_data, $start_date, $end_date, $data['prve_date_from'], $data['prve_date_end'], 'report');
        $data['fourth_section'] = collect($fourth_section);
        $fifth_section = $this->getChildrenSummary($ledgers->where('id',app('account_configurations')['balance_sht_fifth_section']), $tr_data, $start_date, $end_date, $data['prve_date_from'], $data['prve_date_end'], 'report');
        $data['fifth_section'] = collect($fifth_section);
        if ($request->has('print')) {
            return view('accounts::reports.balancesheet.print', $data);
        }
        return view('accounts::reports.balancesheet.index', $data);
    }

    protected function getChildrenSummary($accounts, $tr_data, $start_date, $end_date, $prev_start_date, $prev_end_date, $report_type)
    {
        foreach ($accounts->whereNotIn('id',[app('account_configurations')['retail_earning_account']]) as $key => $child) {
            $amount_till_date = $child->BalanceAmountBetweenDate($start_date, $end_date);
            $children_balance = 0;
            $prev_children_balance = 0;
            $new_data['id'] = $child->id;
            $new_data['name'] = $child->name;
            $new_data['code'] = $child->code;
            $new_data['level'] = $child->level;
            $new_data['is_parent'] = count($child->categories) > 0 ? "yes" : "no";
            $new_data['children_balance'] = count($child->categories) > 0 ? $this->getChildrenBalance($child->categories, $children_balance, $start_date, $end_date, $prev_start_date, $prev_end_date, $report_type) : 0;
            $new_data['amount'] = $amount_till_date;
            array_push($tr_data, $new_data);
            
            if (count($child->categories) > 0) {
                $tr_data = $this->getChildrenSummary($child->categories, $tr_data, $start_date, $end_date, $prev_start_date, $prev_end_date, $report_type);
            }
        }
        return $tr_data;
    }

    protected function getChildrenBalance($accounts, $children_balance, $start_date, $end_date, $prev_start_date, $prev_end_date, $report_type)
    {
        foreach ($accounts->whereNotIn('id',[app('account_configurations')['retail_earning_account']]) as $key => $child) {
            $children_balance += $child->BalanceAmountBetweenDate($start_date, $end_date);
            if (count($child->categories) > 0) {
                $children_balance = $this->getChildrenBalance($child->categories, $children_balance, $start_date, $end_date, $prev_start_date, $prev_end_date, $report_type);
            }          
        }
        return $children_balance;
    }
}
