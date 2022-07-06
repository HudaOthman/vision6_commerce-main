<?php

namespace App\Models;

use App\Traits\Trans;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes, Trans;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getFinalPriceAttribute()
    {
        if($this->sale_price) {
            return $this->sale_price;
        }

        return $this->price;
    }

    public function setViewsAttribute() {
        return $this->attributes['views'] = 100;
    }

    public function getUrlAttribute()
    {
        return asset('uploads/images/products/'.$this->image);
    }
}
