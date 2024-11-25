<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\MemberTypeFactory;

class MemberType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['id','name','branch_id','is_for'];
    
    protected static function newFactory(): MemberTypeFactory
    {
        //return MemberTypeFactory::new();
    }
}
