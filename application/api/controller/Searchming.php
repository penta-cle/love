<?php
namespace app\api\controller;

use app\api\model\Article;

use app\api\model\Baoming;
use app\api\model\Mingdan;
use think\Exception;
use think\Controller;
use think\Request;

class Searchming{
    public function Search(Request $request){
        $keywords = input('keywords');
        $mingdans= Mingdan::where('ltitle','like','%'.$request->param('keywords').'%')->paginate(10);
        return result(0,$mingdans);

    }
}