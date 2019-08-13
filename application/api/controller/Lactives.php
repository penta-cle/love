<?php

namespace app\api\controller;

use app\api\model\Lactive;
use think\Db;
use think\Exception;
use think\Controller;

class Lactives
{

    //查询活动相关全部信息
    public function getLactive()
    {
        $arr = Lactive::getLactive();
        return result(0, $arr);
    }

    //统计评论总数
    public function tongji()
    {
//        $arr = Lactive::getLactive();
        $aid = input("aid");
//        $Pinglun = Pinglun::where("aid", $aid)->count("aid");

//        $all = Lactive::field("allpinglun",$Pinglun)->find();

        $arr = Db::table('lactive')
            ->alias('a')
            ->join('pinglun w','a.id = w.aid')
//            ->count("aid")
                ->field("a.allpinglun")
            ->select();

        dump( $arr);
    }

    //查询活动相关信息id,aid,ltitle,atext,vname,vlianjie,create_time
    public function getActive()
    {
        if (!input("?id"))
            return result(201);
        $id = input("id");
        if ($id == "")
            return result(201);
        $arr = Lactive::getActive($id);
        return result(0, $arr);

    }
}