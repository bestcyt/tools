<?php

namespace Plugins\sync;

class mdlWordToHtml extends mdlBase
{

    //解析传来的word文档
    public static function getWordHtml($file){
        ini_set('display_errors',1);
        error_reporting(7);
        spl_autoload_register(function ($className) {
            if (strpos($className, 'PhpOffice') === 0) {
                $_path = explode('\\', $className);
                $file = dirname(__FILE__) . '/' . '../../tools/model/' . implode("/", $_path) . '.php';
                if (!file_exists($file)) {
                    var_dump($file);
                    var_dump($className);
                }
                require_once $file;
            }
        });
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($file);
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
                            $isItalic = $style->isItalic();
                            $styleString = ''; //html样式
                            $fontFamily && $styleString .= "font-family:{$fontFamily};";
                            $fontSize && $styleString .= "font-size:{$fontSize}px;";
                            $isBold && $styleString .= "font-weight:bold;";
                            $color && $styleString .= "color:#{$color};";
                            $isItalic && $styleString .= "font-style:italic;";
                            $html .= sprintf('<span style="%s">%s</span>',
                                $styleString,
                                mb_convert_encoding($ele2->getText(), 'GBK', 'UTF-8')
//                                $ele2->getText()
                            );
                        } elseif ($ele2 instanceof \PhpOffice\PhpWord\Element\Image) {
                            $imageData = $ele2->getImageStringData(true);
                            //存进redis
                            $width = $ele2->getStyle()->getWidth();
                            $hight = $ele2->getStyle()->getHeight();
                            $key = 'wordHtml'.md5($ele2->getSource()).'.'.$ele2->getImageExtension();
                            mdlBase::sredis('plugins')->setex($key, 3600, $imageData);//一天过期
                            $imageSrc = 'http://'.$_SERVER['HTTP_HOST'].'/cnbbs/word-getImg?id='.$key;
                            $html .= '<img src="'. $imageSrc .'" style="width:'.$width.'px;height:'.$hight.'px">';
                        }
                    }
                }
                $html .= '</p>';
            }
        }
        return mb_convert_encoding($html, 'UTF-8', 'GBK');
    }
}