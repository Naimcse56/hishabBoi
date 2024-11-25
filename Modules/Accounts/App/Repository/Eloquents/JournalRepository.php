<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use Modules\Accounts\App\Repository\Interfaces\JournalRepositoryInterface;
use Modules\Accounts\App\Models\Ledger;
use Modules\Accounts\App\Models\SubLedger;
use Modules\Accounts\App\Models\Voucher;
use Modules\Accounts\App\Models\Transaction;
use Modules\Accounts\App\Models\AccountingBillInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Modules\Accounts\App\Events\LedgerBalanceEvent;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class JournalRepository implements JournalRepositoryInterface
{
    public function listForDataTable($type, $panel)
    {
        if (auth()->user()->employee || auth()->id() == 1) {
            return Voucher::whereIn('type',$type)->where('panel', $panel)->where('is_work_order_based', 0)->whereIn('branch_id',[app('branch_info')['current_branch_id']])->orderBy('id','desc');
        } else {
            abort(404);
        }
    }

    public function billGenerate($type = null)
    {
        $bill = AccountingBillInfo::orderBy('id','desc')->first();
        if ($type == "purchase") {
            return 'PBN'.app('branch_info')['current_branch_id'].$bill->id + 1;
        } else {
            return 'SBN'.app('branch_info')['current_branch_id'].$bill->id + 1;
        }
        
    }

    public function workOrderVoucherListForDataTable()
    {
        if (auth()->user()->employee || auth()->id() == 1) {
            return Voucher::where('is_work_order_based', 1)->whereIn('branch_id',[app('branch_info')['current_branch_id']])->orderBy('id','desc');
        } else {
            abort(404);
        }
    }

    public function paymentDueListForDataTable($sub_ledger_id, $start_date, $end_date, $date_filter_based)
    {
        return AccountingBillInfo::with('sub_ledger:id,name')->whereHas('sub_ledger', function($q){
            $q->whereIn('branch_id',[app('branch_info')['current_branch_id']]);
        })->when($sub_ledger_id > 0, function ($q) use ($sub_ledger_id){
            return $q->where('sub_ledger_id', $sub_ledger_id);
        })->when($date_filter_based != 'none', function ($q) use ($start_date, $end_date, $date_filter_based) {
            return $q->whereBetween($date_filter_based,[Carbon::createFromFormat('d/m/Y', $start_date)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $end_date)->format('Y-m-d')]);
        })->where('type','payment')->whereColumn('amount','!=','paid_amount')->orderBy('id','asc');
        
    }

    public function rcvDueListForDataTable($sub_ledger_id, $start_date, $end_date, $date_filter_based)
    {
        return AccountingBillInfo::with('sub_ledger:id,name')->whereHas('sub_ledger', function($q){
            $q->whereIn('branch_id',[app('branch_info')['current_branch_id']]);
        })->when($sub_ledger_id > 0, function ($q) use ($sub_ledger_id){
            return $q->where('sub_ledger_id', $sub_ledger_id);
        })->when($date_filter_based != 'none', function ($q) use ($start_date, $end_date, $date_filter_based) {
            return $q->whereBetween($date_filter_based,[Carbon::createFromFormat('d/m/Y', $start_date)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $end_date)->format('Y-m-d')]);
        })->where('type','rcv')->whereColumn('amount','!=','paid_amount')->orderBy('id','asc');
        
    }

    public function create($data)
    {
        $Voucher = '';
        $transactions = $this->dataEntry($data);
        $cash_v = Voucher::where('type', strtolower($data['type']))->where('branch_id',app('branch_info')['current_branch_id'])->orderBy('id', 'DESC')->first();
        if ($cash_v) {
            $n_data = explode('-', $cash_v->txn_id);
            if (count($n_data) > 1) {
                 $txn_num = (int) $n_data[1] + 1;
             } else {
                 $txn_num = $n_data[0] + 1;
             }
        }else{
            $txn_num = 100001;
        }
        
        if (!empty($data['bill_party']) && !empty($data['bill_no'])) {
            $billExist = AccountingBillInfo::where('bill_no',$data['bill_no'])->where('bill_date',$data['bill_date'])->where('sub_ledger_id',$data['bill_party'])->first();
            if ($billExist) {
                $billExist->update([
                    'bill_no' => (!empty($data['bill_no'])) ? $data['bill_no'] : null,
                    'bill_date' => (!empty($data['bill_date'])) ? $data['bill_date'] : $data['date'],
                    'sub_ledger_id' => (!empty($data['bill_party'])) ? $data['bill_party'] : 0,
                    'amount' => (!empty($data['bill_amount'])) ? $billExist->amount + $data['bill_amount'] : $data['amount'],
                    'last_date' => $data['date'],
                    'narration' => $data['narration_voucher'],
                    'type' => $data['bill_type'],
                    'credit_period' => (!empty($data['credit_period'])) ? $data['credit_period'] : 0,
                ]);
                $bill_info = $billExist;
            } else {
                $bill_info = AccountingBillInfo::create([
                    'bill_no' => (!empty($data['bill_no'])) ? $data['bill_no'] : null,
                    'bill_date' => (!empty($data['bill_date'])) ? $data['bill_date'] : $data['date'],
                    'sub_ledger_id' => (!empty($data['bill_party'])) ? $data['bill_party'] : 0,
                    'amount' => (!empty($data['bill_amount'])) ? $data['bill_amount'] : $data['amount'],
                    // 'paid_amount' => ($data['bill_type'] == "pay_bank" || $data['bill_type'] == "pay_cash") ? $data['amount'] : 0,
                    'last_date' => $data['date'],
                    'narration' => $data['narration_voucher'],
                    'type' => $data['bill_type'],
                    'credit_period' => (!empty($data['credit_period'])) ? $data['credit_period'] : 0,
                ]);
            }
        }
        $Voucher = Voucher::create([
            'amount' => $data['amount'],
            'date' => $data['date'],
            'concern_person' => $data['concern_person'],
            'narration' => $data['narration_voucher'],
            'sub_concern_id' => $data['sub_concern_id'],
            'type' => $data['type'],
            'f_year' => str_replace('-','',app('current_fiscal_year')->year).app('branch_info')['current_branch_id'],
            'mac_address' => exec('getmac'),
            'ip' => \Request::ip(),
            'is_approve' => $data['is_approve'],
            'panel' => $data['panel'],
            'referable_type' => (!empty($data['referable_type'])) ? $data['referable_type'] : null,
            'referable_id' => (!empty($data['referable_id'])) ? $data['referable_id'] : null,
            'is_invoiced' => (!empty($data['is_invoiced'])) ? $data['is_invoiced'] : 0,
            'is_advanced' => (!empty($data['is_advanced'])) ? $data['is_advanced'] : 0,
            'is_opening' => (!empty($data['is_opening'])) ? $data['is_opening'] : 0,
            'branch_id' => (!empty($data['branch_id'])) ? $data['branch_id'] : 0,
            'accounting_bill_info_id' => (!empty($data['bill_party']) && !empty($data['bill_no'])) ? $bill_info->id : (!empty($data['accounting_bill_info_id']) ? $data['accounting_bill_info_id'] : 0),
            'ref_no' => (!empty($data['ref_no'])) ? $data['ref_no'] : null,
            'is_manual_entry' => (!empty($data['is_manual_entry'])) ? $data['is_manual_entry'] : 0,
            'is_work_order_based' => (!empty($data['is_work_order_based'])) ? $data['is_work_order_based'] : 0,
            'is_land_project_based' => (!empty($data['is_land_project_based'])) ? $data['is_land_project_based'] : 0,
            'created_by' => (auth()->check()) ? auth()->user()->id : null,
            'pay_or_rcv_type' => (!empty($data['pay_or_rcv_type'])) ? $data['pay_or_rcv_type'] : null,
            'attachment' => (!empty($data['attachment'])) ? $data['attachment'] : null,
        ]);
        foreach ($transactions as $key => $transaction) {
            $transactionEntry = Transaction::create([
                'voucher_id' => $Voucher->id,
                'land_project_id' => $transaction['land_project_id'],
                'work_order_id' => $transaction['work_order_id'],
                'work_order_site_detail_id' => $transaction['work_order_site_detail_id'],
                'ledger_id' => $transaction['ledger_id'],
                'sub_ledger_id' => $transaction['sub_ledger_id'],
                'sub_concern_id' => $transaction['sub_concern_id'],
                'accounting_bill_info_id' => ($transaction['sub_ledger_id'] > 0 && !empty($data['bill_party']) && !empty($data['bill_no'])) ? $bill_info->id : (!empty($data['accounting_bill_info_id']) ? $data['accounting_bill_info_id'] : 0),
                'narration' => $transaction['narration'],
                'type' => $transaction['type'],
                'amount' => $transaction['amount'],
                'date' => $data['date'],
                'accounting_period_id' => 1,
                'is_approve' => $data['is_approve'],
                'bank_name' => $transaction['bank_name'],
                'check_no' => $transaction['check_no'],
                'check_mature_date' => $transaction['check_mature_date'],
                'bank_account_name' => $transaction['bank_account_name'],
                'branch_id' => (!empty($data['branch_id'])) ? $data['branch_id'] : 0,
                'credit_period' => $transaction['credit_period'],
                'accounting_additional_information_id' => $transaction['accounting_additional_information_id'],
            ]);
            if ($transaction['sub_ledger_id'] != 0) {
                SubLedger::find($transaction['sub_ledger_id'])->update(['is_blocked'=>1]);
            }
            if ($transaction['ledger_id'] != 0) {
                Ledger::find($transaction['ledger_id'])->update(['is_blocked'=>1]);
            }
        }
        $Voucher->update(['txn_id' => $txn_num]);
        if ($data['is_approve'] == 1) {
            $Voucher->transactions()->update(['is_approve' => 1]);
            $Voucher->update(['is_approve' => 1, 'approved_by' => auth()->user()->id]);
            if ($Voucher->work_order_id > 0 && !in_array($Voucher->type, ['sales','purchase'])) {
                $work_order = $Voucher->work_order;
                if ($work_order->sub_ledger->ledger->type == 1 || $work_order->sub_ledger->ledger->type == 3) {
                    $actual_cost = $Voucher->transactions->where('ledger_id', $work_order->ledger_id)->where('type','Cr')->sum('amount');
                } else {
                    $actual_cost = $Voucher->transactions->where('ledger_id', $work_order->ledger_id)->where('type','Dr')->sum('amount');
                }
                $work_order->update(['actual_cost' => $work_order->actual_cost + $actual_cost]);
            }
            if ($Voucher->accounting_bill_info && ($Voucher->type == "pay_bank" || $Voucher->type == "pay_cash" || $Voucher->type == "rcv_bank" || $Voucher->type == "rcv_cash")) {
                $bill_info = $Voucher->accounting_bill_info;
                $bill_info->update(['paid_amount' => $bill_info->paid_amount + $Voucher->amount]);
            }
            Event::dispatch(new LedgerBalanceEvent($Voucher));
        }
        return $Voucher->load('transactions');
    }

    public function findById($id)
    {
        return Voucher::with(['transactions','transactions.work_order'])->findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $Voucher = '';
        $transactions = $this->dataEntry($data);
        $Voucher = Voucher::findOrFail($id);
        if ($Voucher->is_approve == 1) {
            return $Voucher->load('transactions');
        }
        if (!empty($data['bill_party']) && !empty($data['bill_no'])) {
            if ($Voucher->accounting_bill_info_id > 0) {
                $bill_info = $Voucher->accounting_bill_info;
                if (($bill_info->bill_no == $data['bill_no']) && ($bill_info->bill_date == $data['bill_date']) && ($bill_info->sub_ledger_id == $data['bill_party'])) {
                    $bill_info_amount_prev = $bill_info->amount - $Voucher->amount;
                    $bill_info->update([
                        'bill_no' => (!empty($data['bill_no'])) ? $data['bill_no'] : null,
                        'bill_date' => (!empty($data['bill_date'])) ? $data['bill_date'] : $data['date'],
                        'sub_ledger_id' => (!empty($data['bill_party'])) ? $data['bill_party'] : 0,
                        'amount' => (!empty($data['bill_amount'])) ? $bill_info_amount_prev + $data['bill_amount'] : $bill_info_amount_prev + $data['amount'],
                        'last_date' => $data['date'],
                        'narration' => $data['narration_voucher'],
                        'type' => $data['bill_type'],
                        'credit_period' => (!empty($data['credit_period'])) ? $data['credit_period'] : 0,
                    ]);
                } else {
                    $bill_info = AccountingBillInfo::create([
                        'bill_no' => (!empty($data['bill_no'])) ? $data['bill_no'] : null,
                        'bill_date' => (!empty($data['bill_date'])) ? $data['bill_date'] : $data['date'],
                        'sub_ledger_id' => (!empty($data['bill_party'])) ? $data['bill_party'] : 0,
                        'amount' => (!empty($data['bill_amount'])) ? $data['bill_amount'] : $data['amount'],
                        'last_date' => $data['date'],
                        'narration' => $data['narration_voucher'],
                        'type' => $data['bill_type'],
                        'credit_period' => (!empty($data['credit_period'])) ? $data['credit_period'] : 0,
                    ]);
                }                
            } else {
                $bill_info = AccountingBillInfo::create([
                    'bill_no' => (!empty($data['bill_no'])) ? $data['bill_no'] : null,
                    'bill_date' => (!empty($data['bill_date'])) ? $data['bill_date'] : $data['date'],
                    'sub_ledger_id' => (!empty($data['bill_party'])) ? $data['bill_party'] : 0,
                    'amount' => (!empty($data['bill_amount'])) ? $data['bill_amount'] : $data['amount'],
                    'last_date' => $data['date'],
                    'narration' => $data['narration_voucher'],
                    'type' => $data['bill_type'],
                    'credit_period' => (!empty($data['credit_period'])) ? $data['credit_period'] : 0,
                ]);
            }
        } else {
            // $Voucher->accounting_bill_info()->delete();
        }
        
        $Voucher->update([
            'amount' => $data['amount'],
            'date' => $data['date'],
            'concern_person' => $data['concern_person'],
            'narration' => $data['narration_voucher'],
            'sub_concern_id' => $data['sub_concern_id'],
            'type' => $data['type'],
            'is_approve' => $data['is_approve'],
            'mac_address' => exec('getmac'),
            'ip' => \Request::ip(),
            'referable_type' => (!empty($data['referable_type'])) ? $data['referable_type'] : null,
            'referable_id' => (!empty($data['referable_id'])) ? $data['referable_id'] : null,
            'is_invoiced' => (!empty($data['is_invoiced'])) ? $data['is_invoiced'] : 0,
            'is_advanced' => (!empty($data['is_advanced'])) ? $data['is_advanced'] : 0,
            'is_opening' => (!empty($data['is_opening'])) ? $data['is_opening'] : 0,
            'branch_id' => (!empty($data['branch_id'])) ? $data['branch_id'] : 0,
            'accounting_bill_info_id' => (!empty($data['bill_party']) && !empty($data['bill_no'])) ? $bill_info->id : (!empty($data['accounting_bill_info_id']) ? $data['accounting_bill_info_id'] : 0),
            'ref_no' => (!empty($data['ref_no'])) ? $data['ref_no'] : null,
            'is_manual_entry' => (!empty($data['is_manual_entry'])) ? $data['is_manual_entry'] : 0,
            'is_work_order_based' => (!empty($data['is_work_order_based'])) ? $data['is_work_order_based'] : 0,
            'is_land_project_based' => (!empty($data['is_land_project_based'])) ? $data['is_land_project_based'] : 0,
            'pay_or_rcv_type' => (!empty($data['pay_or_rcv_type'])) ? $data['pay_or_rcv_type'] : null,
            'updated_by' => auth()->user()->id,
            'is_initial_checked' => 0,
            'initial_checked_by' => 0,
            'rejection_comment' => null,
            'attachment' => (!empty($data['attachment']) && $data['attachment'] != null) ? $data['attachment'] : $Voucher->attachment,
        ]);
        $Voucher->transactions()->forceDelete();

        foreach ($transactions as $key => $transaction) {
            $transactionEntry = Transaction::create([
                'voucher_id' => $Voucher->id,
                'land_project_id' => $transaction['land_project_id'],
                'work_order_id' => $transaction['work_order_id'],
                'work_order_site_detail_id' => $transaction['work_order_site_detail_id'],
                'ledger_id' => $transaction['ledger_id'],
                'sub_ledger_id' => $transaction['sub_ledger_id'],
                'sub_concern_id' => $transaction['sub_concern_id'],
                'accounting_additional_information_id' => $transaction['accounting_additional_information_id'],
                'accounting_bill_info_id' => ($transaction['sub_ledger_id'] > 0 && !empty($data['bill_party']) && !empty($data['bill_no'])) ? $bill_info->id : (!empty($data['accounting_bill_info_id']) ? $data['accounting_bill_info_id'] : 0),
                'narration' => $transaction['narration'],
                'type' => $transaction['type'],
                'amount' => $transaction['amount'],
                'date' => $data['date'],
                'bank_name' => $transaction['bank_name'],
                'check_no' => $transaction['check_no'],
                'check_mature_date' => $transaction['check_mature_date'],
                'bank_account_name' => $transaction['bank_account_name'],
                'accounting_period_id' => 1,
                'branch_id' => (!empty($data['branch_id'])) ? $data['branch_id'] : 0,
                'credit_period' => $transaction['credit_period'],
            ]);
            if ($transaction['sub_ledger_id'] != 0) {
                SubLedger::find($transaction['sub_ledger_id'])->update(['is_blocked'=>1]);
            }
            if ($transaction['ledger_id'] != 0) {
                Ledger::find($transaction['ledger_id'])->update(['is_blocked'=>1]);
            }
        }

        $txn_data = explode('-', $Voucher->txn_id);
        if (count($txn_data) > 1) {
            $txn_num = $txn_data[1];
        } else {
            $txn_num = $txn_data[0];
        }

        $Voucher->update(['txn_id' => $txn_num]);
        
        return $Voucher->load('transactions');
    }

    protected function dataEntry($data)
    {
        $convert_data = [];
        foreach ($data['debit_account_id'] as $i => $debit) {
            if ($data['debit_account_id'][$i] > 0 && $data['debit_account_amount'][$i] > 0) {
                array_push($convert_data,[
                    'ledger_id' => $data['debit_account_id'][$i],
                    'sub_ledger_id' => $data['debit_sub_account_id'][$i],
                    'land_project_id' => !empty($data['debit_land_project_id'][$i]) ? $data['debit_land_project_id'][$i] : 0,
                    'work_order_id' => $data['debit_work_order_id'][$i],
                    'work_order_site_detail_id' => !empty($data['debit_work_order_site_detail_id'][$i]) ? $data['debit_work_order_site_detail_id'][$i] : 0,
                    'type' => 'Dr',
                    'amount' => $data['debit_account_amount'][$i],
                    'narration' => $data['debit_narration'][$i],
                    'sub_concern_id' => !empty($data['debit_sub_concern_id'][$i]) ? $data['debit_sub_concern_id'][$i] : 0,
                    'credit_period' => !empty($data['debit_credit_period'][$i]) ? $data['debit_credit_period'][$i] : 0,
                    'bank_name' => !empty($data['debit_bank_name'][$i]) ? $data['debit_bank_name'][$i] : null,
                    'check_no' => !empty($data['debit_check_no'][$i]) ? $data['debit_check_no'][$i] : null,
                    'check_mature_date' => !empty($data['debit_check_mature_date'][$i]) ? $data['debit_check_mature_date'][$i] : null,
                    'bank_account_name' => !empty($data['debit_bank_ac_name'][$i]) ? $data['debit_bank_ac_name'][$i] : null,
                    'accounting_additional_information_id' => !empty($data['debit_accounting_additional_information_id'][$i]) ? $data['debit_accounting_additional_information_id'][$i] : 0,
                ]);
            }
        }
        foreach ($data['credit_account_id'] as $i => $debit) {
            if ($data['credit_account_id'][$i] > 0 && $data['credit_account_amount'][$i] > 0) {
                array_push($convert_data,[
                    'ledger_id' => $data['credit_account_id'][$i],
                    'sub_ledger_id' => $data['credit_sub_account_id'][$i],
                    'land_project_id' => !empty($data['credit_land_project_id'][$i]) ? $data['credit_land_project_id'][$i] : 0,
                    'work_order_id' => $data['credit_work_order_id'][$i],
                    'work_order_site_detail_id' => !empty($data['credit_work_order_site_detail_id'][$i]) ? $data['credit_work_order_site_detail_id'][$i] : 0,
                    'type' => 'Cr',
                    'amount' => $data['credit_account_amount'][$i],
                    'narration' => $data['credit_narration'][$i],
                    'sub_concern_id' => !empty($data['credit_sub_concern_id'][$i]) ? $data['credit_sub_concern_id'][$i] : 0,
                    'credit_period' => !empty($data['credit_credit_period'][$i]) ? $data['credit_credit_period'][$i] : 0,
                    'bank_name' => !empty($data['credit_bank_name'][$i]) ? $data['credit_bank_name'][$i] : null,
                    'check_no' => !empty($data['credit_check_no'][$i]) ? $data['credit_check_no'][$i] : null,
                    'check_mature_date' => !empty($data['credit_check_mature_date'][$i]) ? $data['credit_check_mature_date'][$i] : null,
                    'bank_account_name' => !empty($data['credit_bank_ac_name'][$i]) ? $data['credit_bank_ac_name'][$i] : null,
                    'accounting_additional_information_id' => !empty($data['credit_accounting_additional_information_id'][$i]) ? $data['credit_accounting_additional_information_id'][$i] : 0,
                ]);
            }
            
        }
        return $convert_data;
    }

    public function delete($id)
    {
        $voucher = $this->findById($id);
        if ($voucher->is_approve != 1) {
            $voucher->transactions()->delete();
            $voucher->accounting_bill_info()->delete();
            $voucher->delete();
        }
        return "done";
    }
}
