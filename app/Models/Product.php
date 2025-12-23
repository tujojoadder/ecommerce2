<?php

namespace App\Models;

use App\Helpers\Traits\StockTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, StockTrait;
    protected $fillable = [
        'name',
        'image',
        'description',
        'buying_price',
        'selling_price',
        'wholesale_price',
        'unit_id',
        'color_id',
        'size_id',
        'brand_id',
        'opening_stock',
        'carton',
        'group_id',
        'stock_warning',
        'custom_barcode_no',
        'buy_quantity',
        'sale_quantity',
        'return_quantity',
        'in_stock',
        'created_by',
        'information',
        'specification',
        'guarantee',
        'is_bestsell',
        'is_special',
        'is_newarrival',
        'is_mostreview',
        'meta_seo',
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(ProductUnit::class, 'unit_id', 'id');
    }

    public function color()
    {
        return $this->belongsTo(ProductAsset::class, 'color_id', 'id');
    }
    public function size()
    {
        return $this->belongsTo(ProductAsset::class, 'size_id', 'id');
    }
    public function brand()
    {
        return $this->belongsTo(ProductAsset::class, 'brand_id', 'id');
    }
    public function group()
    {
        return $this->belongsTo(ProductGroup::class, 'group_id', 'id');
    }
    public function stockCount($id)
    {
        return $this->stock($id);
    }
    // product total buys
    public function purchases()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    // product total sales
    public function invoices()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function prices()
    {
        return $this->hasMany(PurchaseItem::class, 'product_id', 'id');
    }

    // protected $appends = ['group_name', 'brand_name', 'size_name', 'color_name', 'unit_name', 'asset_name'];
    public function getGroupNameAttribute()
    {
        return $this->group->name ?? '';
    }

    public function getBrandNameAttribute()
    {
        return $this->brand->name ?? '';
    }

    public function getSizeNameAttribute()
    {
        return $this->size->name ?? '';
    }
    public function getColorNameAttribute()
    {
        return $this->color->name ?? '';
    }

    public function getUnitNameAttribute()
    {
        return $this->unit->name ?? '';
    }

    public function getAssetNameAttribute()
    {
        return $this->color->name ?? $this->size->name ?? $this->brand->name ?? '';
    }

    public function getLastBuyingPriceAttribute()
    {
        return $this->prices()->latest()->first()->buying_price ?? 0;
    }

    public function getLastSellingPriceAttribute()
    {
        return $this->prices()->latest()->first()->selling_price ?? 0;
    }

    public function hasAnyTransaction()
    {
        return $this->purchases->count() > 0 || $this->invoices->count() > 0;
    }

    public function toArray()
    {
        $array = parent::toArray();

        unset($array['purchases']);
        unset($array['invoices']);
        unset($array['unit']);
        unset($array['color']);
        unset($array['size']);
        unset($array['brand']);
        unset($array['group']);

        return $array;
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }


}
