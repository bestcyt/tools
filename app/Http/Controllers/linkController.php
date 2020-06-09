<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

require_once public_path().'/phpQuery/phpQuery/phpQuery.php';
class linkController extends Controller
{
    public $host = 'http://localhost:9515';//'http://localhost:4444/wd/hub'
    public $capabilities ;
    public $driver;
    public $searchUrl = 'https://www.baidu.com/s?wd=';
    public $searchUrl360 = 'https://www.so.com/s?q=';
    public $searchUrlSg = 'https://www.sogou.com/web?query=';
    public $baiduUrl = 'https://www.baidu.com';
    public function __construct()
    {

    }

    //phpquery 文档 https://blog.csdn.net/lxw1844912514/article/details/100029473
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

    //从word文档导入词
    public function inputWords(){
        $words = [
            '王勇','千古一帝','登基','包子玉皇大帝'
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

    //正则匹配，看页面是否有搜索结果数据
    public function ifPageHasData($data){
        preg_match_all('/很抱歉，没有找到与/',$data['html'],$hasDataBaidu);
        preg_match_all('/抱歉，未找到和/',$data['html'],$hasData360);
        preg_match_all('/站内没有找到能和.*匹配的内容/',$data['html'],$hasDataSg);
        if (count($hasDataBaidu[0]) > 0 || count($hasData360[0]) > 0 || count($hasDataSg[0]) > 0){
            //页面没有搜索结果
            return false;
        }
        return true;
    }

    //从文档读出字符串
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

    //爬搜索页面html
    public function getWordP(){
        ini_set('max_execution_time', '0');
        $words = DB::table('words')->get();
        //遍历words 合成搜索链接，执行webdriver ，获取页面html，排队是否有值，是否有分页，插入page表
        $data = [];
        $capabilities = DesiredCapabilities::chrome();
        $host = 'http://localhost:9515';
        $driver = RemoteWebDriver::create($host, $capabilities, 5000);
        foreach ($words as $word){
            sleep(1);
            $search_link = $this->searchUrl.'site%3Amy.4399.com%20'.$word->word.'&ie=utf-8&f=8&rsv_bp=1&rsv_idx=1';
            $driver->get($search_link);
            $driver->wait(10);
            $search_link = $driver->getCurrentURL();
            $html = $driver->getPageSource();
            $data['word_id'] = $word->id;
            $data['search_link'] = $search_link;
            $data['html'] = $html;
            $data['page_no'] = 1;
            //是否页面有数据
            if($this->ifPageHasData($data)){
                $data['if_has'] = 1;
                $data['create_at'] = Carbon::now()->toDateString();
                DB::table('word_pages')->insert($data);
                //是否有多页数据 . 看page的id下是否一下一页
                preg_match_all('/<div id="page">(\s)*.*下一页/',$data['html'],$hasNextPage);
                if (count($hasNextPage[0]) > 0){
                    $i = 2;
                    while (true){
                        $driver->get($search_link);
                        $html = $driver->getPageSource();  //一定要加上这个，获取最后一页的源码，不然html会取上一页，正则出来还会一下一页，数据就多了
                        preg_match_all('/<div id="page">(\s)*.*下一页/',$html,$isHasNextPage);
                        if (count($isHasNextPage[0]) == 0){
                            break;
                        }
                        $cssSelector = '#page>a:last-of-type'; //id是page下的最后一个a标签，就是下一页链接
                        $driver->findElement(WebDriverBy::cssSelector($cssSelector))->click();
                        $driver->wait(10);
                        $search_link = $driver->getCurrentURL(); // 2
                        $html = $driver->getPageSource(); // 2
                        $data['search_link'] = $search_link;
                        $data['html'] = $html;
                        $data['page_no'] = $i ;
                        $i ++ ;
                        DB::table('word_pages')->insert($data);
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

    //便利pages表，正则获取标题(红色突出)，摘要，链接
    public function getWordsUrl(){
        $pages = DB::table('word_pages_pro')->where([
            ['if_has','=',1],
            ['if_done','=',0]
        ])->get();
        foreach ($pages as $page){
            $html = $page->html;
            //查看几条数据
            preg_match_all('/rget="_blank">.*<\/a><\/h3>/',$html,$resultCount);
            $data = [];
            if (count($resultCount[0]) > 0){
                //正则匹配里面的标题
                preg_match_all('/rget="_blank">.*<\/a><\/h3>/',$html,$titleArray);
                $titles = [];
                foreach ($titleArray[0] as $title){
                    $title = substr($title,14);  //移除 rget="_blank">
                    $title = substr($title,0,strlen($title)-9); //移除 </a></h3>
                    $titles[] = $title;
                }
                //正则匹配里面的摘要
                preg_match_all('/class="c-abstract">.*<\/div><div class="f13">/',$html,$descArray);
                $descs = [];
                foreach ($descArray[0] as $desc){
                    $desc = substr($desc,19);  //移除 class="c-abstract">
                    $desc = substr($desc,0,strlen($desc)-23); //移除 <\/div><div class="f13">
                    $descs[] = $desc;
                }
                //正则匹配里面的链接
                preg_match_all('/class="f13"><a target="_blank" href=".*" class="c-showurl"/',$html,$linkArray);
                $links = [];
                foreach ($linkArray[0] as $link){
                    $link = substr($link,37);  //移除 class="c-abstract">
                    $link = substr($link,0,strlen($link)-19); //移除 <\/div><div class="f13">
                    $links[] = $link;
                }
                //把标题，摘要，链接 放进去
                $realCount = min(count($titles),count($descs),count($links));
                for ($i=0;$i < $realCount;$i++){
                    $data[] = [
                        'title' => $titles[$i],
                        'desc' => $descs[$i],
                        'link' => $links[$i],
                        'word_id' => $page->word_id,
                        'page_no' => $page->page_no,
                        'create_at' => Carbon::now()->toDateString(),
                    ];
                }
            }
            if (count($data) > 0){
                DB::table('word_page_infos_pro')->insert($data);
            }
        }
        dd(1);
    }

    //导出csv文件
    public function csvExport(){
        echo 1;
//        header('Content-type:application/vnd.ms-Excel');
        $info = DB::table('word_page_infos')->get()->toArray();
//        echo $info[0]->title;exit();
        Excel::create('bms',function ($excel) use ($info){
            //> 这里可以创建多个 sheet 文件
            $excel->sheet('a',function ($sheet) use ($info){
                $sheet->row(1, [
                    '标题','摘要','链接',$info[0]->title
                ]);
                //> 这里处理sheet文件内容（比如填充cell数据，样式等）
//                for ($i = 0;$i<count($info);$i++){
//                    $sheet->row($i+2, [
//                        $info[$i]->title,
//                        $info[$i]->desc,
//                        $info[$i]->link,
//                    ]);
//                }

            });
        })->export('html');
        dd(1);
    }

    public function htmlExport(){
//        dd(4);
        $info = DB::table('word_page_infos_pro')
            ->leftJoin('words_pro','word_page_infos_pro.word_id','=','words_pro.id')
            ->select('words_pro.id','words_pro.word','word_page_infos_pro.*')
            ->get();
//        $jingao = DB::table('word_page_infos_pro')->where('word_id',243)->get();
//        dd($jingao);
        $data = [];
        $i = 0;
        foreach ($info as &$item){
            if (strpos($item->title,$item->word) || strpos($item->desc,$item->word)){
                $item->num = $i ++ ;
                if ($item->from == 1){
                    $item->title = str_replace("<em>","<span style=\"color:red\">",$item->title);
                    $item->title = str_replace("</em>","</span>",$item->title);
                    $item->desc = str_replace("<em>","<span style=\"color:red\">",$item->desc);
                    $item->desc = str_replace("</em>","</span>",$item->desc);
                }
                if ($item->from == 2 || $item->from == 3){
                    $item->title = str_replace("$item->word","<span style=\"color:red\">$item->word</span>",$item->title);
                    $item->desc = str_replace("$item->word","<span style=\"color:red\">$item->word</span>",$item->desc);
                }
                $data[] = $item;
            }
        }
        return view('htmlExport')->with('info',$data);
        dd(1);
    }

    //360 - 爬搜索页面html
    public function getWordP360(){
        ini_set('max_execution_time', '0');
        $words = DB::table('words_pro')->get();
        //遍历words 合成搜索链接，执行webdriver ，获取页面html，排队是否有值，是否有分页，插入page表
        $data = [];
        $capabilities = DesiredCapabilities::chrome();
        $host = 'http://localhost:9515';
        $driver = RemoteWebDriver::create($host, $capabilities, 5000);
        foreach ($words as $word){
            sleep(1);
            $search_link = $this->searchUrl360.'site%3Amy.4399.com%20'.$word->word.'&ie=utf-8&fr=none&src=360sou_newhome';
            $driver->get($search_link);
            $driver->wait(10);
            $search_link = $driver->getCurrentURL();
            $html = $driver->getPageSource();
            $data['word_id'] = $word->id;
            $data['search_link'] = $search_link;
            $data['html'] = $html;
            $data['from'] = 2;
            $data['page_no'] = 1;
//            //是否页面有数据
            if($this->ifPageHasData($data)){
                $data['if_has'] = 1;
                $data['create_at'] = Carbon::now()->toDateString();
                DB::table('word_pages_pro')->insert($data);
                //是否有多页数据 . 看page的id下是否一下一页
                preg_match_all('/<div id="page">(\s)*.*下一页/',$data['html'],$hasNextPage);
                if (count($hasNextPage[0]) > 0){
                    $i = 2;
                    while (true){
                        $driver->get($search_link);
                        $html = $driver->getPageSource();  //一定要加上这个，获取最后一页的源码，不然html会取上一页，正则出来还会一下一页，数据就多了
                        preg_match_all('/<div id="page">(\s)*.*下一页/',$html,$isHasNextPage);
                        if (count($isHasNextPage[0]) == 0){
                            break;
                        }
                        $cssSelector = '#page>a:last-of-type'; //id是page下的最后一个a标签，就是下一页链接
                        $driver->findElement(WebDriverBy::cssSelector($cssSelector))->click();
                        $driver->wait(10);
                        $search_link = $driver->getCurrentURL(); // 2
                        $html = $driver->getPageSource(); // 2
                        $data['search_link'] = $search_link;
                        $data['html'] = $html;
                        $data['from'] = 2;
                        $data['page_no'] = $i ;
                        $i ++ ;
                        DB::table('word_pages_pro')->insert($data);
                    }
                }
            }else{
                //页面没有搜索结果，随意录入
                $data['if_has'] = 0;
                $data['from'] = 2;
                $data['create_at'] = Carbon::now()->toDateString();
                DB::table('word_pages_pro')->insert($data);
            }
            echo $word->id;
        }
        dd('page-over');
    }
    //360 - 便利pages表，正则获取标题(红色突出)，摘要，链接
    public function getWordsUrl360(){
        $pages = DB::table('word_pages_pro')->where([
            ['if_has','=',1],
            ['if_done','=',0],
            ['from','=',2]
        ])->get();
//        dd(count($pages));
        $z = 0;
        foreach ($pages as $page){
            $z ++ ;
            echo $page->id.'bb-'."\n";
            //查看几条数据
            $data = [];
//            preg_match_all('/<ul class="result">.*<\/ul>/',$page->html,$resultHtml);
            file_put_contents(public_path().'/queryTest.html',$page->html);
            \phpQuery::newDocumentFile(public_path().'/queryTest.html');
//            dd(pq('.result')->html());
            if (!empty(pq('.result')->html())){
                Log::info('getWordsUrl360-z',[$z]);
                $re = pq('.res-list');
                foreach ($re as $item){
                    echo 'aa-'."\n";
                    $title = $desc = $link = '';
                    if (pq($item)->find('.res-desc')->text()){
                        $desc = pq($item)->find('.res-desc')->text();
                    }elseif(pq($item)->find('.res-rich>.res-comm-con')->text()){
                        $desc = pq($item)->find('.res-rich>.res-comm-con')->text();
                    }elseif (pq($item)->find('.res-rich')->text()){
                        $desc = pq($item)->find('.res-rich')->text();
                    }
                    $title = pq($item)->find('.res-title>a')->text();
                    $link = pq($item)->find('.res-title>a')->attr('href');
                    $data[] = [
                        'title'=>$title,
                        'desc'=>$desc,
                        'link'=>$link,
                        'word_id' => $page->word_id,
                        'page_no' => $page->page_no,
                        'from' => 2,
                        'create_at' => Carbon::now()->toDateString()
                    ];
                }
;                if (count($data) > 0){
                    DB::table('word_page_infos_pro')->insert($data);
                }
            }else{
                dd($z,$page->id);
            }
        }
        dd(1);
    }

    //搜狗 - 爬搜索页面html- 1w多页，觉了
    public function getWordPSg(){
        ini_set('max_execution_time', '0');
        $words = DB::table('words_pro')->get();
        //遍历words 合成搜索链接，执行webdriver ，获取页面html，排队是否有值，是否有分页，插入page表
        $data = [];
        $capabilities = DesiredCapabilities::chrome();
        $host = 'http://localhost:9515';
        $driver = RemoteWebDriver::create($host, $capabilities, 5000);
        foreach ($words as $word){
            sleep(1);
            $search_link = $this->searchUrlSg.'site%3Amy.4399.com%20'.$word->word.'&ie=utf8&from=index-nologin&s_from=index';
            $driver->get($search_link);
            $driver->wait(10);
            $search_link = $driver->getCurrentURL();
            $html = $driver->getPageSource();
            $data['word_id'] = $word->id;
            $data['search_link'] = $search_link;
            $data['html'] = $html;
            $data['from'] = 3;
            $data['page_no'] = 1;
//            //是否页面有数据
            if($this->ifPageHasData($data)){
                $data['if_has'] = 1;
                $data['create_at'] = Carbon::now()->toDateString();
                DB::table('word_pages_pro')->insert($data);
                //是否有多页数据 . 看page的id下是否一下一页
                preg_match_all('/<div class="p" id="pagebar_container">(\s)*.*下一页/',$data['html'],$hasNextPage);
                if (count($hasNextPage[0]) > 0){
                    $i = 2;
                    while (true){
                        $driver->get($search_link);
                        $html = $driver->getPageSource();  //一定要加上这个，获取最后一页的源码，不然html会取上一页，正则出来还会一下一页，数据就多了
                        preg_match_all('/<div class="p" id="pagebar_container">(\s)*.*下一页/',$html,$isHasNextPage);
                        if (count($isHasNextPage[0]) == 0){
                            break;
                        }
                        $cssSelector = '#pagebar_container>a:last-of-type'; //id是page下的最后一个a标签，就是下一页链接
                        $driver->findElement(WebDriverBy::cssSelector($cssSelector))->click();
                        $driver->wait(10);
                        $search_link = $driver->getCurrentURL(); // 2
                        $html = $driver->getPageSource(); // 2
                        $data['search_link'] = $search_link;
                        $data['html'] = $html;
                        $data['from'] = 3;
                        $data['page_no'] = $i ;
                        $i ++ ;
                        DB::table('word_pages_pro')->insert($data);
                    }
                }
            }else{
                //页面没有搜索结果，随意录入
                $data['if_has'] = 0;
                $data['from'] = 3;
                $data['create_at'] = Carbon::now()->toDateString();
                DB::table('word_pages_pro')->insert($data);
            }
            echo $word->id;
        }
        dd('sg-page-over');
    }
    //搜狗 - 便利pages表，正则获取标题(红色突出)，摘要，链接
    public function getWordsUrlSg(){
        $pages = DB::table('word_pages_pro')->where([
            ['if_has','=',1],
            ['if_done','=',0],
            ['from','=',3]
        ])
            ->offset(10000)->limit(2000)
            ->get();
        $z = 0;
        foreach ($pages as $page){
            $z ++ ;
            //查看几条数据
            $data = [];
            file_put_contents(public_path().'/querySg.html',$page->html);
            \phpQuery::newDocumentFile(public_path().'/querySg.html');
            if (!empty(pq('.results')->html())){
                Log::info('getWordsUrSg-z',[$z]);
                $re = pq('.rb');
                foreach ($re as $item){
                    Log::info('aaaa',[1111]);
                    echo 'pageid-'.$page->id."\n";
                    $title = $desc = $link = '';
                    $title = pq($item)->find('.pt>a')->text();
                    if (empty($title)){ //搜狗有的时候前面的字也会rb的class
                        continue;
                    }
                    $link = pq($item)->find('.pt>a')->attr('href');
                    if (pq($item)->find('.ft')->text()){
                        $desc = pq($item)->find('.ft')->text();
                    }elseif(pq($item)->find('.rb>.ft')->text()){
                        $desc = pq($item)->find('.rb>.ft')->text();
                    }
                    $data[] = [
                        'title'=>$title,
                        'desc'=>$desc,
                        'link'=>$link,
                        'word_id' => $page->word_id,
                        'page_no' => $page->page_no,
                        'from' => 3,
                        'create_at' => Carbon::now()->toDateString()
                    ];
                }
                if (count($data) > 0){
                    DB::table('word_page_infos_pro')->insert($data);
                }
            }else{
                dd($page->id.'缺失页面内容');
            }
        }
        dd('sg-page-info-over');
    }
}
