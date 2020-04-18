<?php

namespace App\Http\Controllers;

use App\Traits\RedisBreaker;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Predis\Client;

class BreakerController extends Controller
{
    use RedisBreaker;

    //pdf 导出
    public function testBreaker(Request $request){

        $data = 1;
        try{
            $d = 1 / 0;
        }catch (\Exception $exception){
            //断路器处理
            Log::info('cachein');
            $this->handleBreaker($request->getPathInfo());
            $data = '降级数据';
            Log::info('testBreaker-exception',[$request->getPathInfo()]);
        }
        return $data;
    }
}
