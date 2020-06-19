<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use PhpOffice\PhpWord\IOFactory;
//use PhpOffice\PhpWord\PhpWord;

require_once public_path().'/phpword';

class WordController extends Controller
{
    public function test3(){
        $file = public_path().'/wordTest';
        $filename = public_path().'/wordTest/aaa.docx';

        $zip = new \ZipArchive; // creating object of ZipArchive class.
        $sUploadedFile = 'aaa.docx';
        $zip->open($filename);
        $aFileName = explode('.',$sUploadedFile);
        $sDirectoryName =  current($aFileName).rand(1,100); // aaa
        if (!is_dir("$file/$sDirectoryName")){
            mkdir("$file/$sDirectoryName");
            $zip->extractTo("$file/$sDirectoryName");
            copy("$file/$sDirectoryName/word/document.xml", "$file/$sDirectoryName.xml");
            $xml = simplexml_load_file("$file/$sDirectoryName.xml");
            $xml->registerXPathNamespace('w',"http://schemas.openxmlformats.org/wordprocessingml/2006/main");
            $ps = $xml->xpath('//w:p');
            foreach ($ps as $la){
                dd($la->attributes('//w:rFonts')->getName());
            }
            dd(11);
            $text = $xml->xpath('//w:t');
            dd($text);
            echo '<pre>'; print_r($text); echo '</pre>';
            //rrmdir("word_document/$sDirectoryName");
        }
    }
    //删除解压的文件夹
    public function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir")
                        rrmdir($dir."/".$object);
                    else unlink   ($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }


    //可行，需要依赖phpword
    public function test(){
        $file = public_path().'\aaa.docx';
        $data = [];
        $phpWord =
        $phpWord =
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($file);
        $sections = $phpWord->getSections();
        $html = '';
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $ele1) {
                $paragraphStyle = $ele1->getParagraphStyle();
                if ($paragraphStyle) {
                    $html .= '<p style="text-align:'. $paragraphStyle->getAlignment() .';text-indent:20px;">';
                } else {
                    $html .= '<p>';
                }
                if ($ele1 instanceof \PhpOffice\PhpWord\Element\TextRun) {
                    foreach ($ele1->getElements() as $ele2) {
                        if ($ele2 instanceof \PhpOffice\PhpWord\Element\Text) {
                            $style = $ele2->getFontStyle();
                            $fontFamily = mb_convert_encoding($style->getName(), 'GBK', 'UTF-8');
                            $fontSize = $style->getSize();
                            $isBold = $style->isBold();
                            $color = $style->getColor();
                            $styleString = '';
                            $fontFamily && $styleString .= "font-family:{$fontFamily};";
                            $fontSize && $styleString .= "font-size:{$fontSize}px;";
                            $isBold && $styleString .= "font-weight:bold;";
                            $color && $styleString .= "color:{$color};";
                            $html .= sprintf('<span style="%s">%s</span>',
                                $styleString,
                                $ele2->getText()
                            //mb_convert_encoding($ele2->getText(), 'GBK', 'UTF-8')
                            );
                        } elseif ($ele2 instanceof \PhpOffice\PhpWord\Element\Image) {
                            $imageSrc =  public_path().'/wordImages/'.md5($ele2->getSource()) . '.' . $ele2->getImageExtension();
                            $imageData = $ele2->getImageStringData(true);
                            // $imageData = 'data:' . $ele2->getImageType() . ';base64,' . $imageData;
                            file_put_contents($imageSrc, base64_decode($imageData));
                            $html .= '<img src="'. $imageSrc .'" style="width:100%;height:auto">';
                        }
                    }
                }
                $html .= '</p>';
            }
        }

        echo $html;
    }


    public function test2(){
        $filename = public_path().'\aaa.docx';
        $word = new \COM('word.application')  or die('cant not find word');
        echo "Loading Word, v. {$word->Version}<br>";
        $word->Visible = 0;
        $word->Documents->OPen($filename);
        $test= $word->ActiveDocument->content->Text;
        echo $test;
    }

    //从文档读出字符串
    public function test1(){
        $filename = public_path().'\aaa.docx';
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
        echo $content;exit();
        $striped_content = strip_tags($content);
        $ar = explode('，',$striped_content);
        echo $ar;exit();
        return $ar;
    }


}
