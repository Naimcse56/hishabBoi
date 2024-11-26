<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\SubLedgerFactory;

class SubLedger extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    
    protected static function newFactory(): SubLedgerFactory
    {
        //return SubLedgerFactory::new();
    }

    public function sub_ledger_type()
    {
        return $this->belongsTo(SubLedgerType::class,'sub_ledger_type_id','id')->withDefault(['name'=>'N/A']);
    }

    public function ledger()
    {
        return $this->belongsTo(Ledger::class)->withDefault(['name'=>'N/A']);
    }

    public function morphable()
    {
        return $this->morphTo()->withDefault();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, "sub_ledger_id", "id")->where('is_approve',1);
    }

    public function all_transactions()
    {
        return $this->hasMany(Transaction::class, "sub_ledger_id", "id")->where('is_approve', 0);
    }

    public function getBalanceAmountAttribute()
    {
        if ($this->ledger->type == 1 || $this->ledger->type == 3) {
            $balance = $this->transactions->where('type', 'Dr')->sum('amount') - $this->transactions->where('type', 'Cr')->sum('amount');
        } else {
            $balance = $this->transactions->where('type', 'Cr')->sum('amount') - $this->transactions->where('type', 'Dr')->sum('amount');
        }

        return $balance;
    }

    public function BalanceAmountTillDate($fromDate)
    {
        if ($this->ledger->type == 1 || $this->ledger->type == 3) {
            $balance = $this->transactions->where('date', '<' ,$fromDate)->where('type', 'Dr')->sum('amount') - $this->transactions->where('date', '<' ,$fromDate)->where('type', 'Cr')->sum('amount');
        } else {
            $balance = $this->transactions->where('date', '<' ,$fromDate)->where('type', 'Cr')->sum('amount') - $this->transactions->where('date', '<' ,$fromDate)->where('type', 'Dr')->sum('amount');
        }

        return $balance;
    }

    public function DebitBalanceAmountBetweenDate($fromDate, $toDate)
    {
        return $this->transactions->whereBetween('date', array($fromDate, $toDate))->where('type', 'Dr')->sum('amount');
    }

    public function CreditBalanceAmountBetweenDate($fromDate, $toDate)
    {
        return $this->transactions->whereBetween('date', array($fromDate, $toDate))->where('type', 'Cr')->sum('amount');
    }

    public function BalanceAmountTillDateByType($fromDate, $type)
    {
        if ($type == "customer" || $type == "member") {
            return $this->transactions->where('date', '<' ,$fromDate)->where('type', 'Dr')->sum('amount') - $this->transactions->where('date', '<' ,$fromDate)->where('type', 'Cr')->sum('amount');
        }
        if ($type == "supplier") {
            return $this->transactions->where('date', '<' ,$fromDate)->where('type', 'Cr')->sum('amount') - $this->transactions->where('date', '<' ,$fromDate)->where('type', 'Dr')->sum('amount');
        }
    }

    public function DebitBalanceAmountBetweenDateByLedger($fromDate, $toDate, $ledger_id)
    {
        return $this->transactions->where('ledger_id', $ledger_id)->whereBetween('date', array($fromDate, $toDate))->where('type', 'Dr')->sum('amount');
    }

    public function CreditBalanceAmountBetweenDateByLedger($fromDate, $toDate, $ledger_id)
    {
        return $this->transactions->where('ledger_id', $ledger_id)->whereBetween('date', array($fromDate, $toDate))->where('type','Cr')->sum('amount');
    }

    public function BalanceAmountTillDateByTypeByLedger($fromDate, $type, $ledger_id)
    {
        if ($type == "customer" || $type == "member") {
            return $this->transactions->where('ledger_id', $ledger_id)->where('date', '<' ,$fromDate)->where('type', 'Dr')->sum('amount') - $this->transactions->where('ledger_id', $ledger_id)->where('date', '<' ,$fromDate)->where('type','Cr')->sum('amount');
        }
        if ($type == "supplier") {
            return $this->transactions->where('ledger_id', $ledger_id)->where('date', '<' ,$fromDate)->where('type','Cr')->sum('amount') - $this->transactions->where('ledger_id', $ledger_id)->where('date', '<' ,$fromDate)->where('type', 'Dr')->sum('amount');
        }
    }

    public function NonApprovedDebitBalanceAmountBetweenDateByLedger($fromDate, $toDate, $ledger_id)
    {
        return $this->all_transactions()->where('type', 'Dr')->where('ledger_id', $ledger_id)->whereBetween('date', array($fromDate, $toDate))->sum('amount');
    }

    public function NonApprovedCreditBalanceAmountBetweenDateByLedger($fromDate, $toDate, $ledger_id)
    {
        return $this->all_transactions()->where('type', 'Cr')->where('ledger_id', $ledger_id)->whereBetween('date', array($fromDate, $toDate))->sum('amount');
    }

    public function NonApprovedBalanceAmountTillDateByTypeByLedger($fromDate, $type, $ledger_id)
    {
        if ($type == "customer" || $type == "member") {
            return $this->all_transactions()->where('ledger_id', $ledger_id)->where('date', '<' ,$fromDate)->where('type', 'Dr')->sum('amount') - $this->all_transactions()->where('type', 'Cr')->where('date', '<' ,$fromDate)->sum('amount');
        }
        if ($type == "supplier") {
            return $this->all_transactions()->where('ledger_id', $ledger_id)->where('date', '<' ,$fromDate)->where('type', 'Cr')->sum('amount') - $this->all_transactions()->where('type', 'Dr')->where('date', '<' ,$fromDate)->sum('amount');
        }
    }
}
