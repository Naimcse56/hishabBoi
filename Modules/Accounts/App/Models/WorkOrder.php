<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\WorkOrderFactory;

class WorkOrder extends Model
{
    use HasFactory;
    protected $with = ['sub_ledger','work_order_estimation_costs'];
    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    
    protected static function newFactory(): WorkOrderFactory
    {
        //return WorkOrderFactory::new();
    }

    public function sub_ledger()
    {
        return $this->belongsTo(SubLedger::class)->withDefault(['name'=>'N/A']);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function work_order_estimation_costs()
    {
        return $this->hasMany(WorkOrderEstimationCost::class);
    }

    public function work_order_site_details()
    {
        return $this->hasMany(WorkOrderSiteDetail::class);
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
}
