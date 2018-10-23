<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class AirPortController extends Controller
{
    //获取提交的excl
    public function index(){

        return view('airport.index');
    }

    // 2018/10/19 cyt 对一万多个机场的数据处理，由Excel里的数据转为指定格式的json数据
    public function post(Request $request){

        $file = $request->file('air')->path();
        $arrays =  Excel::load($file, function($reader) {
            $reader->noHeading(); //这一句
        })->get();
        $re = [];
        foreach ($arrays as $array){

            if (!$array[3] || !$array[5]){
                continue;
            }
            //取机场名字首字母，用来分组
            $letter = substr($array[2],0,1);
            $l1 = $letter;
            preg_match("/[A-Z]/",$array[2],$match,PREG_OFFSET_CAPTURE);
            if ($match[0][1]){ //大于0说明首字母不是A-Z，将该机场划分到other
                $l1 = 'other';
            }
            $re[$l1]['groupId'] = $l1;
            $add['en_name'] = $array[2];
            $add['three_letter'] =$array[0];
            $add['city'] =$array[5];
            $add['airport'] =$array[3];
            if (empty($re[$l1]['cityArr'])){
                $re[$l1]['cityArr'] = [];
            }
            array_push($re[$l1]['cityArr'],$add);
        }

        //根据groupid 进行A-Z的排序
        foreach ($re as $k => $v) {
            $edition[] = $v['groupId'];
        }
        array_multisort($edition, SORT_ASC, $re);
        //dd(cache('air'),array_values($re),json_encode(array_values($re)));

        //以数组形式输出文件


        //转为json字符串，参数不让中文转义
        $json_strings = json_encode(array_values($re),JSON_UNESCAPED_UNICODE);

        //写入一个文件，然后下载
        file_put_contents(public_path()."air.json",$json_strings);
        return response()->download(public_path()."air.json", 'air.json',['Content-Type' => 'text/json',]);

    }

    /*
     * 以三字码数组文件输出
     */
    public function postArray(Request $request){
        $file = $request->file('air')->path();
        $arrays =  Excel::load($file, function($reader) {
            $reader->noHeading(); //这一句
        })->get();
        $re = [];

        foreach ($arrays as $array){

            if (!$array[3] || !$array[5]){
                continue;
            }

            $re[$array[0]]['three_letter'] = $array[0];
            $re[$array[0]]['city'] = $array[5];
            $re[$array[0]]['airport'] = $array[3];
            $re[$array[0]]['en_name'] = $array[2];

        }
        ksort($re);

        $file= public_path().'\air.php';
        $text='<?php $rows='.var_export($re,true).';';

        file_put_contents($file,$text);
        return response()->download($file, 'air.php',['Content-Type' => 'text/html',]);

    }

    public function test(){
        $arrays = cache('air');
        $re = [];
        foreach ($arrays as $array){

            //取机场名字首字母，用来分组
            $letter = substr($array[2],0,1);
            $l1 = $letter;
            preg_match("/[A-Z]/",$array[2],$match,PREG_OFFSET_CAPTURE);
            if ($match[0][1]){ //大于0说明首字母不是A_Z
                $l1 = '其他';
            }
            $re[$l1]['groupId'] = $l1;
            $add['en_name'] = $array[2];
            $add['three_letter'] =$array[0];
            $add['city'] =$array[5];
            $add['airport'] =$array[3];
            if (empty($re[$l1]['cityArr'])){
                $re[$l1]['cityArr'] = [];
            }
            array_push($re[$l1]['cityArr'],$add);
        }
        foreach ($re as $k => $v) {
            $edition[] = $v['groupId'];
        }
        array_multisort($edition, SORT_ASC, $re);
//        dd(cache('air'),array_values($re));
        $json_strings = json_encode(array_values($re),JSON_UNESCAPED_UNICODE);
        file_put_contents(public_path()."text.json",$json_strings);
        return response()->download(public_path()."text.json", 'text.json',['Content-Type' => 'text/json',]);

    }



}

