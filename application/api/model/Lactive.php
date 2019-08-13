<?php


namespace app\api\model;

use think\Model;
use traits\model\SoftDelete;

class Lactive extends Model{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $deleteTime = 'delete_time';
    //获取活动全部信息
    public static function getLactive(){
        $arr = Lactive::select();
        return $arr;
    }
    //获取单个id信息
    public static function getActive($id){

        $arr = Lactive::where("id",$id)->find();
        return $arr;
    }
      public function getDescAttr($value,$data)
    {
        $str = $data["atext"];
        $str = strip_tags($str);
        $str = mb_substr($str,0,30,"utf-8")? mb_substr($str,0,50,"utf-8"):$str ;
        return $str;
    }
    
}