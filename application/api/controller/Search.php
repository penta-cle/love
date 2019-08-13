<?php
namespace app\api\controller;

use app\api\model\Article;

use app\api\model\Baoming;
use think\Exception;
use think\Controller;
use think\Request;

class Search{
   public function Search(Request $request){
       $keywords = input('keywords');
       $map = [
           ['atitle','like','%'.$request->param('keywords').'%'],
           ];
    $articles= Article::where($map)->paginate(10);
//    $categorys=$this->navShow();
    return result(0,$articles);
   }
}