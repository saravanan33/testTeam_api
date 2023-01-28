<?php

namespace App\Http\Middleware;

use App\Exceptions\Handler;
use Closure;
use Illuminate\Http\Request;
use App\Models\ApiDetails\ApiDetails;
class CheckToken{


    public function handle(Request $request, Closure $closure){
        $requestData  = $request->all();
        $hearder  = $request->header();
        $responseData = []; 
        $responseData['status'] = 'failed';
        $responseData['status_code'] = 301;

        $apiKey = isset($hearder['x-api-key'][0])&&!empty($hearder['x-api-key'][0])?$hearder['x-api-key'][0]:'';
        $expireTime = isset($hearder['expire-time'][0])&&!empty($hearder['expire-time'][0])?$hearder['expire-time'][0]:'';
        $apiDetailsCheck = ApiDetails::where('api_key',$apiKey)->where('status','A');
        if(!empty($apiDetailsCheck->first())){
            $checkApiKey = $apiDetailsCheck->first();
            $expireDateTime = $checkApiKey['expire_date'];
            if(time()+$expireTime < strtotime($expireDateTime)){
                return $closure($request);
            }
            else{
                $apiDetailsCheck->update(['expire_date'=>date('Y:m:d H:i:s',time()+$expireTime),'updated_at'=>date('Y:m:d H:i:s')]);
                return $closure($request);
            }
        }
        else{
            $responseData['status'] = 'Token Invalid';
        }
        return response()->json($responseData);


    }
}