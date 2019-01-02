<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class PackagesController extends Controller
{
    //pdf 导出
    public function pdf(){
        $snappy = App::make('snappy.pdf');

        $html = response(view('package.pdfView')->with('data','testtesttest'))->getContent();

//        return $html->inline();
        return $snappy->generateFromHtml($html, public_path().'/'.rand(2,20).'.pdf');
//        $snappy->generate('http://www.github.com', public_path().'/'.rand(1,20).'.pdf');
////Or output:
        return new Response(
            $snappy->getOutputFromHtml($html),

            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename='.rand(2,20).'.pdf'
            )
        );
    }
}
