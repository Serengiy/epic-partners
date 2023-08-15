<?php

namespace App\Models;

use App\Models\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory; use HasFilter;
    protected $guarded = false;
    protected $table = 'products';
    protected $with = ['categories'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products', 'product_id','category_id');
    }
}
