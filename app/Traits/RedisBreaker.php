<?php

namespace App\Traits;



use Illuminate\Support\Facades\Log;
use Predis\Client;

trait RedisBreaker
{
    public $open_time = 30;
    public $around_open_time_num = 5;
    public $failNum = 5;

    /**
     * 判断断路器是否开启
     * author:cyt 2020/4/18
     * @param $url
     * @return bool
     */
    public function getBreakerStatus($url){
        //差找redis 这个接口URL断路器状态
        $redis = $this->getRedis();
        $res = $redis->exists($url.'-openBreaker');
        Log::info('getBreakerStatus',[$res]);
        if (empty($res)){
            return false;
        }
        return true;
    }

    //返回redis实例
    public function getRedis(){
        return new Client();
    }

    /**
     * 开启断路器，设定过期时间
     * author:cyt 2020/4/18
     * @param $url
     * @return mixed
     */
    public function openBreaker($url){
        $redis = $this->getRedis();
        //开启断路器 30s
        $res = $redis->expire($url.'-openBreaker',30);
//        $res = $redis->set($url.'-openBreaker',1,'EX',30);
        return $res;
    }

    /**
     * 关闭断路器
     * author:cyt 2020/4/18
     * @param $url
     * @return mixed
     */
    public function closeBreaker($url){
        $redis = $this->getRedis();
        //清除这个url的断路器
        $res = $redis->expire($url.'-openBreaker',0);
//        $res = $redis->set($url.'-openBreaker',1,'EX',0);
//        $res = $redis->set($url.'-checkTime',1,'EX',0);
//        $res = $redis->set($url.'-checkNum',1,'EX',0);
        return $res;
    }

    //控制器异常调用 操作断路器状态
    public function handleBreaker($url){
        $redis = $this->getRedis();
        //是否处于监控状态
        Log::info('000');
        $checkTime = $redis->exists($url.'-checkTime');
//        $checkTime = $redis->get($url.'-checkTime');
        Log::info('handleBreaker-checkTime',[$checkTime]);
        if ($checkTime){
            $redis->incrby($url.'-checkNum',1);
            $failNum = $redis->get($url.'-checkNum');
            //失败次数是否超过阈值
            if ($failNum >= $this->failNum){
                //开启断路器
                $this->openBreaker($url);
            }else{
                //没超过失败次数+1
                $redis->incrby($url.'-checkNum',1);
            }
        }else{
            //没处在监控状态的，就让变为监控状态并设置过期时间 并失败次数+1
            Log::info('1111');
//            $redis->expire($url.'-checkTime',30);
            $redis->set($url.'-checkTime',1,'EX',30);
            Log::info('2222');
            $redis->incrby($url.'-checkNum',1);
            Log::info('333');
        }

    }
}
