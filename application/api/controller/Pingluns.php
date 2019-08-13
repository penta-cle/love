<?php

namespace app\api\controller;

use app\api\model\Lactive;
use app\api\model\Pinglun;
use app\api\model\User;
use think\Exception;
use think\Controller;

class Pingluns
{

    //根据aid uid查询评论详情
    public function getPinglun()
    {

        $aid = input("aid"); //文章id
        if ($aid == "" || $aid == "")
            return result(201);
        $pinglun = Pinglun::where("aid", $aid)->order("create_time", "desc")->field("id,uid,ctext,cname,create_time")->paginate(10);
        return result(0, $pinglun);
    }

    //添加评论接口
    public function add_pinglun()
    {

        $aid = input("aid");     //文章id
        $keywords = input("keywords");
        $uid = input("uid");    //用户id
        $uname = User::where("id", $uid)->field("name")->find();
        if ($aid == "" || $uid == "" || $keywords == "" || $aid == NULL || $uid == NULL || $keywords == NULL)
            return result(201);
        $Pinglun = new Pinglun();
        $Lactive = Lactive::where("id", $aid)->field("allpinglun")->find();
        $Pinglun->aid = $aid;
        $Pinglun->uid = $uid;
        $Pinglun->cname = $uname['name'];
        $Pinglun->ctext = $keywords;
        $Pinglun->save();
        $arr = $Lactive->allpinglun;
        $Lactive->allpinglun = $arr + 1;
        $Lactive->save();
        return result(0, $Pinglun);
    }

    //删除评论
    public function del_pinglun()
    {
        if (!input("?id"))
            return result(301);
        $id = input("id");
        if ($id == "")
            return result(301);

        $res = Pinglun::where("id", $id)->field("aid")->find();
        $aid = $res->aid;

        $Lactive = Lactive::where("id", $aid)->field("allpinglun")->find();
        $Lactive->allpinglun -= 1;

        $Lactive->save();
        if ($Lactive) {
            $res = Pinglun::destroy($id);
            return result(0, $res);
        } else
            return result(301);
    }


}