<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\TransactionFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Accounts\App\Models\Ledger;
use Modules\Accounts\App\Models\SubLedger;
use Modules\Accounts\App\Models\Voucher;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "transactions";
    protected $with = ['sub_ledger:id,name','ledger:id,name,ac_no,code','work_order_site_detail:id,site_name,est_budget'];

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    
    protected static function newFactory(): TransactionFactory
    {
        //return TransactionFactory::new();
    }

    public function sub_concern()
    {
        return $this->belongsTo(SubConcern::class)->withDefault([]);
    }

    public function ledger()
    {
        return $this->belongsTo(Ledger::class, "ledger_id", "id")->withDefault();
    }

    public function sub_ledger()
    {
        return $this->belongsTo(SubLedger::class, "sub_ledger_id", "id")->withDefault();
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, "voucher_id", "id")->withDefault();
    }

    public function cheque_detail()
    {
        return $this->belongsTo(ChequeBookDetail::class, "check_no", "cheque_no")->withDefault();
    }

    public function scopeBalanceAmount($query,$type)
    {
        if ($type == 'today'){
            return $query->whereDate('date',Carbon::today());
        } elseif ($type == 'week'){
            return $query->whereBetween('date',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($type == 'month'){
            return $query->whereMonth('date',Carbon::now());
        }
        return $query;
    }

    public function work_order()
    {
        return $this->belongsTo(WorkOrder::class)->withDefault(['order_name'=>'N/A']);
    }

    public function work_order_site_detail()
    {
        return $this->belongsTo(WorkOrderSiteDetail::class)->withDefault(['site_name'=>'']);
    }
}
