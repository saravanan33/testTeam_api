<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeaturedProducts\FeaturedProducts;
use App\Models\ProductCategorys\ProductCategory;
use Illuminate\Support\Facades\Validator;

class FeaturedProductsController extends Controller{

    // Feature product List
    public function list(Request $request){
        $requestData = $request->all();
        $response = [];
        $response['status'] = 'failed';
        $response['status_code'] = 301;
        $response['message'] = 'List Data Empty';

        $listData = FeaturedProducts::where('featured_products.status','!=','D')
                    ->select('featured_products.*','product_category.product_category_name')
                    ->Join('product_category','product_category.product_category_id','featured_products.product_category_id')
                    ->where('product_category.status','A');
        if(isset($requestData['product_name']) && !empty($requestData['product_name'])){
            $listData = $listData->where('featured_products.product_name','like',"%".$requestData['product_name']."%");
        }
        if(isset($requestData['product_category_id']) && !empty($requestData['product_category_id'])){
            $listData = $listData->where('featured_products.product_category_id',$requestData['product_category_id']);
        }
        if(isset($requestData['product_price']) && !empty($requestData['product_price'])){
            $listData = $listData->where('featured_products.product_price','like','%'.$requestData['product_price'].'%');
        }
        if(isset($requestData['sku_code']) && !empty($requestData['sku_code'])){
            $listData = $listData->where('featured_products.sku_code','like','%'.$requestData['sku_code'].'%');
        }
        if(isset($requestData['status']) && !empty($requestData['status'])){
            $listData = $listData->where('featured_products.status',$requestData['status']);
        }
        if(isset($requestData['currency_code']) && !empty($requestData['currency_code'])){
            $listData = $listData->where('featured_products.currency_code',$requestData['currency_code']);
        }

        $totalCount = $listData->count();
        if(isset($requestData['ascending']) && isset($requestData['orderBy']) && $requestData['orderBy'] != ''){
            $sorting = 'DESC';
            if($requestData['ascending'] == "1")
                $sorting = 'ASC';
            $listData = $listData->orderBy($requestData['orderBy'],$sorting);
        }else{
            $listData = $listData->orderBy('featured_products.updated_at','DESC');
        }

        $requestData['limit']   = (isset($requestData['limit']) && $requestData['limit'] != '')? $requestData['limit'] : '10';
        $requestData['page']    = (isset($requestData['page']) && $requestData['page'] != '')? $requestData['page'] : '1';
        $start                  = ($requestData['page']*$requestData['limit']) - $requestData['limit'];                  
        //record count
        $totalCount  = $listData->take($requestData['limit'])->count();
        // Get Record
        $listData       = $listData->offset($start)->limit($requestData['limit'])->get()->toArray();

        //count pagination
        $count = $start;
        if(!empty($listData)){
            $response['status'] = 'failed';
            $response['status_code'] = 301;
            $response['message'] = 'List Data Empty';
            foreach($listData as $value){
                $tempArray = [];
                $tempArray['s_no'] = ++$count;
                $tempArray['featured_products_id'] = $value['featured_products_id'];
                $tempArray['encrypted_id'] = base64_encode($value['featured_products_id']);
                $tempArray['product_name'] = $value['product_name'];
                $tempArray['product_category_name'] = $value['product_category_name'];
                $tempArray['product_description'] = $value['product_description'];
                $tempArray['product_price'] = $value['product_price'];
                $tempArray['currency_code'] = $value['currency_code'];
                $tempArray['sku_code'] = $value['sku_code'];
                $tempArray['status'] = $value['status'];
                $response['data'][] = $tempArray;
            }
        }
        return response()->json($response);
    }

    //create new feture product
    public function index(){
        $product['status']='success';
        $data = ProductCategory::pluck('product_category_name','product_category_id')->toArray();
        $tempData = [];
        foreach($data as $key=>$value){
            $tempArray = [];
            $tempArray['value'] = $key;
            $tempArray['label'] = $value;
            $tempData[] = $tempArray;
        }
        $product['data'] = $tempData;
        return response()->json($product);
    }

