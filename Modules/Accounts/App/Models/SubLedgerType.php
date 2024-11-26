<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\SubLedgerTypeFactory;

class SubLedgerType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name','is_for'];
    
    protected static function newFactory(): SubLedgerTypeFactory
    {
        //return MemberTypeFactory::new();
    }
}
