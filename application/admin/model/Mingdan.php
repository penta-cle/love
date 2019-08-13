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
class Mingdan extends Model{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $deleteTime = 'delete_time';
    public static function getall(){
        $arr = Mingdan::select();
        return $arr;
    }
    public static function getId($id){

        $Mingdan = Mingdan::find($id);
        if($Mingdan == NULL)
            return [];
        return $Mingdan;
    }
}