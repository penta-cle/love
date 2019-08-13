<?php


namespace app\api\model;

use think\Model;
use traits\model\SoftDelete;

class Baoming extends Model{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $deleteTime = 'delete_time';

    //添加报名小孩的个人信息
    public static function getChild($data){
            $child = new Baoming($data);
            $child->save();
            return $child;
    }
    //通过报名表aid uid获取报名状态
    public static function getBt($id){
        $arr=Baoming::where("id",$id)->field("id,state")->find();
        return result(0,$arr);
    }
    //获取报名状态
    public static function getBts($id){
        $arr = Baoming::where("id",$id)->field("id,state,reason")->find();
        return $arr;
//        $arr = Baoming::select();
    }

}