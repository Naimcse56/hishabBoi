<?php

namespace Modules\Base\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Base\Database\factories\CurrencyFactory;

class Currency extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name','code','symbol'];
    
    protected static function newFactory(): CurrencyFactory
    {
        //return CurrencyFactory::new();
    }
}
