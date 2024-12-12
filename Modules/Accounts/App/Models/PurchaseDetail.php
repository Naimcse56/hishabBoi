<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\PurchaseDetailFactory;

class PurchaseDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    
    protected static function newFactory(): PurchaseDetailFactory
    {
        //return PurchaseDetailFactory::new();
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class)->withDefault();
    }
}
