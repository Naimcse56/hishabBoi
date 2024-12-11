<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\SaleFactory;
use App\Models\User;

class Sale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    
    protected static function newFactory(): SaleFactory
    {
        //return SaleFactory::new();
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

    public function sale_details()
    {
        return $this->hasMany(SaleDetail::class);
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