    //store product feature
    public function store(Request $request){

        $requestData = $request->all();

        $response = [];
        $response['status']  = 'failed';
        $response['code']    = 301;
        $response['message'] = 'validation failed';

        $validation = Validator::make($requestData,[
            'product_name' => 'required',
            'product_category_id'=> 'required',
            'product_description'=> 'required',
            'product_price' => 'required',
            'currency_code'=>'required'
        ]);

        if($validation->fails()){
            $response['error']   = $validation->errors();
            return response()->json($response);
        }
        $productObject = new FeaturedProducts;

        $UniqueCheck = $productObject->where('product_name',$requestData['product_name'])->first();
        if(!empty($UniqueCheck)){
        $response['error']   = 'Product Name Already Exist';

            return response()->json($response);
        }
        $productObject->product_name        = $requestData['product_name'];
        $productObject->product_category_id = $requestData['product_category_id'];
        $productObject->product_description = $requestData['product_description'];
        $productObject->product_price       = $requestData['product_price'];
        $productObject->currency_code       = $requestData['currency_code'];
        $productObject->sku_code            = $requestData['product_category_id'].time().rand(1000,9999);
        $productObject->status              = 'A';
        $productObject->created_at          = date('Y-m-d H:i:s');
        $productObject->updated_at          = date('Y-m-d H:i:s');

        $storeData = $productObject->save();
        if($storeData){
            $response['status']     = 'success';
            $response['code']       = 200;
            $response['message']    = 'Data Stored Successfully';
        }
        return response()->json($response);
    }
    public function edit($id){

        $id = base64_decode($id);
        $response = [];
        $response['status'] = 'failed';
        $response['status_code'] = 301;
        $response['message'] = 'edit data failed';

        $productFeature = FeaturedProducts::where('featured_products_id',$id)->first();
        if(!empty($productFeature)){
            $tempData = $productFeature->toArray();

            $response['status'] = 'success';
            $response['status_code'] = 200;
            $response['message'] = 'edit data success';
            $response['data']['featured_products_id'] = $tempData['featured_products_id'];
            $response['data']['product_name'] = $tempData['product_name'];
            $response['data']['product_category_id'] = $tempData['product_category_id'];
            $response['data']['product_description'] = $tempData['product_description'];
            $response['data']['product_price'] = $tempData['product_price'];
            $response['data']['currency_code'] = $tempData['currency_code'];
            $response['data']['sku_code'] = $tempData['sku_code'];
            $response['data']['status'] = $tempData['status'];
            $response['data']['created_at'] = $tempData['created_at'];
            $response['data']['updated_at'] = $tempData['updated_at'];
        }
        return response()->json($response);
    }
    public function update(Request $request,$id){
        $id = base64_decode($id);
        $requestData = $request->all();

        $response = [];
        $response['status']  = 'failed';
        $response['code']    = 301;
        $response['message'] = 'validation failed';

        $validation = Validator::make($requestData,[
            'product_name' => 'required',
            'product_category_id'=> 'required',
            'product_description'=> 'required',
            'product_price' => 'required',
            'currency_code'=>'required'
        ]);

        if($validation->fails()){
            $response['error']   = $validation->errors();
            return response()->json($response);
        }
        $productObject = new FeaturedProducts;

        $tempArray =[];
        
        $UniqueCheck =$productObject->where('featured_products_id',$id)->where('product_category_id',$requestData['product_category_id'])->first();
        
        if(empty($UniqueCheck)){
            $tempArray['sku_code']        = $requestData['product_category_id'].time().rand(1000,9999);
        }
        $tempArray['product_name']        = $requestData['product_name'];
        $tempArray['product_category_id'] = $requestData['product_category_id'];
        $tempArray['product_description'] = $requestData['product_description'];
        $tempArray['product_price']       = $requestData['product_price'];
        $tempArray['currency_code']       = $requestData['currency_code'];
        $tempArray['updated_at']          = date('Y-m-d H:i:s');

        $storeData = $productObject->where('featured_products_id',$id)->update($tempArray);

        if($storeData){
            $response['status']     = 'success';
            $response['code']       = 200;
            $response['message']    = 'Data Updated Successfully';
        }
        else{
            $response['message']    = 'Data Store Failed';
        }
        return response()->json($response);

    }
    public function changeStatus($id,$status){
        $id = base64_decode($id);
        $statusChanges = FeaturedProducts::where('featured_products_id',$id)->update(['status'=>$status]);
        if($statusChanges){
            $response['status']     = 'success';
            $response['code']       = 200;
            $response['message']    = 'Data Updated Successfully';
        }
        else{
            $response['status']  = 'failed';
            $response['code']    = 301;
            $response['message'] = 'Change Status Failed';
        }
        return response()->json($response);

    }
}