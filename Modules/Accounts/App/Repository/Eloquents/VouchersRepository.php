<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Modules\Accounts\App\Models\Voucher;
use Modules\Accounts\App\Models\VoucherComment;
use Modules\Accounts\App\Models\DayCloseFiscalYear;
use Modules\Accounts\App\Models\AccountingBillInfo;
use Modules\Accounts\App\Events\LedgerBalanceEvent;
use Carbon\Carbon;

class VouchersRepository
{
    public function listForDataTable($amount)
    {
        
        if (auth()->user()->employee || auth()->id() == 1) {
            return Voucher::with(['transactions','transactions.ledger:id,name,code','transactions.sub_ledger:id,name,code','transactions.work_order'])
                            ->where('is_approve', 0)
                            ->where('is_initial_checked',1)
                            ->whereNotIn('panel',['intercom_loan'])
                            ->when($amount > 0, function ($q) use ($amount) {
                                return $q->where('amount',$amount);
                            })->orderBy('id','asc');
        } else {
            abort(404);
        }
    }
    public function listForApprovedDataTable()
    {
        
        if (auth()->user()->employee || auth()->id() == 1) {
            return Voucher::where('is_approve','!=', 0)->orderBy('id','asc');
        } else {
            abort(404);
        }
    }
    public function listForRejectedVoucherUnitHead()
    {
        
        if (auth()->user()->employee || auth()->id() == 1) {
            return Voucher::with(['transactions:id,voucher_id,ledger_id,sub_ledger_id,type','transactions.ledger:id,name','transactions.sub_ledger:id,name'])
                            ->where('is_initial_checked', 2)
                            ->whereNotIn('panel',['intercom_loan'])
                            ->orderBy('id','asc');
        } else {
            abort(404);
        }
    }
    public function listForRejectedVoucherAccountant()
    {
        
        if (auth()->user()->employee || auth()->id() == 1) {
            return Voucher::with(['transactions:id,voucher_id,ledger_id,sub_ledger_id,type','transactions.ledger:id,name','transactions.sub_ledger:id,name'])
                            ->whereNotIn('panel',['intercom_loan'])
                            ->where('is_approve', 2)
                            ->orderBy('id','asc');
        } else {
            abort(404);
        }
    }
    public function listForInitialCheckDataTable($amount)
    {
        if (auth()->user()->employee || auth()->id() == 1) {
            return Voucher::with(['transactions','transactions.ledger:id,name,code','transactions.sub_ledger:id,name,code','transactions.work_order'])
                            ->where('is_approve','!=', 1)
                            ->where('is_initial_checked','!=', 1)
                            ->whereNotIn('panel',['intercom_loan'])
                            ->when($amount > 0, function ($q) use ($amount) {
                                return $q->where('amount',$amount);
                            })
                            ->orderBy('id','asc');
        } else {
            abort(404);
        }
    }
    public function listForVerificationDataTable($start_date, $end_date, $type)
    {
        
        if (auth()->user()->employee || auth()->id() == 1) {
            $dates = DayCloseFiscalYear::where('is_closed', 1)->get(['from_date'])->pluck(['from_date'])->toArray();
            return Voucher::with(['transactions','transactions.ledger:id,name,code','transactions.sub_ledger:id,name,code','transactions.work_order'])
                            ->where('is_approve',1)
                            ->where('is_verified',0)
                            ->whereBetween('date',[Carbon::createFromFormat('d/m/Y', $start_date)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $end_date)->format('Y-m-d')])
                            ->whereIn('type',['pay_bank','pay_cash','pay','rcv_bank','rcv_cash','rcv'])
                            ->when($type != "all", function ($q) use ($type) {
                                return $q->whereIn('type',[$type]);
                            })
                            ->orderBy('id','asc');
        } else {
            abort(404);
        }
    }
    public function listForVerificationObservationDataTable()
    {
        
        if (auth()->user()->employee || auth()->id() == 1) {
            $dates = DayCloseFiscalYear::where('is_closed', 1)->get(['from_date'])->pluck(['from_date'])->toArray();
            return Voucher::with(['transactions','transactions.ledger:id,name,code','transactions.sub_ledger:id,name,code','transactions.work_order'])
                            ->where('is_approve',1)
                            ->whereIn('date',$dates)
                            ->whereIn('type',['pay_bank','pay_cash','pay','rcv_bank','rcv_cash','rcv'])
                            ->whereHas('voucher_comments', function($q){
                                $q->where('observe_type', 1);
                            })
                            ->orderBy('id','desc')
                            ->select('id','date','f_year','txn_id','type','amount','narration','is_verified','any_audit_ovservation');
        } else {
            abort(404);
        }
    }
    public function listForFinalizeObservationDataTable()
    {
        
        if (auth()->user()->employee || auth()->id() == 1) {
            $dates = DayCloseFiscalYear::where('is_closed', 1)->get(['from_date'])->pluck(['from_date'])->toArray();
            return Voucher::with(['transactions:id,voucher_id,ledger_id,sub_ledger_id,type','transactions.ledger:id,name','transactions.sub_ledger:id,name'])
                            ->where('is_approve',1)
                            ->whereIn('date',$dates)
                            ->whereIn('type',['pay_bank','pay_cash','pay','rcv_bank','rcv_cash','rcv'])
                            ->whereHas('voucher_comments', function($q){
                                $q->where('observe_type', 2);
                            })
                            ->orderBy('id','desc');
        } else {
            abort(404);
        }
    }
    public function listForFinalizeDataTable($start_date, $end_date, $type)
    {
        if (auth()->user()->employee || auth()->id() == 1) {
            $dates = DayCloseFiscalYear::where('is_closed', 1)->get(['from_date'])->pluck(['from_date'])->toArray();
            return Voucher::with(['transactions','transactions.ledger:id,name,code','transactions.sub_ledger:id,name,code','transactions.work_order'])
                            ->where('is_approve',1)
                            ->where('is_verified',1)
                            ->where('is_final',0)
                            ->whereBetween('date',[Carbon::createFromFormat('d/m/Y', $start_date)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $end_date)->format('Y-m-d')])
                            ->whereIn('type',['pay_bank','pay_cash','pay','rcv_bank','rcv_cash','rcv'])
                            ->when($type != "all", function ($q) use ($type) {
                                return $q->whereIn('type',[$type]);
                            })
                            ->orderBy('id','asc');
        } else {
            abort(404);
        }
    }

    public function findById($id)
    {
        return Voucher::with(['transactions','transactions.work_order','transactions.ledger','transactions.sub_ledger'])->findOrFail($id);
    }

    public function updateApprovedNarration($data, $id)
    {
        $voucher = $this->findById($id);
        if ($voucher->date == app('day_closing_info')->from_date) {
            $voucher->update(['narration' => $data['narration_voucher']]);
            foreach ($voucher->transactions as $transaction) {
                $transaction->update(['narration' => $data['narration'][$transaction->id]]);
            }
        }        
        return $voucher;
    }

    public function delete($id)
    {
        $voucher = $this->findById($id);
        $voucher->transactions()->delete();
        // $voucher->accounting_bill_info()->delete();
        $voucher->delete();
        return "done";
    }

    // Voucher Checking and approval From here
    public function approveStatus($id)
    {
        $voucher = Voucher::with(['transactions:id,amount,type,ledger_id,sub_ledger_id,branch_id,voucher_id,work_order_id,sub_concern_id,check_no,accounting_additional_information_id','transactions.work_order','transactions.ledger:id,type','transactions.cheque_detail'])->findOrFail($id);
        if ($voucher->is_approve != 1) {
            $voucher->transactions()->update(['is_approve' => 1]);
            foreach ($voucher->transactions()->where('check_no', '!=', null)->get() as $transaction) {
                $transaction->cheque_detail->update(['is_clear' => 1]);
            }
            $voucher->update(['is_approve' => 1, 'approved_by' => auth()->user()->id]);
            if ($voucher->work_order_id > 0 && !in_array($voucher->type, ['sales','purchase'])) {
                $work_order = $voucher->work_order;
                if ($work_order->sub_ledger->ledger->type == 1 || $work_order->sub_ledger->ledger->type == 3) {
                    $actual_cost = $voucher->transactions->where('ledger_id', $work_order->ledger_id)->where('type','Cr')->sum('amount');
                } else {
                    $actual_cost = $voucher->transactions->where('ledger_id', $work_order->ledger_id)->where('type','Dr')->sum('amount');
                }
                $work_order->update(['actual_cost' => $work_order->actual_cost + $actual_cost]);
            }
            if ($voucher->accounting_bill_info && ($voucher->type == "pay_bank" || $voucher->type == "pay_cash" || $voucher->type == "rcv_bank" || $voucher->type == "rcv_cash")) {
                $bill_info = $voucher->accounting_bill_info;
                $bill_info->update(['paid_amount' => $bill_info->paid_amount + $voucher->amount]);
            }
            Event::dispatch(new LedgerBalanceEvent($voucher));
        }
        return $voucher;
    }

    public function deleteApproved($id)
    {
        $voucher = Voucher::with(['transactions:id,amount,type,ledger_id,sub_ledger_id,branch_id,voucher_id,work_order_id,sub_concern_id','transactions.work_order','transactions.ledger:id,type'])->findOrFail($id);
        if ($voucher->is_approve == 1) {
            if ($voucher->work_order_id > 0 && !in_array($voucher->type, ['sales','purchase'])) {
                $work_order = $voucher->work_order;
                if ($work_order->sub_ledger->ledger->type == 1 || $work_order->sub_ledger->ledger->type == 3) {
                    $actual_cost = $voucher->transactions->where('ledger_id', $work_order->ledger_id)->where('type','Cr')->sum('amount');
                } else {
                    $actual_cost = $voucher->transactions->where('ledger_id', $work_order->ledger_id)->where('type','Dr')->sum('amount');
                }
                $work_order->update(['actual_cost' => $work_order->actual_cost - $actual_cost]);
            }
            foreach ($voucher->transactions as $key => $transaction) {
                $dr_amount = $transaction->type == "Dr" ? $transaction->amount : 0;
                $cr_amount = $transaction->type == "Cr" ? $transaction->amount : 0;
                if ($transaction->sub_concern_id > 0) {
                    $balance = LedgerBalance::where('date', $voucher->date)->where('branch_id', $transaction->branch_id)->where('sub_concern_id', $transaction->sub_concern_id)->where('ledger_id', $transaction->ledger_id)->where('is_closed', 0)->first();
                } else {
                    $balance = LedgerBalance::where('date', $voucher->date)->where('branch_id', $transaction->branch_id)->where('ledger_id', $transaction->ledger_id)->where('is_closed', 0)->first();
                }
                if ($balance) {
                    $balance->update([
                        'debit'=> $transaction->type == "Dr" ? $balance->debit - $dr_amount : $balance->debit,
                        'credit'=> $transaction->type == "Cr" ? $balance->credit - $cr_amount : $balance->credit,
                    ]);
                } 
                if ($transaction->sub_ledger_id > 0) {
                    $party_balance = SubLedgerBalance::where('date', $voucher->date)->where('branch_id', $transaction->branch_id)->where('sub_ledger_id', $transaction->sub_ledger_id)->first();
                    if ($party_balance) {
                        $party_balance->update([
                            'debit'=> $transaction->type == "Dr" ? $party_balance->debit - $dr_amount : $party_balance->debit,
                            'credit'=> $transaction->type == "Cr" ? $party_balance->credit - $cr_amount : $party_balance->credit,
                        ]);
                    }
                }
            }
            $voucher->transactions()->delete();
            $voucher->delete();
        }
    }

    public function rejectStatus($id, $comment)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->update(['is_approve' => 2, 'approved_by' => auth()->user()->id, 'rejection_comment' => $comment]);
        $voucher->transactions()->update(['is_approve' => 2]);
        return $voucher;
    }

    public function listForSelect($search, $type)
    {
        $items = Voucher::query();
        if ($search != '') {
            $items = $items->whereLike(['txn_id', 'date'], $search);
        } 
        if ($type != "all") {
            $items = $items->where('type',$type);
        }
        $items = $items->paginate(10,['id','txn_id','type','f_year']);
        $response = [];
        foreach($items as $item){
            $response[]  =[
                'id'    => $item->txn_id,
                'text'  => $item->TypeName
            ];            
        }
        $data['results'] =  $response;
        if ($items->count() > 0)
        {
            $data['pagination'] =  ["more" => true];
        }
        return $data;
    }

    public function initialVerifyStatus($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->update(['is_initial_checked' => 1,  'initial_checked_by' => auth()->user()->id]);
        return $voucher;
    }

    public function initialRejectStatus($id, $comment)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->update(['is_initial_checked' => 2, 'initial_checked_by' => auth()->user()->id, 'rejection_comment' => $comment]);
        return $voucher;
    }

    public function verifyStatus($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->update(['is_verified' => 1, 'any_audit_ovservation' => 0,  'verified_by' => auth()->user()->id]);
        return $voucher;
    }

    public function finalizeStatus($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->update(['is_final' => 1, 'any_final_ovservation' => 0,  'final_by' => auth()->user()->id]);
        return $voucher;
    }

    public function observationEntry($id, $comment, $view_type = null)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->update(['any_audit_ovservation' => 1, 'verified_by' => auth()->user()->id]);
        if ($view_type == "list") {
            if (VoucherComment::where('voucher_id', $id)->where('comment', $comment)->first() == null) {
                return VoucherComment::create([
                    'voucher_id' => $id,
                    'user_id' => auth()->id(),
                    'date' => now(),
                    'comment' => $comment,
                    'observe_type' => 1,
                ]);
            }
        } else {
            return VoucherComment::create([
                'voucher_id' => $id,
                'user_id' => auth()->id(),
                'date' => now(),
                'comment' => $comment,
                'observe_type' => 1,
            ]);
        }
    }

    public function finalObservationEntry($id, $comment, $view_type = null)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->update(['any_final_ovservation' => 1, 'verified_by' => auth()->user()->id]);
        if ($view_type == "list") {
            if (VoucherComment::where('voucher_id', $id)->where('comment', $comment)->first() == null) {
                return VoucherComment::create([
                    'voucher_id' => $id,
                    'user_id' => auth()->id(),
                    'date' => now(),
                    'comment' => $comment,
                    'observe_type' => 2,
                ]);
            }
        } else {
            return VoucherComment::create([
                'voucher_id' => $id,
                'user_id' => auth()->id(),
                'date' => now(),
                'comment' => $comment,
                'observe_type' => 2,
            ]);
        }
    }
}
