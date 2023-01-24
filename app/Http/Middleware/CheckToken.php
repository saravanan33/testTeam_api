<?php

namespace App\Http\Middleware;

use App\Exceptions\Handler;
use Closure;
use Illuminate\Http\Request;

class CheckToken{


    public function handle(Request $request, Closure $closure){
        $requestData  = $request->all();
        $apiKey  = $request->header();

    }
}