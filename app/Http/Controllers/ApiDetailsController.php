<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ApiDetails\ApiDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiDetailsController extends Controller{

    public function store(Request $request){

        $requestData = $request->all();
        
        $response = [];
        
        $response['status'] = 'failed';
        $response['code']   = 301;
        $response['message']   = 'validation failed';

        $validation = Validator::make($requestData,[
            'api_key'=> 'required',
            'expire_date'=> 'required',
            'expire_time'=> 'required',
        ]);
        if ($validation->fails()) {
            $response['error']   = $validation->errors();
            return $response;
        }
        $insertData = [];
        $insertData['api_key']     = $requestData['api_key'];
        $insertData['expire_date'] = $requestData['expire_date'];
        $insertData['expire_time'] = $requestData['expire_time'];
        $insertData['status']      = 'A';
        $data = ApiDetails::insert($insertData);
        if($data){
            $response['status'] = 'success';
            $response['code']   = 200;
            $response['message']= 'Key insert successfully';
        }
        return $response;
    }
}