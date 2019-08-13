<?php


namespace app\api\model;

use think\Model;
use traits\model\SoftDelete;

class Likem extends Model{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $deleteTime = 'delete_time';
    public static function getDianzan(){
        $userid=input("uid");
        $mingdanid=input("mdid");
        $arilike = Likem::where("mdid",$mingdanid)->where("uid",$userid)->find();
        return $arilike;

    }
}