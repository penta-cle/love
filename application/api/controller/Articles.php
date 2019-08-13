<?php
namespace app\api\controller;

use app\api\model\Article;

use app\api\model\Baoming;
use app\api\model\Baomingq;
use think\Exception;
use think\Controller;

class Articles{
    //获取DB中所有文章详情
    public function getArticles(){
        if(!input("?id"))
            return result(201);
        $id = input("id");
        if($id == "")
            return result(201);
        $arr = Article::getArticle($id);
        return result(0,$arr);
    }
    //获取报名DB中的报名表里的报名状态，状态原因
    public function getBts(){
        if(!input("?id"))
            return result(201);
        $id = input("id");
        if($id == "")
            return result(201);
        $arr = Baoming::getBt($id);
        return result(0,$arr);
    }
    //获取报名DB中的报名渠道表
    public function getQudaos(){
        $arr = Baomingq::getBaoming();
        return result(0,$arr);
    }
}