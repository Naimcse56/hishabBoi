<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use Modules\Accounts\App\Repository\Interfaces\JournalRepositoryInterface;
use Modules\Accounts\App\Models\Ledger;
use Modules\Accounts\App\Models\SubLedger;
use Modules\Accounts\App\Models\Voucher;
use Modules\Accounts\App\Models\Payment;
use Modules\Accounts\App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class JournalRepository implements JournalRepositoryInterface
{
    public function listForDataTable($type, $panel)
    {
        if (auth()->user()->employee || auth()->id() == 1) {
            return Voucher::whereIn('type',$type)->where('panel', $panel)->where('is_work_order_based', 0)->orderBy('id','desc');
        } else {
            abort(404);
        }
    }

    public function workOrderVoucherListForDataTable()
    {
        if (auth()->user()->employee || auth()->id() == 1) {
            return Voucher::where('is_work_order_based', 1)->orderBy('id','desc');
        } else {
            abort(404);
        }
    }

    public function create($data)
    {
        $Voucher = '';
        $transactions = $this->dataEntry($data);
        $cash_v = Voucher::where('type', strtolower($data['type']))->orderBy('id', 'DESC')->first();
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

        $Voucher = Voucher::create([
            'amount' => $data['amount'],
            'date' => $data['date'],
            'concern_person' => $data['concern_person'],
            'narration' => $data['narration_voucher'],
            'type' => $data['type'],
            'f_year' => str_replace('-','',app('current_fiscal_year')->year),
            'mac_address' => exec('getmac'),
            'ip' => \Request::ip(),
            'is_approve' => $data['is_approve'],
            'panel' => $data['panel'],
            'referable_type' => (!empty($data['referable_type'])) ? $data['referable_type'] : null,
            'referable_id' => (!empty($data['referable_id'])) ? $data['referable_id'] : null,
            'is_invoiced' => (!empty($data['is_invoiced'])) ? $data['is_invoiced'] : 0,
            'is_advanced' => (!empty($data['is_advanced'])) ? $data['is_advanced'] : 0,
            'is_opening' => (!empty($data['is_opening'])) ? $data['is_opening'] : 0,
            'ref_no' => (!empty($data['ref_no'])) ? $data['ref_no'] : null,
            'is_manual_entry' => (!empty($data['is_manual_entry'])) ? $data['is_manual_entry'] : 0,
            'is_work_order_based' => (!empty($data['is_work_order_based'])) ? $data['is_work_order_based'] : 0,
            'is_land_project_based' => (!empty($data['is_land_project_based'])) ? $data['is_land_project_based'] : 0,
            'created_by' => (auth()->check()) ? auth()->user()->id : null,
            'pay_or_rcv_type' => (!empty($data['pay_or_rcv_type'])) ? $data['pay_or_rcv_type'] : null,
            'attachment' => (!empty($data['attachment'])) ? $data['attachment'] : null,
        ]);
        if (!empty($data['referable_type'])) {
            $payment = Payment::create([
                'date' => $data['date'],
                'morphable_type' => $data['referable_type'],
                'morphable_id' => $data['referable_id'],
                'amount' => $data['amount'],
                'ledger_id' => $data['payment_account_id'],
                'bank_name' => !empty($data['bank_name']) ? $data['bank_name'] : null,
                'bank_account_name' => !empty($data['bank_account_name']) ? $data['bank_account_name'] : null,
                'check_no' => !empty($data['check_no']) ? $data['check_no'] : null,
                'check_mature_date' => !empty($data['check_mature_date']) ? Carbon::createFromFormat('d/m/Y', $data["check_mature_date"])->format('Y-m-d') : null,
                'mac_address' => exec('getmac'),
                'ip' => \Request::ip(),
            ]);
        }
        foreach ($transactions as $key => $transaction) {
            $transactionEntry = Transaction::create([
                'voucher_id' => $Voucher->id,
                'work_order_id' => $transaction['work_order_id'],
                'work_order_site_id' => $transaction['work_order_site_detail_id'],
                'ledger_id' => $transaction['ledger_id'],
                'sub_ledger_id' => $transaction['sub_ledger_id'],
                'narration' => $transaction['narration'],
                'type' => $transaction['type'],
                'amount' => $transaction['amount'],
                'date' => $data['date'],
                'is_approve' => $data['is_approve'],
                'bank_name' => $transaction['bank_name'],
                'check_no' => $transaction['check_no'],
                'check_mature_date' => $transaction['check_mature_date'],
                'bank_account_name' => $transaction['bank_account_name'],
                'credit_period' => $transaction['credit_period'],
                'payment_id' => !empty($data['referable_type']) ? $payment->id : 0,
            ]);
        }
        $Voucher->update(['txn_id' => $txn_num]);
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
        $Voucher->update([
            'amount' => $data['amount'],
            'date' => $data['date'],
            'concern_person' => $data['concern_person'],
            'narration' => $data['narration_voucher'],
            'type' => $data['type'],
            'is_approve' => $data['is_approve'],
            'mac_address' => exec('getmac'),
            'ip' => \Request::ip(),
            'referable_type' => (!empty($data['referable_type'])) ? $data['referable_type'] : null,
            'referable_id' => (!empty($data['referable_id'])) ? $data['referable_id'] : null,
            'is_invoiced' => (!empty($data['is_invoiced'])) ? $data['is_invoiced'] : 0,
            'is_advanced' => (!empty($data['is_advanced'])) ? $data['is_advanced'] : 0,
            'is_opening' => (!empty($data['is_opening'])) ? $data['is_opening'] : 0,            
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
        $Voucher->payment()->delete();
        if (!empty($data['referable_type'])) {
            $payment = Payment::create([
                'date' => $data['date'],
                'morphable_type' => $data['referable_type'],
                'morphable_id' => $data['referable_id'],
                'amount' => $data['amount'],
                'ledger_id' => $data['payment_account_id'],
                'bank_name' => !empty($data['bank_name']) ? $data['bank_name'] : null,
                'bank_account_name' => !empty($data['bank_account_name']) ? $data['bank_account_name'] : null,
                'check_no' => !empty($data['check_no']) ? $data['check_no'] : null,
                'check_mature_date' => !empty($data['check_mature_date']) ? Carbon::createFromFormat('d/m/Y', $data["check_mature_date"])->format('Y-m-d') : null,
                'mac_address' => exec('getmac'),
                'ip' => \Request::ip(),
            ]);
        }
        foreach ($transactions as $key => $transaction) {
            $transactionEntry = Transaction::create([
                'voucher_id' => $Voucher->id,
                'work_order_id' => $transaction['work_order_id'],
                'work_order_site_id' => $transaction['work_order_site_detail_id'],
                'ledger_id' => $transaction['ledger_id'],
                'sub_ledger_id' => $transaction['sub_ledger_id'],
                'narration' => $transaction['narration'],
                'type' => $transaction['type'],
                'amount' => $transaction['amount'],
                'date' => $data['date'],
                'bank_name' => $transaction['bank_name'],
                'check_no' => $transaction['check_no'],
                'check_mature_date' => $transaction['check_mature_date'],
                'bank_account_name' => $transaction['bank_account_name'],
                'accounting_period_id' => 1,
                'credit_period' => $transaction['credit_period'],
                'payment_id' => !empty($data['referable_type']) ? $payment->id : 0,
            ]);
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
                    'work_order_id' => $data['debit_work_order_id'][$i],
                    'work_order_site_detail_id' => !empty($data['debit_work_order_site_detail_id'][$i]) ? $data['debit_work_order_site_detail_id'][$i] : 0,
                    'type' => 'Dr',
                    'amount' => $data['debit_account_amount'][$i],
                    'narration' => $data['debit_narration'][$i],
                    'credit_period' => !empty($data['debit_credit_period'][$i]) ? $data['debit_credit_period'][$i] : 0,
                    'bank_name' => !empty($data['debit_bank_name'][$i]) ? $data['debit_bank_name'][$i] : null,
                    'check_no' => !empty($data['debit_check_no'][$i]) ? $data['debit_check_no'][$i] : null,
                    'check_mature_date' => !empty($data['debit_check_mature_date'][$i]) ? $data['debit_check_mature_date'][$i] : null,
                    'bank_account_name' => !empty($data['debit_bank_ac_name'][$i]) ? $data['debit_bank_ac_name'][$i] : null,
                ]);
            }
        }
        foreach ($data['credit_account_id'] as $i => $debit) {
            if ($data['credit_account_id'][$i] > 0 && $data['credit_account_amount'][$i] > 0) {
                array_push($convert_data,[
                    'ledger_id' => $data['credit_account_id'][$i],
                    'sub_ledger_id' => $data['credit_sub_account_id'][$i],
                    'work_order_id' => $data['credit_work_order_id'][$i],
                    'work_order_site_detail_id' => !empty($data['credit_work_order_site_detail_id'][$i]) ? $data['credit_work_order_site_detail_id'][$i] : 0,
                    'type' => 'Cr',
                    'amount' => $data['credit_account_amount'][$i],
                    'narration' => $data['credit_narration'][$i],
                    'credit_period' => !empty($data['credit_credit_period'][$i]) ? $data['credit_credit_period'][$i] : 0,
                    'bank_name' => !empty($data['credit_bank_name'][$i]) ? $data['credit_bank_name'][$i] : null,
                    'check_no' => !empty($data['credit_check_no'][$i]) ? $data['credit_check_no'][$i] : null,
                    'check_mature_date' => !empty($data['credit_check_mature_date'][$i]) ? $data['credit_check_mature_date'][$i] : null,
                    'bank_account_name' => !empty($data['credit_bank_ac_name'][$i]) ? $data['credit_bank_ac_name'][$i] : null,
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
            $voucher->delete();
        }
        return "done";
    }
}
