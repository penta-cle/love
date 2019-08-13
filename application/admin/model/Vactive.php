<?php
/**
 * Created by PhpStorm.
 * User: Pentacle
 * Date: 2019/7/12
 * Time: 14:48
 */
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class Vactive extends Model{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $deleteTime = 'delete_time';
    public static function getall(){
        $arr = Vactive::select();
        return $arr;
    }
    public static function getId($id){

        $vactive = Vactive::find($id);
        if($vactive == NULL)
            return [];
        return $vactive;
    }
}