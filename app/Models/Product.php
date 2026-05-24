<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['product_category_id', 'sku', 'name', 'slug', 'description', 'price', 'stock', 'is_active'];

    public function attributesOptions()
    {
        return $this->belongsToMany(AttributeOption::class);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
