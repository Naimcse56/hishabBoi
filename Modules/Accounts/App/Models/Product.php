<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\ProductFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    
    protected static function newFactory(): ProductFactory
    {
        //return ProductFactory::new();
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

    public function product_unit()
    {
        return $this->belongsTo(ProductUnit::class)->withDefault();
    }

    public function purchase_ledger()
    {
        return $this->belongsTo(Ledger::class, "purchase_ledger_id", "id")->withDefault();
    }

    public function selling_ledger()
    {
        return $this->belongsTo(Ledger::class, "selling_ledger_id", "id")->withDefault();
    }
}
