<?php

namespace App\Http\Middleware;

use App\Traits\RedisBreaker;
use Closure;
use Illuminate\Support\Facades\Log;
use Predis\Client;

class BreakerMiddleware
{
    use RedisBreaker;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $url = $request->getPathInfo();
//        $redis = new Client();
//        $redis->set($url.'-checkTime',1,'EX',30);
//        return response()->json([
//            'statusCode' => 499,
//            'msg' => '111111111111'
//        ]);
        //检测断路器是否开启
        if ($this->getBreakerStatus($url) == true){
            return response()->json([
                'statusCode' => 499,
                'msg' => '1 close'
            ]);
        }
        //关闭状态的话，查看是否在检测阈值
        $redis = new Client();
        Log::info('aa');
        $checkTime = $redis->exists($url.'-checkTime');
        Log::info('bb');
        if (!empty($checkTime)){
            Log::info('cc');
            //还在30s监测内 判断失败阈值是否超过设定
            $failNum = $redis->get($url.'-checkNum');
            Log::info('dd');
            if ($failNum >= $this->failNum){
                //开启断路器
                $this->openBreaker($url);
                return response()->json([
                    'statusCode' => 499,
                    'msg' => '2 close'
                ]);
            }
        }else{
            Log::info('ee');
            $this->closeBreaker($url);
        }

        return $next($request);
    }
}
