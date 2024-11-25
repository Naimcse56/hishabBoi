<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\DayCloseFiscalYearFactory;
use App\Models\User;

class DayCloseFiscalYear extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    
    protected static function newFactory(): DayCloseFiscalYearFactory
    {
        //return DayCloseFiscalYearFactory::new();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'closed_by')->withDefault(['name'=>'N/A']);
    }
}
