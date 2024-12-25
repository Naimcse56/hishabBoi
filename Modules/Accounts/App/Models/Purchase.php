<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\PurchaseFactory;
use App\Models\User;

class Purchase extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    
    protected static function newFactory(): PurchaseFactory
    {
        //return PurchaseFactory::new();
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

    public function refers()
    {
        return $this->morphMany(Voucher::class, 'referable');
    }

    public function morphs()
    {
        return $this->morphMany(Payment::class, 'morphable');
    }

    public function latestPaymentInfo($orderBy = "desc")
    {
        return $this->morphs()->orderBy('id',$orderBy)->first();
    }

    public function getDueBillAttribute()
    {
        return $this->payable_amount - $this->morphs()->where('is_approve','!=',2)->sum('amount');
    }

    public function purchase_details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function ledger()
    {
        return $this->belongsTo(Ledger::class, "ledger_id", "id")->withDefault();
    }

    public function sub_ledger()
    {
        return $this->belongsTo(SubLedger::class, "sub_ledger_id", "id")->withDefault();
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
}
