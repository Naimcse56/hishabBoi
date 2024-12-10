<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\AccountConfigurationFactory;

class AccountConfiguration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['value','name'];
    
    protected static function newFactory(): AccountConfigurationFactory
    {
        //return AccountConfigurationFactory::new();
    }
}
