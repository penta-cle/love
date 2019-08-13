<?php
namespace app\api\controller;

use app\api\model\Article;
use app\api\model\Mingdan;
use think\Exception;
use think\Controller;

class Mingdans{
    public function getMingdan(){
        if(!input("?id"))
            return result(201);
        $id = input("id");

        if($id == "")
            return result(201);
        $arr = Mingdan::getMingdan($id);
        return result(0,$arr);
    }
}