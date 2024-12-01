<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\WorkOrderSiteDetailFactory;

class WorkOrderSiteDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = "work_order_sites";
    protected $guarded = ['id'];
    
    protected static function newFactory(): WorkOrderSiteDetailFactory
    {
        //return WorkOrderSiteDetailFactory::new();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function work_order()
    {
        return $this->belongsTo(WorkOrder::class)->withDefault(['order_name'=>'N/A']);
    }
}
