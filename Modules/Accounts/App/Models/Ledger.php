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
        return $this->hasMany(Ledger::class, "parent_id", "id")->with(['categories:id,parent_id,name,code,type,acc_type,is_cost_center,view_in_trial,view_in_bs,view_in_is,level','ledger_balances:id,ledger_id,branch_id,date,debit,credit,sub_concern_id','categories.parent:id,name,code','pending_transactions:id,ledger_id,branch_id,date,type,amount,is_approve,sub_concern_id']);
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
}
