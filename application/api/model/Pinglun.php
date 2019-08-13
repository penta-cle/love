<?php

namespace app\api\model;
use think\Model;
use traits\model\SoftDelete;

class Pinglun extends Model{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $deleteTime = 'delete_time';
    //根据aid获取评论详情
    public static function getPinglun($id){

        $arr = Pinglun::where("id",$id)->field("ctext,cname,cnumber,create_time")->find();
        return $arr;
//        $arr = Article::select();
//        return $arr;
    }

}