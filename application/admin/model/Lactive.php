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
class Lactive extends Model{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $deleteTime = 'delete_time';
    public static function getall(){
        $arr = Lactive::select();
        return $arr;
    }
    public static function getId($id){

        $Lactive = Lactive::find($id);
        if($Lactive == NULL)
            return [];
        return $Lactive;
    }
}