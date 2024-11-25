<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\WorkOrderEstimationCostFactory;
use Modules\Accounts\App\Models\Ledger;
use Modules\Accounts\App\Models\WorkOrder;

class WorkOrderEstimationCost extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['work_order_id','ledger_id','estimated_amount','actual_cost'];
    
    protected static function newFactory(): WorkOrderEstimationCostFactory
    {
        //return WorkOrderEstimationCostFactory::new();
    }

    public function ledger()
    {
        return $this->belongsTo(Ledger::class, "ledger_id", "id")->withDefault();
    }

    public function work_order()
    {
        return $this->belongsTo(WorkOrder::class)->withDefault(['order_name'=>'N/A']);
    }
}
