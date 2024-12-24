<?php

namespace Modules\Base\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Base\Database\factories\GeneralSettingFactory;

class GeneralSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['value'];
    
    protected static function newFactory(): GeneralSettingFactory
    {
        //return GeneralSettingFactory::new();
    }
}
