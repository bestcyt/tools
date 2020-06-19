<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

require_once public_path().'/phpQuery/phpQuery/phpQuery.php';

class CurlController extends Controller
{
    //
    public $current_from = 3; //1.百度 2.360 3.搜狗
    public $base_url = array(
        1=>'https://www.baidu.com',
        2=>'https://www.so.com',
        3=>'https://www.sogou.com',
    );
    public $query_site = 'site%3Amy.4399.com%20';
    public $s_base_url = array(
        1=>'https://www.baidu.com/s?rsv_idx=1&ie=utf-8&wd=site%3Amy.4399.com%20',
        2=>'https://www.so.com/s?ie=utf-8&fr=none&src=home_www&q=site%3Amy.4399.com%20',
        3=>'https://www.sogou.com/web?ie=utf8&from=index-nologin&s_from=index&query=site%3Amy.4399.com%20',
    );
    public $search_result_file = array(
        1=>'baidu.php',
        2=>'txz.php',
        3=>'sg.php',
    );
    public $word; //敏感词
    public $data = []; //存储最终数据
    public $from = array(//搜索来源
        1=>'百度搜索',
        2=>'360搜索',
        3=>'搜狗搜索',
    );
    // header头
    public $header = array(
        1=>array(
            "Host:www.baidu.com",
            "Content-Type:application/x-www-form-urlencoded",//post请求
            "Connection: close",
            'is_referer: http://www.baidu.com',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.97 Safari/537.36',
            'Cookie: PSTM=1590995649; BAIDUID=10ADA2DACC136414A2AC6ECA769FFB1F:FG=1; BIDUPSID=C9F15BA29292C8191BCA6044C7D455DF; BD_UPN=12314753; BDUSS=hNSElKMjcxb3ZYMy13ZEh3WVJ6MkRxcXJnZnJvbk9NRnR0elA3aHhOVnBUZjFlSVFBQUFBJCQAAAAAAAAAAAEAAACkb9Y4w867w7~Vu6hkYXkAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGnA1V5pwNVeMW; ispeed_lsm=0; BDORZ=B490B5EBF6F3CD402E515D22BCDA1598; H_PS_PSSID=31906_1457_31672_21115_31673_31715_30824_31848_26350; delPer=0; BD_CK_SAM=1; PSINO=6; BD_HOME=1; COOKIE_SESSION=4516_0_9_1_18_19_0_6_9_8_1_1_0_0_3_0_1591751741_0_1591756254%7C9%230_1_1591003847%7C1; BDRCVFR[feWj1Vr5u3D]=I67x6TjHwwYf0; MCITY=-194%3A; sugstore=1; H_PS_645EC=83716jBEEZ7ykGqrWWhZKte%2BPSZ%2FkpA2glt44i%2BhtjtmfUHD8o1%2BvI7tA2bj3xbCZKUb; BDSVRTM=17; WWW_ST=1591770796820'

        ),
        2=>array(
            "Host:www.so.com",
            "Connection: close",
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.97 Safari/537.36',
            'Cookie: QiHooGUID=4B1B7E532113AC88615DBF2F9C89E3F5.1591664591448; __guid=15484592.3768448980005392400.1591664591790.7202; webp=1; __huid=11vh3VoS9%2BEy3FBZaJvpO54TqSiw249MakaCIWFgeRb4E%3D; dpr=1; stc_ls_sohome=RQzX2jYRKh!1TRXgM(WQ; gtHuid=1; erules=p1-2%7Cecl-1; count=26'
        ),
        3=>array(
            "Host:www.sogou.com",
            "Connection: close",
            "Upgrade-Insecure-Requests: 1",
            "Accept-Language: zh-CN,zh;q=0.9",
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.97 Safari/537.36',
            'Cookie: ssuid=8048181480; sw_uuid=1562424427; ABTEST=4|1591665384|v17; IPLOC=CN3502; SUID=E2FE4D7D5118910A000000005EDEE2E8; SUV=1591667507144018; browerV=3; osV=1; pgv_pvi=1828475904; ad=6K4ZSlllll2Wc4JNlllllVEktO1lllllKUTMckllll9llllljklll5@@@@@@@@@@; taspeed=taspeedexist; pgv_si=s5539161088; SESSION_CAPTCHA=k296jmufeik6mb0eod3g2ael26; sst0=400; SNUID=1904B787FAFE5C4C6647FF4CFBFA87F2; seccodeRight=success; successCount=2|Wed, 10 Jun 2020 09:42:45 GMT; refresh=1; ld=Vkllllllll2WTmMwlllllVEk$0DlllllKUTMcklllxyllllljklll5@@@@@@@@@@; LSTMV=326%2C819; LCLKINT=3520; sct=30'
        ),
     );
    public $page_search_link = ''; //分页链接

    public function index(){
        ini_set('max_execution_time', '0');
        $words = DB::table('words')->get();
//        $words = DB::table('words_pro')->get();
        foreach ($words as $word){
            $this->word = $word->word;
            sleep(1);
            $url = $this->s_base_url[$this->current_from].urlencode($this->word);
            Log::info('word-id-url',[$word->id,$word->word,$url]);
            $this->curlGet($url);
        }
        //写入文件
        $aString = '$data = '.var_export($this->data, true).';';
        file_put_contents(public_path().'/'.$this->search_result_file[$this->current_from], $aString);
        dd($this->data);
    }

