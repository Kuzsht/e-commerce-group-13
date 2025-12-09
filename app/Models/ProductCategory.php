<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    protected $fillable = ['parent_id', 'image', 'name', 'slug', 'tagline', 'description'];

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }

    // Accessor untuk URL gambar lengkap
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        if (Str::contains($this->image, 'images/categories')) {
            return asset($this->image);
        }

        return asset('images/categories/' . $this->image);
    }
}