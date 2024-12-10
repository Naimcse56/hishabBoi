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
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrialBalanceController extends Controller
{
    public function trial_balance(Request $request)
    {
        if ($request->report_type == "date_range") {
            $start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : app('day_closing_info')['from_date'];
            $end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : now()->format('Y-m-d');
            $data['prve_date_end'] = null;
            $data['prve_date_from'] = null;
        } else {
            if ($request->year) {
                $data['filter_year'] = DB::table('fiscal_years')->find($request->year);
                $data['filter_prev_year'] = DB::table('fiscal_years')->find($request->prev_year);
                $start_date = $data['filter_year']->from_date;
                $end_date = $data['filter_year']->to_date ? $data['filter_year']->to_date : now()->format('Y-m-d');
                $data['prve_date_end'] = $data['filter_prev_year'] ? $data['filter_prev_year']->to_date : null;
                $data['prve_date_from'] = $data['filter_prev_year'] ? $data['filter_prev_year']->from_date : null;
            } else {
                $start_date = app('current_fiscal_year')['from_date'];
                $end_date = now()->format('Y-m-d');
                $prev_fiscal_year = app('prev_fiscal_year');
                $data['prve_date_end'] = $prev_fiscal_year ? $prev_fiscal_year['to_date'] : null;
                $data['prve_date_from'] = $prev_fiscal_year ? $prev_fiscal_year['from_date'] : null;
            }
        }
        $data['report_type'] = $request->report_type ? $request->report_type : 'fiscal_year';
        $data['fiscal_years'] = DB::table('fiscal_years')->get();
        
        $tr_data = array();
        $parent_data = array();
        
        $first_section = $this->getChildrenSummary(Ledger::with(['categories:id,parent_id,name,code,type,acc_type,view_in_trial,level'])->whereIn('type',[1])->where('parent_id', 0)->get(['id','name','code','parent_id','acc_type','view_in_trial','type','level']), $tr_data, $start_date, $end_date, $data['prve_date_from'], $data['prve_date_end'], 'report');
        $data['first_section'] = collect($first_section);
        $second_section = $this->getChildrenSummary(Ledger::with(['categories:id,parent_id,name,code,type,acc_type,view_in_trial,level'])->whereIn('type',[3])->where('parent_id', 0)->get(['id','name','code','parent_id','acc_type','view_in_trial','type','level']), $tr_data, $start_date, $end_date, $data['prve_date_from'], $data['prve_date_end'], 'report');
        $data['second_section'] = collect($second_section);
        $third_section = $this->getChildrenSummary(Ledger::with(['categories:id,parent_id,name,code,type,acc_type,view_in_trial,level'])->whereIn('type',[2,5])->where('parent_id', 0)->get(['id','name','code','parent_id','acc_type','view_in_trial','type','level']), $tr_data, $start_date, $end_date, $data['prve_date_from'], $data['prve_date_end'], 'report');
        $data['third_section'] = collect($third_section);
        $fourth_section = $this->getChildrenSummary(Ledger::with(['categories:id,parent_id,name,code,type,acc_type,view_in_trial,level'])->whereIn('type',[4])->where('parent_id', 0)->get(['id','name','code','parent_id','acc_type','view_in_trial','type','level']), $tr_data, $start_date, $end_date, $data['prve_date_from'], $data['prve_date_end'], 'report');
        $data['fourth_section'] = collect($fourth_section);

        $data['dateFrom'] = $start_date;
        $data['dateTo'] = $end_date;
        if ($request->has('print')) {
            return view('accounts::reports.trial_balance.print', $data);
        }
        if ($request->has('note')) {
            return view('accounts::reports.trial_balance.note_print', $data);
        }
        
        return view('accounts::reports.trial_balance.index', $data);
    }

    protected function getChildrenSummary($accounts, $tr_data, $start_date, $end_date, $prev_start_date, $prev_end_date, $report_type)
    {
        foreach ($accounts as $key => $child) {
            $current_debit = ($child->type == 1 || $child->type == 3) ? $child->BalanceAmountBetweenDate($start_date, $end_date) : 0.00;
            if ($report_type == "preview_report") {
                $current_debit += ($child->type == 1 || $child->type == 3) ? $child->NonApprovedBalanceAmountBetweenDate($start_date, $end_date) : 0;
            }
            $current_credit = ($child->type == 2 || $child->type == 4 || $child->type == 5) ? $child->BalanceAmountBetweenDate($start_date, $end_date) : 0.00;
            if ($report_type == "preview_report") {
                $current_credit += ($child->type == 2 || $child->type == 4 || $child->type == 5) ? $child->NonApprovedBalanceAmountBetweenDate($start_date, $end_date) : 0;
            }
            
            // $prev_debit = ($child->type == 1 || $child->type == 3) && $prev_start_date != null ? $child->BalanceAmountBetweenDate($prev_start_date, $prev_end_date) : 0.00;
            // $prev_credit = ($child->type == 2 || $child->type == 4 || $child->type == 5) && $prev_start_date != null ? $child->BalanceAmountBetweenDate($prev_start_date, $prev_end_date) : 0.00;

            $amount_till_date = $child->BalanceAmountBetweenDate($start_date, $end_date);
            if ($report_type == "preview_report") {
                $amount_till_date += $child->NonApprovedBalanceAmountBetweenDate($start_date, $end_date);
            }
            // $prev_amount_till_date = $prev_start_date != null ? $child->BalanceAmountBetweenDate($prev_start_date, $prev_end_date) : 0.00;

            $children_balance = 0;
            $prev_children_balance = 0;
            $new_data['id'] = $child->id;
            $new_data['name'] = $child->name;
            $new_data['type'] = $child->type;
            $new_data['code'] = $child->code;
            $new_data['level'] = $child->level;
            $new_data['view_in_trial'] = $child->view_in_trial;
            $new_data['parent_sum'] = count($child->categories->where('view_in_trial',1)) > 0 ? 'no_sum' : 'do_sum';
            $new_data['is_parent'] = count($child->categories) > 0 ? "yes" : "no";
            if (($child->type == 1 || $child->type == 3)  && $current_debit >= 0) {
                $new_data['debit'] = number_format($current_debit,2);
            }
            if (($child->type == 2 || $child->type == 4 || $child->type == 5) && $current_credit < 0) {
                $new_data['debit'] = number_format(abs($current_credit),2);
            }
            if (($child->type == 1 || $child->type == 3) && $current_debit < 0) {
                $new_data['credit'] = number_format(abs($current_debit),2);
            }
            if (($child->type == 2 || $child->type == 4 || $child->type == 5) && $current_credit >= 0) {
                $new_data['credit'] = number_format($current_credit,2);
            }
            // if (($child->type == 1 || $child->type == 3)  && $prev_debit >= 0) {
            //     $new_data['prev_debit'] = number_format($prev_debit,2);
            // }
            // if (($child->type == 2 || $child->type == 4 || $child->type == 5) && $prev_credit < 0) {
            //     $new_data['prev_debit'] = number_format(abs($prev_credit),2);
            // }
            // if (($child->type == 1 || $child->type == 3) && $prev_debit < 0) {
            //     $new_data['prev_credit'] = number_format(abs($prev_debit),2);
            // }
            // if (($child->type == 2 || $child->type == 4 || $child->type == 5) && $prev_credit >= 0) {
            //     $new_data['prev_credit'] = number_format($prev_credit,2);
            // }
            
            
            $new_data['children_balance'] = count($child->categories) > 0 ? $this->getChildrenBalance($child->categories, $children_balance, $start_date, $end_date, $prev_start_date, $prev_end_date, $report_type) : 0.00;
            // $new_data['prev_children_balance'] = $prev_start_date != null && count($child->categories) > 0 ? $this->getChildrenPrevBalance($child->categories, $prev_children_balance, $prev_start_date, $prev_end_date) : 0.00;
            array_push($tr_data, $new_data);
            $new_data['debit'] = 0;
            $new_data['credit'] = 0;

            if (count($child->categories) > 0) {
                $tr_data = $this->getChildrenSummary($child->categories, $tr_data, $start_date, $end_date, $prev_start_date, $prev_end_date, $report_type);
            }
        }
        return $tr_data;
    }

    protected function getChildrenBalance($accounts, $children_balance, $start_date, $end_date, $prev_start_date, $prev_end_date, $report_type)
    {
        foreach ($accounts as $key => $child) {
            $children_balance += $child->BalanceAmountBetweenDate($start_date, $end_date);
            if ($report_type == "preview_report") {
                $children_balance += $child->NonApprovedBalanceAmountBetweenDate($start_date, $end_date);
            }
            if (count($child->categories) > 0) {
                $children_balance = $this->getChildrenBalance($child->categories, $children_balance, $start_date, $end_date, $prev_start_date, $prev_end_date, $report_type);
            }          
        }
        return $children_balance;
    }

    protected function getChildrenPrevBalance($accounts, $prev_children_balance, $prev_start_date, $prev_end_date, $report_type)
    {
        return 0;
        foreach ($accounts as $key => $child) {
            $prev_children_balance += $child->BalanceAmountBetweenDate($prev_start_date, $prev_end_date);
            if ($report_type == "preview_report") {
                $prev_children_balance += $child->NonApprovedBalanceAmountBetweenDate($prev_start_date, $prev_end_date);
            }
            if (count($child->categories) > 0) {
                $prev_children_balance = $this->getChildrenPrevBalance($child->categories, $prev_children_balance, $prev_start_date, $prev_end_date, $report_type);
            }          
        }
        return $prev_children_balance;
    }
}
