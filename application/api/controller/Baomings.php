<?php

namespace app\api\controller;

use app\api\model\Article;

use app\api\model\Baoming;
use app\api\model\Baomingq;
use app\api\model\User;
use think\Exception;
use think\Controller;

class Baomings
{

    //获取报名DB中的报名渠道表
    public function getQudaos()
    {
        $arr = Baomingq::getBaoming();
        return result(0, $arr);
    }

    //添加报名流程信息
    public function add_child()
    {
        $uname = input("uname");
        $usex = input("usex");
        $address = input("address");
        $birth = input("birth");
        $ktel = input("ktel");
        $word = input("word");
        $qudao = input("qudao");

        $kname = input("kname");
        $kage = input("kage");
        $kwork = input("kwork");
        $guanxi = input("guanxi");
        $tel = input("tel");

        $alone = input("alone");
        $uid = input("uid");
        $aid = input("aid");
        if (
            $uname == "" || $usex == "" || $address == "" || $birth == "" ||
            $ktel == "" || $word == "" || $qudao == "" || $kname == "" || $kage == "" || $uid == "" || $aid == "" ||
            $kwork == "" || $alone == "" || $alone == NULL || $tel == "" || $tel == NULL || $guanxi == "" || $guanxi == NULL ||
            $kage == NULL || $kwork == NULL || $ktel == NULL || $word == NULL || $qudao == NULL || $kname == NULL || $uname == NULL || $usex == NULL || $address == NULL || $birth == NULL || $uid == NULL || $aid == NULL
        )
            return result(201);
        //        $arr = ['0','1','2'];
        $user = Baoming::where("aid", $aid)->where("uid", $uid)->where("state", '<', 3)->find(); //查询输入信息是否重复

        if ($user)
            return result(401);

        else
            $arr = Baoming::getChild([
                "uname" => $uname,
                "usex" => $usex ? "男" : "女",
                "address" => $address,
                "birth" => $birth,
                "ktel" => $ktel,
                "word" => $word,
                "qudao" => $qudao,
                "kname" => $kname,
                "kage" => $kage,
                "kwork" => $kwork,
                "guanxi" => $guanxi,
                "tel" => $tel,
                "alone" => $alone,
                "aid" => $aid,
                "uid" => $uid,
            ]);
        $arr->save();
        if ($arr) {
            $res = Baoming::find($arr->id);
            return result(0, $res);
        } else
            return result(202);
    }

    //获取报名情况
    public function get_zhuangtai()
    {
        $aid = input("aid");
        $uid = input("uid");
        if ($aid == "" || $aid == NULL || $uid == "" || $uid == NULL)
            return result(201);
        $state = Baoming::where("aid", $aid)
            ->where("uid", $uid)
            ->where("state", '<', 3)
            ->find();
        if (!$state || $state->state == 3)
            return result(0, ["state" => false]);
        else
            return result(0, [
                "state" => true,
                "info" => $state
            ]);
    }

    //取消报名
    public function del_baoming()
    {
        $id = input("id");
        $res = Baoming::where("id", $id)->field("state")->find();
        if ($res) {

            $res['state'] = '3';
            $res->save();
            return result(0, $res);
        } else {
            return result(201);
        }
    }

    //取消报名
    public function quxiao_baoming()
    {
        $id = input("id");
        $res = Baoming::where("id", $id)->field("state")->find();
        if ($res) {
            $res['state'] = '3';
            $res->save();
            return result(0, $res);
        } else
            return result(201);
    }
}
