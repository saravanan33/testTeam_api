<?php 

namespace App\Models\ProductCategorys;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model{
    protected $table = 'product_category';

    protected $primaryKey = 'product_category_id'; 

    protected $fillables = ['product_category_label','product_category_name','status','created_at','updated_at'];
    
}