<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\QuotationDetailFactory;

class QuotationDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    
    protected static function newFactory(): QuotationDetailFactory
    {
        //return QuotationDetailFactory::new();
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class)->withDefault();
    }
}
