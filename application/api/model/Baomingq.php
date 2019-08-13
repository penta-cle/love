<?php


namespace app\api\model;

use think\Model;
use traits\model\SoftDelete;

class Baomingq extends Model{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $deleteTime = 'delete_time';
//获取报名渠道
    public static function getBaoming(){
        $arr = Baomingq::select();
        return $arr;
    }


}