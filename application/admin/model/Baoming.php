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
class Baoming extends Model{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $deleteTime = 'delete_time';
    protected $types=[];
    public static function getall(){
        $arr = Baoming::select();
        return $arr;
    }

    //搜索功能
    public static function searchArticle($key){
        $key = "%".$key."%";
        $articles = Baoming::where("uname",'like',$key)
            ->whereOr("id",'like',$key)
            ->paginate(10);
        return $articles;
    }

//    public static function searchArticle2($key){
//        $key = "%".$key."%";
//        $articles = Baoming::where("qudao",'like',$key)->paginate(10);
//        return $articles;
//    }

    public static function getId($id){

        $Baoming = Baoming::find($id);
        if($Baoming == NULL)
            return [];
        return $Baoming;
    }
    //判断是否独生子女
    public function getAloneAttr($value)
    {
        $status = ["false" => "否", "true" => "是",];
        return $status[$value];
    }
    //判断报名状态
    public function getStateAttr($value)
    {
        $status = [0 => "审核失败", 1 => "等待审核",2=>"审核成功",3=>"取消报名"];
        return $status[$value];
    }
}