    // 发起页面请求，爬取页面数据，并判断分页，递归请求
    public function curlGet($url){
        sleep(1);
        $header = $this->header[$this->current_from];
        if ($this->current_from == 3){
            array_push($header,"Referer: https://www.sogou.com/web?ie=utf8&from=index-nologin&s_from=index&query=site%3Amy.4399.com%20%E5%8D%83%E5%8F%A4%E4%B8%80%E5%B8%9D");
        }
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $content = curl_exec($ch);
        if ($content == false){
            Log::info('curl-error',[curl_error($ch)]);
//            dd(curl_error($ch));
        }
        curl_close($ch);
        //判断是否有数据
        if (!$this->ifPageHasData($content)){
            return false;
        }
        //第一页内容直接解析，并把值丢进data
        $this->getHtmlLink($content,$this->current_from);

        //判断是否有分页
        $nextPageUrl = $this->ifHtmlHasPages($content,$this->current_from);
        Log::info('$nextPageUrl',[$nextPageUrl]);
        if ($nextPageUrl != false){
            //获取下一页链接，递归curl
            $this->curlGet($nextPageUrl);
        }
        return true;
    }

    //获取页面结果链接$from 1.百度 2.360 3.搜狗
    public function getHtmlLink($html,$from){
        if (!$this->ifPageHasData($html)){
            return false;
        }
        \phpQuery::newDocument($html);
        switch ($from){
            case 1:
                $content_left = pq('.result');//获取的是每一条结果的标签
                foreach ($content_left as $item){
                    $title = pq($item)->find('.t>a')->text();
                    $desc = pq($item)->find('.c-abstract')->text();
                    $link = pq($item)->find('.t>a')->attr('href');
                    //命中才保存
                    if (strpos($title,$this->word) !=false || strpos($desc,$this->word)!=false){
                        $re = [
                            'word'  => $this->word,
                            'title' => $title,
                            'desc'  => $desc,
                            'from'  => $this->from[$from],
                            'link'  => $link,
                        ];
                        Log::info('$n',[$re]);
                        array_push($this->data,$re);
                    }
                }
                break;
            case 2: //360搜索获取页面标题摘要链接
                $content_left = pq('.res-list');//获取的是每一条结果的标签
                dd($content_left->text());
                foreach ($content_left as $item){
                    $title = pq($item)->find('.res-title>a')->text();
                    $isDesc = pq($item)->find('.res-desc')->text();
                    if (!empty($isDesc)){
                        $desc = pq($item)->find('.res-desc')->text();
                    }else{
                        $desc = pq($item)->find('.res-rich>.res-comm-con>.res-desc')->text();
                    }
                    $link = pq($item)->find('.res-title>a')->attr('href');
                    //命中才保存
                    if (strpos($title,$this->word) !=false  || strpos($desc,$this->word) !=false ){
                        $re = [
                            'word'  => $this->word,
                            'title' => $title,
                            'desc'  => $desc,
                            'from'  => $this->from[$from],
                            'link'  => $link,
                        ];
                        Log::info('$n',[$re]);
                        array_push($this->data,$re);
                    }
                }
                break;
            case 3: //搜狗搜索获取页面标题摘要链接
                $content_left = pq('.rb');//获取的是每一条结果的标签
                Log::info('rb',[count($content_left),$content_left]);
                $i = 0;
                foreach ($content_left as $item){
                    $i ++;
                    $title = pq($item)->find('.pt>a')->text();
                    $desc = pq($item)->find('.ft')->text();
                    $link = pq($item)->find('.pt>a')->attr('href');
                    Log::info('word',[$i,$this->word]);
                    Log::info('item',[$title,$desc,$link]);
                    //命中才保存
                    if (strpos($title,$this->word) !=false  || strpos($desc,$this->word) !=false ){
                        $re = [
                            'word'  => $this->word,
                            'title' => $title,
                            'desc'  => $desc,
                            'from'  => $this->from[$from],
                            'link'  => $link,
                        ];
                        Log::info('$sg',[$re]);
                        array_push($this->data,$re);
                    }
                    Log::info('count-data',[count($this->data)]);
                }
                break;
        }
    }

    //判断页面有下一页
    public function ifHtmlHasPages($html,$from){
        $nextPageUrl = '';
        \phpQuery::newDocument($html);
        switch ($from){
            case 1: //百度判断是否有下一页
                $text = pq('#page>a:last')->text();
                if ( $text == '下一页>'){
                    $nextPageUrl = pq('#page>a:last')->attr('href');
                }
                break;
            case 2: //360判断是否有下一页
                $text = pq('#page>a:last')->text();
                if ( $text == '下一页'){
                    $nextPageUrl = pq('#page>a:last')->attr('href');
                }
                break;
            case 3: //搜狗判断是否有下一页 pagebar_container
                $text = pq('#pagebar_container>a:last')->text();
                if ( $text == '下一页'){
                    $nextPageUrl = pq('#pagebar_container>a:last')->attr('href');
                }
                break;
        }
        Log::info('ifHtmlHasPages-from',[$from,$nextPageUrl]);
        //有下一页链接，拼接url返回
        if (!empty($nextPageUrl)){
            return $this->base_url[$from].$nextPageUrl;
        }
        return false;
    }

    //判断页面是否有搜索结果
    public function ifPageHasData($html){
        preg_match_all('/很抱歉，没有找到与/',$html,$hasDataBaidu);
        preg_match_all('/抱歉，未找到和/',$html,$hasData360);
        preg_match_all('/站内没有找到能和.*匹配的内容/',$html,$hasDataSg);
        if (count($hasDataBaidu[0]) > 0 || count($hasData360[0]) > 0 || count($hasDataSg[0]) > 0){
            //页面没有搜索结果
            return false;
        }
        return true;
    }
}
