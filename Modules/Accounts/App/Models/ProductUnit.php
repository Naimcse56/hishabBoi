<?php

namespace Modules\Accounts\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Database\factories\ProductUnitFactory;

class ProductUnit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    
    protected static function newFactory(): ProductUnitFactory
    {
        //return ProductUnitFactory::new();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
