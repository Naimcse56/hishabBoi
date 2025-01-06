<?php

namespace Modules\Base\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Base\Database\factories\CurrencyFactory;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name'];
    
    protected static function newFactory(): CurrencyFactory
    {
        //return CurrencyFactory::new();
    }
}
