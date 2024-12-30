<?php

namespace Modules\Accounts\App\Repository\Eloquents;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Modules\Accounts\App\Models\Voucher;
use Modules\Accounts\App\Models\VoucherComment;
use Modules\Accounts\App\Models\DayCloseFiscalYear;
use Modules\Accounts\App\Models\AccountingBillInfo;
use Carbon\Carbon;

class VouchersRepository
{
    public function listForDataTable($amount)
    {
        
        if (auth()->user()->employee || auth()->id() == 1) {
            return Voucher::with(['transactions','transactions.ledger:id,name,code','transactions.sub_ledger:id,name,code','transactions.work_order'])
                            ->where('is_approve', 0)
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

    public function listForRejectedVoucherAccountant()
    {        
        if (auth()->user()->employee || auth()->id() == 1) {
            return Voucher::with(['transactions:id,voucher_id,ledger_id,sub_ledger_id,type','transactions.ledger:id,name','transactions.sub_ledger:id,name'])
                            ->where('is_approve', 2)
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
        $voucher->delete();
        return "done";
    }

    // Voucher Checking and approval From here
    public function approveStatus($id)
    {
        $voucher = Voucher::findOrFail($id);
        if ($voucher->is_approve != 1) {
            foreach ($voucher->transactions as $transaction) {
                if ($transaction->payment_id > 0) {
                    $transaction->payment->update(['is_approve' => 1]);
                }
            }
            $voucher->transactions()->update(['is_approve' => 1]);
            $voucher->update(['is_approve' => 1, 'approved_by' => auth()->user()->id]);
            if ($voucher->referable) {
                if ($voucher->referable->morphs->where('is_approve', 1)->sum('amount') >= $voucher->referable->payable_amount) {
                    $voucher->referable->update(['payment_status' => 'Paid']);
                } elseif ($voucher->referable->morphs->where('is_approve', 1)->sum('amount') < $voucher->referable->payable_amount) {
                    $voucher->referable->update(['payment_status' => 'Partial']);
                }
            }
        }
        return $voucher;
    }

    public function deleteApproved($id)
    {
        $voucher = Voucher::findOrFail($id);
        if ($voucher->is_approve == 1) {
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
}
