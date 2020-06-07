<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Facebook\WebDriver\Cookie;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class linkController extends Controller
{
    public $host = 'http://localhost:9515';//'http://localhost:4444/wd/hub'
    public $capabilities ;
    public $driver;
    public $searchUrl = 'https://www.baidu.com/s?wd=';
    public $baiduUrl = 'https://www.baidu.com';
    public function __construct()
    {

    }

    public function index(){
        $html = '	    <strong><span class="fk fk_cur"><i class="c-icon c-icon-bear-p"></i></span><span class="pc">1</span></strong><a href="/s?wd=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;pn=10&amp;oq=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;ie=utf-8&amp;fenlei=256&amp;rsv_idx=1&amp;rsv_pq=b2e093d3000bb560&amp;rsv_t=5139Dnyr9jzngHlAWvua%2BDOIurYanqf7LZPhfkoMUETLzjys1X%2BOLNcTC%2Bw"><span class="fk fkd"><i class="c-icon c-icon-bear-pn"></i></span><span class="pc">2</span></a><a href="/s?wd=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;pn=20&amp;oq=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;ie=utf-8&amp;fenlei=256&amp;rsv_idx=1&amp;rsv_pq=b2e093d3000bb560&amp;rsv_t=5139Dnyr9jzngHlAWvua%2BDOIurYanqf7LZPhfkoMUETLzjys1X%2BOLNcTC%2Bw"><span class="fk"><i class="c-icon c-icon-bear-pn"></i></span><span class="pc">3</span></a><a href="/s?wd=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;pn=30&amp;oq=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;ie=utf-8&amp;fenlei=256&amp;rsv_idx=1&amp;rsv_pq=b2e093d3000bb560&amp;rsv_t=5139Dnyr9jzngHlAWvua%2BDOIurYanqf7LZPhfkoMUETLzjys1X%2BOLNcTC%2Bw"><span class="fk fkd"><i class="c-icon c-icon-bear-pn"></i></span><span class="pc">4</span></a><a href="/s?wd=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;pn=40&amp;oq=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;ie=utf-8&amp;fenlei=256&amp;rsv_idx=1&amp;rsv_pq=b2e093d3000bb560&amp;rsv_t=5139Dnyr9jzngHlAWvua%2BDOIurYanqf7LZPhfkoMUETLzjys1X%2BOLNcTC%2Bw"><span class="fk"><i class="c-icon c-icon-bear-pn"></i></span><span class="pc">5</span></a><a href="/s?wd=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;pn=50&amp;oq=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;ie=utf-8&amp;fenlei=256&amp;rsv_idx=1&amp;rsv_pq=b2e093d3000bb560&amp;rsv_t=5139Dnyr9jzngHlAWvua%2BDOIurYanqf7LZPhfkoMUETLzjys1X%2BOLNcTC%2Bw"><span class="fk fkd"><i class="c-icon c-icon-bear-pn"></i></span><span class="pc">6</span></a><a href="/s?wd=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;pn=60&amp;oq=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;ie=utf-8&amp;fenlei=256&amp;rsv_idx=1&amp;rsv_pq=b2e093d3000bb560&amp;rsv_t=5139Dnyr9jzngHlAWvua%2BDOIurYanqf7LZPhfkoMUETLzjys1X%2BOLNcTC%2Bw"><span class="fk"><i class="c-icon c-icon-bear-pn"></i></span><span class="pc">7</span></a><a href="/s?wd=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;pn=70&amp;oq=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;ie=utf-8&amp;fenlei=256&amp;rsv_idx=1&amp;rsv_pq=b2e093d3000bb560&amp;rsv_t=5139Dnyr9jzngHlAWvua%2BDOIurYanqf7LZPhfkoMUETLzjys1X%2BOLNcTC%2Bw"><span class="fk fkd"><i class="c-icon c-icon-bear-pn"></i></span><span class="pc">8</span></a><a href="/s?wd=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;pn=80&amp;oq=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;ie=utf-8&amp;fenlei=256&amp;rsv_idx=1&amp;rsv_pq=b2e093d3000bb560&amp;rsv_t=5139Dnyr9jzngHlAWvua%2BDOIurYanqf7LZPhfkoMUETLzjys1X%2BOLNcTC%2Bw"><span class="fk"><i class="c-icon c-icon-bear-pn"></i></span><span class="pc">9</span></a><a href="/s?wd=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;pn=90&amp;oq=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;ie=utf-8&amp;fenlei=256&amp;rsv_idx=1&amp;rsv_pq=b2e093d3000bb560&amp;rsv_t=5139Dnyr9jzngHlAWvua%2BDOIurYanqf7LZPhfkoMUETLzjys1X%2BOLNcTC%2Bw"><span class="fk fkd"><i class="c-icon c-icon-bear-pn"></i></span><span class="pc">10</span></a><a href="/s?wd=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;pn=10&amp;oq=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;ie=utf-8&amp;fenlei=256&amp;rsv_idx=1&amp;rsv_pq=b2e093d3000bb560&amp;rsv_t=5139Dnyr9jzngHlAWvua%2BDOIurYanqf7LZPhfkoMUETLzjys1X%2BOLNcTC%2Bw&amp;rsv_page=1" class="n">下一页&gt;</a>
';
        $html = '<a href="/s?wd=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;pn=10&amp;oq=site%3Amy.4399.com%20%E6%B8%B8%E6%88%8F&amp;ie=utf-8&amp;fenlei=256&amp;rsv_idx=1&amp;rsv_pq=b2e093d3000bb560&amp;rsv_t=5139Dnyr9jzngHlAWvua%2BDOIurYanqf7LZPhfkoMUETLzjys1X%2BOLNcTC%2Bw"><span class="fk fkd"><i class="c-icon c-icon-bear-pn"></i></span><span class="pc">2</span></a>';
        $html = DB::table('word_pages')->where('id',3)->value('html');
//        preg_match('/>[1-9]</',$html,$href);
        echo $html;
    }
    public function test2(){
        $host = 'http://localhost:9515';
        $waitSeconds = 15;
        $capabilities = DesiredCapabilities::chrome();
        $driver = RemoteWebDriver::create($host,$capabilities,5000);
        $t = 'site:my.4399.com 登基';
        $driver->get('https://www.baidu.com/');
//        echo iconv("UTF-8","GB2312",'标题1')."：" . $driver->getTitle() . "\n";
        $driver->findElement(WebDriverBy::id('kw'))->sendKeys($t);
        $driver->findElement(WebDriverBy::id('su'))->click();
        $driver->wait(10);
        $url = $driver->getCurrentURL();
        $driver->get($url);
//        $res = DB::table('word_pages')->insert(['search_link'=>$url,'html'=>$driver->getPageSource()]);
//        $driver->quit();
        dd($url);
    }

    public function test(){
        $url = $this->baiduUrl.'/s?wd=site%3Amy.4399.com%20%E7%99%BB%E5%9F%BA&pn=10&oq=site%3Amy.4399.com%20%E7%99%BB%E5%9F%BA&ie=utf-8&fenlei=256&rsv_idx=1&rsv_pq=d0664a3b0004eea9&rsv_t=41b1iktikaOdALVGGO3GLYkNJeDpVHykSM2eMcopfVFdnWNhEOmojBCri4w';
        $host = 'http://localhost:9515';
        $waitSeconds = 15;
        $capabilities = DesiredCapabilities::chrome();
        $driver = RemoteWebDriver::create($host,$capabilities,5000);
        $driver->get($url);
        $u = $driver->getCurrentURL();
        dd($u);
    }

    public function aaa(){
//        $t = 'site%3Amy.4399.com%20张军'.'&ie=utf-8&f=8&rsv_bp=1&rsv_idx=1&ts='.rand(1,9);
        for ($i=0;$i<20;$i++){
            $t = 'site%3Amy.4399.com%20张军'.'&ie=utf-8&f=8&rsv_bp=1&rsv_idx=1';
            $host = 'http://localhost:4444/wd/hub'; // this is the default
            $host = 'http://localhost:9515'; // this is the default
            $capabilities = DesiredCapabilities::chrome();
            $driver = RemoteWebDriver::create($host, $capabilities, 5000);
            $driver->get('https://www.baidu.com/s?wd='.$t);
            $data['word'] = '张军'.rand(1,99);
            $data['search_link'] = $driver->getCurrentURL();
            $data['search_html'] = $driver->getPageSource();
            DB::table('words')->insert($data);
        }
    }

    //从word文档导入词
    public function inputWords(){
        $words = [
            '王勇','千古一帝','登基'
        ];
//        $words = $this->getWordsFromDoc();
        $data = [];
        $n = 0;
        foreach ($words as $word){
            $data[] = [
                'word'=>$word,
                'create_at'=>Carbon::now()->toDateString()
            ];
            $n ++ ;
        }
        $res = DB::table('words')->insert($data);
        dd($n);
    }

    public function getWordPages(){
        ini_set('max_execution_time', '0');
        $words = DB::table('words')->get();
        //遍历words 合成搜索链接，执行webdriver ，获取页面html，排队是否有值，是否有分页，插入page表
        $data = [];
        foreach ($words as $word){
            $link = $this->searchUrl.'site%3Amy.4399.com%20'.$word->word.'&ie=utf-8&f=8&rsv_bp=1&rsv_idx=1';
            $resDriverData = $this->getWebDriverData($link);
            $data['word_id'] = $word->id;
            $data['search_link'] = $resDriverData['search_link'];
            $data['html'] = $resDriverData['html'];
            if($this->ifPageHasData($data)){
                $data['if_has'] = 1;
                $data['create_at'] = Carbon::now()->toDateString();
                DB::table('word_pages')->insert($data);
                //查询分页数据
                $this->ifPageHasPages($data);
            }else{
                //页面没有搜索结果，随意录入
                $data['if_has'] = 0;
                $data['create_at'] = Carbon::now()->toDateString();
                DB::table('word_pages')->insert($data);
            }
            echo $word->id;
        }
    }

    //正则匹配，看页面是否有搜索结果数据
    public function ifPageHasData($data){
        preg_match_all('/很抱歉，没有找到与/',$data['html'],$hasData);
        if (count($hasData[0]) > 0){
            //页面没有搜索结果
            return false;
        }
        return true;
    }

    //正则匹配，看页面是否有分页数据，返回分页链接
    public function ifPageHasPages($data){
        //匹配是否有 分页div ，有就插入
        preg_match_all('/div id="page"/',$data['html'],$hasPage);
        if (count($hasPage[0]) > 0){
            //
            //先匹配10也内的链接插入数据库
//            preg_match_all('/<a href=.*?<span class="pc">[0-9]<\/span><\/a>/',$data['html'],$pageHref);
//            if (count($pageHref[0]) > 0){
//                foreach ($pageHref[0] as $item){
//                    //匹配里面的链接
//                    preg_match('/\/s\?wd=.*"><span/',$item,$href);
//                    $href = $this->baiduUrl.$href[0];
//                    Log::info($data['word_id'].'-href',[$href]);
//                    $driverData = $this->getWebDriverData($href);
//                    $data['search_link'] = $driverData['search_link'];
//                    Log::info($data['word_id'].'-search_link',[$data['search_link']]);
//                    //匹配里面的页码
//                    preg_match('/>[1-9]</',$item,$pageNo);
//                    $pageNo = substr($pageNo[0] , 1 , 1);
//                    $data['page_no'] = $pageNo;
//                    $data['html'] = $driverData['html'];
//                    DB::table('word_pages')->insert($data);
//                }
//            }
//            //再判断是否有上下页
//            preg_match_all('/下一页/',$data['html'],$ifHasNextPage);
//            if (!empty($ifHasNextPage[0])){
//                //有下一页，得处理模拟点击链接 @todo
//
//            }
        }
        //没有分页，就过
        return false;
    }

    public function nextPageInsert($newPageLink){

    }

    //根据链接，获取页面URL和html源码
    public function getWebDriverData($link){
        $capabilities = DesiredCapabilities::chrome();
        $host = 'http://localhost:9515';
        $driver = RemoteWebDriver::create($host, $capabilities, 5000);
        $driver->get($link);
        $driver->wait(10);
        $search_link = $driver->getCurrentURL();
        $html = $driver->getPageSource();
        $driver->quit();
        return [
            'search_link' => $search_link,
            'html' => $html,
        ];
    }

    public function getClickDriverData($html){
        $capabilities = DesiredCapabilities::chrome();
        $host = 'http://localhost:9515';
        $driver = RemoteWebDriver::create($host, $capabilities, 5000);
        $driver->findElement(WebDriverBy::id('su'))->click();
        $driver->wait(10);
        $url = $driver->getCurrentURL();
        $driver->get($url);
//        $driver->quit();
        return [
            'search_link' => $search_link,
            'html' => $html,
        ];
    }

    public function getWordsFromDoc(){
        $filename = public_path().'\test.docx';
        $striped_content = '';
        $content = '';
        $zip = zip_open($filename);
        if (!$zip || is_numeric($zip)) return false;
        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

            if (zip_entry_name($zip_entry) != "word/document.xml") continue;

            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }// end while
        zip_close($zip);
        $content = str_replace('</w:r></w:p></w:tc><w:tc>', "", $content);
        $content = str_replace('</w:b></w:rPr>', "", $content);
        $content = str_replace('<w:b><w:rPr>', "", $content);
        $content = str_replace('<w:t></w:t>', "", $content);
        $content = str_replace('</w:r></w:p>', "", $content);
        $content = str_replace('HYPERLINK', "", $content);
        $content = str_replace("\r\n", "", $content);
        $striped_content = strip_tags($content);
        $ar = explode('，',$striped_content);
        return $ar;
    }

    public function getWordP(){
        ini_set('max_execution_time', '0');
        $words = DB::table('words')->get();
        //遍历words 合成搜索链接，执行webdriver ，获取页面html，排队是否有值，是否有分页，插入page表
        $data = [];
        foreach ($words as $word){
            $link = $this->searchUrl.'site%3Amy.4399.com%20'.$word->word.'&ie=utf-8&f=8&rsv_bp=1&rsv_idx=1';

            $capabilities = DesiredCapabilities::chrome();
            $host = 'http://localhost:9515';
            $driver = RemoteWebDriver::create($host, $capabilities, 5000);
            $driver->get($link);
            $driver->wait(10);
            $search_link = $driver->getCurrentURL();
            $html = $driver->getPageSource();
//            $driver->quit();
            //$resDriverData = $this->getWebDriverData($link);
            $data['word_id'] = $word->id;
            $data['search_link'] = $search_link;
            $data['html'] = $html;
            //是否页面有数据
            if($this->ifPageHasData($data)){
                $data['if_has'] = 1;
                $data['create_at'] = Carbon::now()->toDateString();
                DB::table('word_pages')->insert($data);
                //是否有多页数据
                preg_match_all('/div id="page"/',$data['html'],$hasPage);
                if (count($hasPage[0]) > 0){
                    preg_match_all('/<a href=.*?<span class="pc">[0-9]<\/span><\/a>/',$data['html'],$pageHref);
                    //有几个页码链接
                    if (count($pageHref[0]) > 0){
                        //多页
                        for ($i=0;$i<count($pageHref[0]);$i++){
                            // 获取页码模拟点击
                            $cssSelector = '#page>a:nth-of-type('.($i+1).')';
                            $driver->findElement(WebDriverBy::cssSelector($cssSelector))->click();
                            $driver->wait(10);
                            $url = $driver->getCurrentURL();
                            $driver->get($url);
                            $html = $driver->getPageSource();
                            if (($i + 1) == count($pageHref[0])){
                                echo 'www'.$i.'-';
                                echo $html;exit();
                            }
                            $data['search_link'] = $url;
                            $data['html'] = $html;
                            $data['page_no'] = $i+2;
                            DB::table('word_pages')->insert($data);
                        }
                    }
                }
            }else{
                //页面没有搜索结果，随意录入
                $data['if_has'] = 0;
                $data['create_at'] = Carbon::now()->toDateString();
                DB::table('word_pages')->insert($data);
            }
            echo $word->id;
        }
    }
}
