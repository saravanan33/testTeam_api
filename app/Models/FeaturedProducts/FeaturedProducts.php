<?php 

namespace App\Models\FeaturedProducts;

use Illuminate\Database\Eloquent\Model;

class FeaturedProducts extends Model{

    protected $table='featured_products';

    protected $primaryKey = 'featured_products_id';

    protected $fillable = ['product_name','product_category_id','product_description','product_price','currency_code','sku_code','status','creted_at','update_at'];
}

