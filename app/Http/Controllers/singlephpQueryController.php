<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//require_once public_path().'/phpQuery/phpQuery/phpQuery.php';
//require_once public_path().'/phpQuery.php';
require_once public_path().'/simple_html_dom.php';

class singlephpQueryController extends Controller
{
    public $searchUrl = 'https://www.baidu.com/s?wd=';
    //
    public function singlePqTest(){
//        $html = ' <div><div class="results">   <!-- kmapLeftViewBegin -->  <!-- kmapLeftViewEnd -->     <style>.zhanzhang{overflow:hidden;zoom:1}.zhanzhang .zz_tit{font-size:14px;font-weight:700}.zhanzhang .zz_txt{margin:7px 0 13px 19px}.zhanzhang .zz_ico{margin-right:6px;vertical-align:middle}</style><div class="rb"><div class="zhanzhang"><h3 class="pt zz_tit">';
//        \phpQuery::newDocument($html);
        $html = new \simple_html_dom();

        $f = file_get_contents(public_path().'/queryTest.html');
//        $f = file_get_contents('https://www.baidu.com/s?wd=site%3Amy.4399.com%20%E7%99%BB%E5%9F%BA&rsv_spt=1&rsv_iqid=0xcfa8701100002155&issp=1&f=8&rsv_bp=1&rsv_idx=2&ie=utf-8&rqlang=cn&tn=baiduhome_pg&rsv_enter=1&rsv_dl=tb&oq=site%253Amy.4%2526lt%253B99.com%2520%25E4%25B9%25A0%25E8%25BF%2591%25E5%25B9%25B3&rsv_t=a83fV%2BRujWu4eElHSjZAQkqI700HAG5E5oNMDB5%2FWG6Wg612JdqmuUd0th5M8IDnWRgn&rsv_btype=t&inputT=992&rsv_pq=9e6615be0001341c&rsv_sug3=49&rsv_sug2=0&rsv_sug4=1328');
        $html->load($f);
        $l = $t = [];

        //百度
        $isPage = $html->find('#page a');

        if (strpos($isPage[count($isPage) - 1]->plaintext,'下一页') !== false ){
            dd($isPage[count($isPage) - 1]->href);
        }else{
            dd(1);
        }
        if (count($isPage) > 0){
            $nextPageUrl = $isPage[count($isPage) - 1]->plaintext;
        }
        dd($nextPageUrl);
        $res = $html->find('.result');
        foreach ($res as $re){
            $t[] = $re->find('.t a')[0]->plaintext;
            $d[] = $re->find('.c-abstract')[0]->plaintext;
            $l[] = $re->find('.t a')[0]->href;
        }
        dd($l,$t,$d);

        //360
        $isPage = $html->find('#page a');
        if (count($isPage) > 0){
            $nextPageUrl = $isPage[count($isPage) - 1]->href;
        }
        dd($nextPageUrl);
        $res = $html->find('.res-list');
        foreach ($res as $re){
            $t[] = $re->find('.res-title')[0]->plaintext;
            $l[] = $re->find('.res-title a')[0]->href;
            if (!empty($re->find('.res-rich'))){
                $d[] = $re->find('.res-rich')[0]->plaintext;
            }else{
                $d[] = $re->find('.res-desc')[0]->plaintext;
            }
        }




        //搜狗
        $res = $html->find('.rb');
        $isPage = $html->find('#pagebar_container a');
        if (count($isPage) > 0){
            $nextPageUrl = $isPage[count($isPage) - 1]->href;
        }
        foreach ($res as $re){
            if (count($re->find('.zhanzhang')) > 0){
                continue; //搜狗第一个是xx结果
            }
            $t[] = $re->find('.pt a')[0]->plaintext;
            $d[] = $re->find('.ft')[0]->plaintext;
            $l[] = $re->find('.pt a')[0]->href;
        }
        dd($l,$t,$d);




        \phpQuery::newDocumentFile(public_path().'/queryTest.html');
        dd(pq('#page')->text());



//        dd('pq');
        $page = DB::table('word_pages')->first();
        $url = 'https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=1&rsv_idx=2&tn=baiduhome_pg&wd=phpquery&rsv_spt=1&oq=site%253Amy.4%2526lt%253B99.com%2520%25E4%25B9%25A0%25E8%25BF%2591%25E5%25B9%25B3&rsv_pq=baadafe9000bd25a&rsv_t=d1bahV7oO744ntWhMh%2BVioiXfax9enS63hoDywTyyQ9%2BLgzhv4I9KvG%2Bg81tXphgduIY&rqlang=cn&rsv_enter=1&rsv_dl=tb&rsv_sug3=14&rsv_sug1=5&rsv_sug7=100&rsv_sug2=0&rsv_btype=t&inputT=1607&rsv_sug4=11760';
        $url = $this->searchUrl.'site%3Amy.4399.com%20'.'登基'.'&ie=utf-8&f=8&rsv_bp=1&rsv_idx=1';

        $html = '<ul class="result"><li class="res-list" data-urlfp="CgYIAhAAGAA=" data-lazyload="1"><h3 class="res-title"><a href="https://www.so.com/link?m=aMtP93WxHOItmePKcC77sZstqh1BzGl18HUE6V9veDfK%2BsC2NO8vIunz4IiSuWLN5Dm9emroKw2P9yFD5%2Fq%2FjTclOqERB%2FxR%2BHfni4RPEsr3x4tEgdX%2BsIIs0Rz55%2Bq%2BadCiTv%2FCa5DAJAoP%2FBPyljH4rotguYLK3MF9h04lAL952sqsjEHiaZYFZbn93WY1tnEoA9kpqves%3D" data-mdurl="http://my.4399.com/forums/thread-53003824-pid-586651442" rel="noopener" data-res="{&quot;tp&quot;:2,&quot;fr&quot;:&quot;engine&quot;,&quot;stp&quot;:&quot;bbs&quot;,&quot;st&quot;:0,&quot;e&quot;:2,&quot;pos&quot;:1,&quot;m&quot;:&quot;75da7cbe3f907d1c48479f1d5430ca98&quot;}" target="_blank">【演绎|宫闱】凤凰点翠。aaaaaaaaaaaaaaaaaaaaa</a></h3><div class="res-rich so-rich-bbs clearfix"><p class="info gray" style="display:inline-block">发贴时间：2016年4月10日&nbsp;-&nbsp;</p>〔<em>东明</em>殿〕 [锦瑟阁] [华袖坞] [毓和楼] [念祁轩] [子月轩] [殷和轩] ◎景祺宫 主位 〔遂初殿〕 [云烟阁] [留仙坞] [瑶华楼] [玉漱轩] [陈风...<p class="res-linkinfo"><cite>my.4399.com/forums/thread-5300382...</cite>-<a href="http://c.360webcache.com/c?m=a07710d9b6eca50dac8516e81c5cba4c&amp;q=site%3Amy.4399.com+%E7%8E%8B%E4%B8%9C%E6%98%8E&amp;u=http%3A%2F%2Fmy.4399.com%2Fforums%2Fthread-53003824-pid-586651442" target="_blank" class="m">快照</a>-<a href="http://mingpian.360.cn/qp?query=my.4399.com&amp;key=75f2cd99b96ed49b446d21a01d96c469&amp;src=sodp" class="mingpian" data-h="my.4399.com" data-k="8a919598849bc00d86bd5e03c86ee14c" data-i="1" data-tp="1" target="_blank"><span class="tip-v"></span>4399游戏吧</a></p></div></li></ul>';
//        file_put_contents(public_path().'/queryTest.html',$html);
        \phpQuery::newDocumentFile(public_path().'/query.html');
        $sg = \phpQuery::newDocumentFile($html);
        dd($sg);
        $re = pq('.result-list');
        echo $re;exit();
        $data = [];
//        echo $html;exit();
        foreach ($re as $item){
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
            ];
        }
        dd($data);
    }
}
