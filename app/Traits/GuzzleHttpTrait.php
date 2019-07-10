<?php

namespace App\Traits;

//cyt 2019.7.9

use GuzzleHttp\Client;

trait GuzzleHttpTrait
{
    public $timeOut = 10;

    /**
     * 初始化client对象 by cyt 2019.7.9
     * @return Client
     */
    public function initClient(){
        return new Client();
    }

    /**
     * guzzle的get简单封装，暂时需求 by cyt 2019.7.9
     * @param $url
     * @param array $options
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getGuzzleHttp($url,$options = []){
        $client = $this->initClient();
        $response = $client->request('GET',$url,$options);
        if ($response->getStatusCode() != 200){
            return false;
        }
        return json_decode($response->getBody(),true);
    }

    /**
     * POST 请求 by cyt，用到了再完善- -
     * @param $url
     * @param array $options
     */
    public function postGuzzleHttp($url,$options = []){

    }
}
