<?php
namespace app\api\controller;

use app\api\model\Article;
use app\api\model\Mingdan;
use think\Exception;
use think\Controller;

class All{
    public function getArticle(){

        $arr = Article::select();
//        var_dump($arr);
        return result(0,$arr);
    }

    public function getMingdan(){
        $arr = Mingdan::select();
        return result(0,$arr);
    }


}