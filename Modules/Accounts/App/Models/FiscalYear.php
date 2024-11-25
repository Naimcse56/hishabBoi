<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\FiscalYearFactory;
use App\Models\User;

class FiscalYear extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    
    protected static function newFactory(): FiscalYearFactory
    {
        //return FiscalYearFactory::new();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'closed_by')->withDefault(['name'=>'N/A']);
    }
}
