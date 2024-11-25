<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\VoucherFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Voucher extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "vouchers";

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    
    protected static function newFactory(): VoucherFactory
    {
        //return VoucherFactory::new();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, "voucher_id", "id");
    }

    public function transactionsWithTrashed()
    {
        return $this->hasMany(Transaction::class, "voucher_id", "id")->withTrashed();
    }

    public function getTypeNameAttribute()
    {
        if ($this->type == "others") {
            return "JV".$this->f_year.$this->txn_id;
        }
        else if ($this->type == "contra") {
            return "CNT".$this->f_year.$this->txn_id;
        }
        else if ($this->type == "cash") {
            return "CV".$this->f_year.$this->txn_id;
        }
        else if ($this->type == "rcv_cash") {
            return "RVC".$this->f_year.$this->txn_id;
        }
        else if ($this->type == "pay_cash") {
            return "PVC".$this->f_year.$this->txn_id;
        }
        else if ($this->type == "bank") {
            return "BV".$this->f_year.$this->txn_id;
        }
        else if ($this->type == "rcv_bank") {
            return "RVB".$this->f_year.$this->txn_id;
        }
        else if ($this->type == "pay_bank") {
            return "PVB".$this->f_year.$this->txn_id;
        }
        else if ($this->type == "pay") {
            return "PV".$this->f_year.$this->txn_id;
        }
        else if ($this->type == "rec") {
            return "RV".$this->f_year.$this->txn_id;
        }
        else if ($this->type == "purchase") {
            return "P".$this->f_year.$this->txn_id;
        }
        else if ($this->type == "sales") {
            return "S".$this->f_year.$this->txn_id;
        }
        else {
            return strtoupper(str_replace('_','',$this->type)).$this->f_year.$this->txn_id;
        }
    }

    public function getTypeDetailsAttribute()
    {
        if ($this->type == "others") {
            return "JOURNAL VOUCHER";
        }
        else if ($this->type == "contra") {
            return "CONTRA VOUCHER";
        }
        else if ($this->type == "rcv_bank" || $this->type == "rcv_cash" || $this->type == "rcv") {
            return "CREDIT VOUCHER";
        }
        else if ($this->type == "pay_bank" || $this->type == "pay_cash" || $this->type == "pay") {
            return "DEBIT VOUCHER";
        }
        else if ($this->type == "sales") {
            return "SALES VOUCHER";
        }
        else if ($this->type == "purchase") {
            return "PURCHASE VOUCHER";
        }
        else {
            return strtoupper(str_replace('_',' ',$this->type));
        }
    }

    public function referable()
    {
        return $this->morphTo()->withDefault();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault(['name'=>'N/A']);
    }

    public function updator()
    {
        return $this->belongsTo(User::class, 'updated_by')->withDefault(['name'=>'N/A']);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by')->withDefault(['name'=>'N/A']);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by')->withDefault(['name'=>'N/A']);
    }

    public function finalizer()
    {
        return $this->belongsTo(User::class, 'final_by')->withDefault(['name'=>'N/A']);
    }
}
