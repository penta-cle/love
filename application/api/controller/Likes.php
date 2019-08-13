<?php

namespace app\api\controller;

use app\api\model\Article;
use app\api\model\Mingdan;
use app\api\model\User;
use app\api\model\Like;
use app\api\model\Likem;
use think\Exception;
use think\Controller;

class Likes
{

    //查询点赞信息
    public function getLike()
    {
        //        $userid=input("uid"); //用户id
        $artid = input("aid"); //文章id
        $number = Article::where("id", $artid)->field("likes")->find();
        return result(0, $number);

    }

    //文章点赞状态
    public function getarticledianzan()
    {
        $aid = input("aid");
        $uid = input("uid");
        $dian = Like::where("aid", $aid)->where("uid", $uid)->find();
        if(!$dian)
            return result(0, ["state"=>false]); else
            return result(0, $dian);
    }

    //名单点赞状态
    public function getmingdanstate()
    {
        $aid = input("aid");
        $uid = input("uid");
        $dian = Likem::where("mdid", $aid)->where("uid", $uid)->field("state")->find();
        if(!$dian)
            return result(0, ["state"=>false]); else
            return result(0, $dian);
    }

    //查询名单点赞信息
    public function getmingdanlike()
    {
        //        $userid=input("uid"); //用户id
        $artid = input("mdid"); //名单id
        $mingdan = Mingdan::find($artid);
        if(!$mingdan)
            return result(500);
        else
            return result(0, $mingdan);

    }

    //文章端点赞动作
    public function huodongdianzan()
    {
        //        $lid = input("id");
        $userid = input("uid"); //用户id
        $artid = input("aid"); //文章id
        $arilike = Like::where("uid", $userid)->where("aid", $artid)->find();
        $all_like = Article::where("id", $artid)->field("likes")->find();
        if($arilike) {
            $state = $arilike->state;
            $arilike->state = $state == 1 ? 0 : 1;
            $arilike->save();

            if($arilike->state == 0) {
                $all_like = Article::where("id", $artid)->field("likes")->find();
                $arr = $all_like->likes;
                $all_like->likes = $arr - 1;
                $all_like->save();
            } else {
                $all_like = Article::where("id", $artid)->field("likes")->find();
                $arr = $all_like->likes;
                $all_like->likes = $arr + 1;
                $all_like->save();
            }

        } else {
            $arilike = new Like();
            $arilike->uid = $userid;
            $arilike->aid = $artid;
            $arilike->state = 1;
            $arilike->save();

            $all_like = Article::where("id", $artid)->field("likes")->find();
            $arr = $all_like->likes;
            $all_like->likes = $arr - 1;
            $all_like->save();
        }
        return result(0, $arilike);
    }

    //名单端点赞动作
    public function mingdandianzan()
    {
        //        $lid = input("id");
        $userid = input("uid"); //用户id
        $mingdanid = input("mdid"); //名单id

        //查是否已经点赞
        $liked = Likem::where("uid", $userid)->where("mdid", $mingdanid)->find();

        if($liked) {
            $state = $liked->state;
            $liked->state = $state == 1 ? 0 : 1;
            $liked->save();

            $mingdan = Mingdan::where("id", $mingdanid)->field("likes")->find();
            if($liked->state == 0) {
                $mingdan->likes -= 1;
            } else {
                $mingdan->likes += 1;
            }
            $mingdan->save();

        } else {
            $liked = new Likem();
            $liked->uid = $userid;
            $liked->mdid = $mingdanid;
            $liked->state = 1;
            $liked->save();

            $mingdan = Mingdan::find($mingdanid);
            $mingdan->likes += 1;
            $mingdan->save();
        }
        return result(0, $liked);
    }


}