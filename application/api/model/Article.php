<?php


namespace app\api\model;

use think\Model;
use traits\model\SoftDelete;

class Article extends Model{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $deleteTime = 'delete_time';
    //获取文章详细信息
    public static function getArticle($id){
        $arr = Article::where("id",$id)->field("id,atitle,apic,aname,atext,likes,create_time")->find();
        return $arr;
//        $arr = Article::select();
    }
      public function getDescAttr($value,$data)
    {
        $str = $data["atext"];
        $str = strip_tags($str);
        $str = mb_substr($str,0,30,"utf-8")? mb_substr($str,0,60,"utf-8"):$str ;
        return $str;
    }
}