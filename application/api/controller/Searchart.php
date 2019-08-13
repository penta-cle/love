<?php
namespace app\api\controller;

use app\api\model\Article;

use app\api\model\Baoming;
use app\api\model\Mingdan;
use think\Exception;
use think\Controller;
use think\Request;

class Searchart{
   public function Search(Request $request)
   {
       $keywords = input('keywords');
       $articles = Article::where('atitle', 'like', '%' . $request->param('keywords') . '%')->paginate(10);
       return result(0, $articles);

   }
}