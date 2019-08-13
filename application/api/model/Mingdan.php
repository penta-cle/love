<?php


namespace app\api\model;

use think\Model;
use traits\model\SoftDelete;

class Mingdan extends Model{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $deleteTime = 'delete_time';
    public static function getMingdan($id){
        $arr = Mingdan::where("id",$id)->field("id,ltitle,lpic,lname,ltext,create_time")->find();
        return $arr;
//        $arr = Article::select();
    }

}