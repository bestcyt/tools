<?php

namespace App\Http\Controllers;

use App\Traits\TranslateTrait;
use Illuminate\Http\Request;

class TranslateController extends Controller
{
    use TranslateTrait;
    //

    public function index(Request $request){
        $requestData = $request->all();
        if (empty($requestData['q'])){
            return 'no q plz';
        }
        if (empty($requestData['lanType'])){
            return 'no lanType plz';
        }
        if ($requestData['lanType'] != 'en' && $requestData['lanType'] != 'cn'){
            return '暂时只支持中英文';
        }
        return $this->translate($requestData['q'],$requestData['lanType']);
    }
}
