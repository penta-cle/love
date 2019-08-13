<?php


namespace app\api\model;

use think\Model;
use traits\model\SoftDelete;

class Like extends Model{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $deleteTime = 'delete_time';
public static function getDianzan(){
    $userid=input("uid");
    $artid=input("aid");
    $arilike = Like::where("aid",$artid)->where("uid",$userid)->find();
    return $arilike;

}
}