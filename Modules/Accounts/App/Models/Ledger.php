<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\LedgerFactory;

class Ledger extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    
    protected static function newFactory(): LedgerFactory
    {
        //return LedgerFactory::new();
    }

    public function categories()
    {
        return $this->hasMany(Ledger::class, "parent_id", "id")->with(['categories:id,parent_id,name,code,type,acc_type,view_in_trial,view_in_bs,view_in_is,level','categories.parent:id,name,code','pending_transactions:id,ledger_id,date,type,amount,is_approve']);
    }

    public function parent()
    {
        return $this->belongsTo(Ledger::class, "parent_id")->withDefault();
    }

    public function childrenCategories()
    {
        return $this->hasMany(Ledger::class, "parent_id", "id");
    }

    public function sub_ledgers()
    {
        return $this->hasMany(SubLedger::class, "ledger_id", "id");
    }

    public function categories_base_on_transaction()
    {
        return $this->hasMany(Ledger::class, "parent_id", "id");
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, "ledger_id", "id")->wherehas('voucher',function($q) {
                                $q->where('is_approve',1);
                            });
    }

    public function all_transactions()
    {
        return $this->hasMany(Transaction::class, "ledger_id", "id");
    }

    public function pending_transactions()
    {
        return $this->hasMany(Transaction::class, "ledger_id", "id")->where('is_approve', 0);
    }

    public function getTypeNameAttribute()
    {
        if ($this->type == 1) {
            return "Asset";
        }elseif ($this->type == 2) {
            return "Liability";
        }elseif ($this->type == 3) {
            return "Expense";
        }elseif ($this->type == 4) {
            return "Income";
        }elseif ($this->type == 5) {
            return "Equity";
        }else {
            return "X";
        }
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = auth()->user()->id ?? null;
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->user()->id ?? null;
        });
    }

    public function getBalanceAmountAttribute()
    {
        if ($this->type == 1 || $this->type == 3) {
            return $this->transactions->where('type', 'Dr')->sum('amount') - $this->transactions->where('type', 'Cr')->sum('amount');
        } else {
            return $this->transactions->where('type', 'Cr')->sum('amount') - $this->transactions->where('type', 'Dr')->sum('amount');
        }
    }

    public function BalanceAmountBetweenDate($fromDate, $toDate)
    {
        if ($this->type == 1 || $this->type == 3) {
            return $this->transactions->where('type', 'Dr')->whereBetween('date', array($fromDate, $toDate))->sum('amount') - $this->transactions->where('type', 'Cr')->whereBetween('date', array($fromDate, $toDate))->sum('amount');
        } else {
            return $this->transactions->where('type', 'Cr')->whereBetween('date', array($fromDate, $toDate))->sum('amount') - $this->transactions->where('type', 'Dr')->whereBetween('date', array($fromDate, $toDate))->sum('amount');
        }
    }

    public function NonApprovedBalanceAmountBetweenDate($fromDate, $toDate, $sub_concern_id = null)
    {
        if ($this->type == 1 || $this->type == 3) {
            return $this->pending_transactions->where('type', 'Dr')->whereBetween('date', array($fromDate, $toDate))->sum('amount') - $this->pending_transactions->where('type', 'Cr')->whereBetween('date', array($fromDate, $toDate))->sum('amount');
        } else {
            return $this->pending_transactions->where('type', 'Cr')->whereBetween('date', array($fromDate, $toDate))->sum('amount') - $this->pending_transactions->where('type', 'Dr')->whereBetween('date', array($fromDate, $toDate))->sum('amount');
        }
    }

    public function BalanceAmountTillDate($fromDate)
    {
        if ($this->type == 1 || $this->type == 3) {
            return $this->transactions->where('type', 'Dr')->where('date', '<' ,$fromDate)->sum('amount') - $this->transactions->where('type', 'Cr')->where('date', '<' ,$fromDate)->sum('amount');
        } else {
            return $this->transactions->where('type', 'Cr')->where('date', '<' ,$fromDate)->sum('amount') - $this->transactions->where('type', 'Dr')->where('date', '<' ,$fromDate)->sum('amount');
        }
    }

    public function DebitBalanceAmountTillDate($fromDate)
    {
        return $this->transactions->where('type', 'Dr')->where('date', '<' ,$fromDate)->sum('debit');
    }

    public function CreditBalanceAmountTillDate($fromDate)
    {
        return $this->transactions->where('type', 'Cr')->where('date', '<' ,$fromDate)->sum('credit');
    }

    public function DebitBalanceAmountOnDate($fromDate)
    {
        return $this->transactions->where('type', 'Dr')->where('date' ,$fromDate)->sum('debit');
    }

    public function CreditBalanceAmountOnDate($fromDate)
    {
        return $this->transactions->where('type', 'Cr')->where('date' ,$fromDate)->sum('credit');
    }

    public function TransactionBalanceAmountBetweenDate($fromDate, $toDate, $work_order_id = null)
    {
        if ($this->type == 1 || $this->type == 3) {
            return $this->transactions->when($work_order_id != null, function ($q) use ($work_order_id) {
                    return $q->where('work_order_id', $work_order_id);
                })->whereBetween('date', array($fromDate, $toDate))->where('type', 'Dr')->sum('amount') - $this->transactions->when($work_order_id != null, function ($q) use ($work_order_id) {
                    return $q->where('work_order_id', $work_order_id);
                })->whereBetween('date', array($fromDate, $toDate))->where('type', 'Cr')->sum('amount');
        } else {
            return $this->transactions->when($work_order_id != null, function ($q) use ($work_order_id) {
                    return $q->where('work_order_id', $work_order_id);
                })->whereBetween('date', array($fromDate, $toDate))->where('type', 'Cr')->sum('amount') - $this->transactions->when($work_order_id != null, function ($q) use ($work_order_id) {
                    return $q->where('work_order_id', $work_order_id);
                })->whereBetween('date', array($fromDate, $toDate))->where('type', 'Dr')->sum('amount');
        }
    }

}
