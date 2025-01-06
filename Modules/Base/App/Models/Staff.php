<?php

namespace Modules\Base\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Base\Database\factories\StaffFactory;
use Modules\Accounts\App\Models\SubLedger;
use App\Models\User;

class Staff extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    
    protected static function newFactory(): StaffFactory
    {
        //return StaffFactory::new();
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = auth()->user()->id ?? null;
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->user()->id ?? null;
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault(['name'=>'N/A']);
    }

    public function updator()
    {
        return $this->belongsTo(User::class, 'updated_by')->withDefault(['name'=>'N/A']);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault(['name'=>'N/A']);
    }

    public function department()
    {
        return $this->belongsTo(Department::class)->withDefault(['name'=>'N/A']);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class)->withDefault(['name'=>'N/A']);
    }

    public function morph()
    {
        return $this->morphOne(SubLedger::class, 'morphable');
    }
}
