<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\SaleDetailFactory;

class SaleDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    
    protected static function newFactory(): SaleDetailFactory
    {
        //return SaleDetailFactory::new();
    }

    public function product()
    {
        return $this->belongsTo(Produc::class)->withDefault();
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class)->withDefault();
    }
}
