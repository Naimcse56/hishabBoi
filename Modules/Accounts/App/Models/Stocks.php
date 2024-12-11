<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\StocksFactory;

class stock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    
    protected static function newFactory(): StockFactory
    {
        //return StocksFactory::new();
    }

    public function product()
    {
        return $this->belongsTo(Produc::class)->withDefault();
    }
}
