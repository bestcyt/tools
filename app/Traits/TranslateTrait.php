<?php

namespace App\Traits;



trait TranslateTrait
{
    //中英文翻译trait by cyt 2019.7.9

    use GuzzleHttpTrait;

    //谷歌翻译链接
    public $googleUrl = 'http://translate.google.cn/translate_a/single?client=gtx&dt=t&dj=1&ie=UTF-8&sl=auto';
    public $googleTl = '&tl=';
    public $googleQ = '&q=';
    public $lanType = [
        'en' => 'en-hk',
        'cn' => 'zh_cn',
    ];

    //有道翻译链接
    public $youDaoUrl = 'http://fanyi.youdao.com/translate?&doctype=json&type=AUTO&i=';

    /**
     * 翻译调的方法，en表示要翻译成英文，cn表示翻译成中文；by cyt 2019.7.9
     * @param $name
     * @param string $type
     * @return bool|mixed|string
     */
    public function translate($name,$type = 'en'){

        //暂时只支持中英文翻译
        if ($type != 'en' && $type != 'cn'){
            return false;
        }
        $url = ['youDao','google'];
        if (!empty($name)){
            $q = $this->googleQ.$name;
            switch ($type){
                case 'en':
                    //谷歌接口后面有了guzzle再说
                    $tl = $this->googleTl.$this->lanType['en'];
                    $url['youDao'] = $this->youDaoUrl.$name; //有道翻译
                    $url['google'] = $this->googleUrl.$tl.$q;//谷歌翻译
                    break;

                case 'cn':
                    $tl = $this->googleTl.$this->lanType['cn'];
                    $url['youDao'] = $this->youDaoUrl.$name; //有道翻译
                    $url['google'] = $this->googleUrl.$tl.$q;//谷歌翻译
                    break;
            }
        }

        return $this->translateHandle($url);
    }

    /**
     * 不同api的处理方法
     * @param $url
     * @return mixed|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function translateHandle($url){
        $newName = 'failed';
        //尝试不同接口
        //有道
        if (!empty($url['youDao'])){
            $res = $this->getGuzzleHttp($url['youDao'],[]);
            if (!empty($res)){
                $newName = str_replace(' ','_',$res['translateResult'][0][0]['tgt']);
            }
        }
        //谷歌
        if (!empty($url['google'])){
            $res = $this->getGuzzleHttp($url['google'],[]);
            if (!empty($res)){
                $newName = str_replace(' ','_',$res['sentences'][0]['trans']);
            }
        }
        return $newName;
    }
}
