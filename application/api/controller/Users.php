<?php

namespace app\api\controller;

use app\api\model\Article;

use app\api\model\Baoming;
use app\api\model\Baomingq;
use app\api\model\User;
use think\Exception;
use think\Controller;
use think\Session;
use think\db;

class Users
{
    //通过前台得到openID 查找操作之后返回数据给前台
    public function getcode1()
    {
        // 清除think作用域
        Session::clear('api');
        $JSCODE = input("code");
        $appid = config('APPID'); //小程序appid
        $appsecret = config('APPSECRET'); //小程序appsecret
        //        $vuid = User::where("code",$uid)->find();
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$appsecret&js_code=$JSCODE&grant_type=authorization_code";
        $res = jsonapi($url);
        if (isset($res['errorcode']) && $res['errorcode'] != 0)
            return result($url);
        //用户的openid
        $openid = $res['openid'];
        //存储该用户 以openid
        Session::set('openid', $openid, 'api');
        $sessionid = session_id();

        $id = User::addNewUser($openid, $sessionid);
        return result(0, $id);
    }

    public function getcode()
    {
        // 清除think作用域
        $code = $_REQUEST['code']; //获取code
        //        $vuid = User::where("code",$uid)->find();
        $JSCODE = input("code");
        $appid = config('APPID'); //小程序appid
        $appsecret = config('APPSECRET'); //小程序appsecret
        //        $vuid = User::where("code",$uid)->find();
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$appsecret&js_code=$JSCODE&grant_type=authorization_code";
        //通过code换取网页授权access_token
        $weixin = file_get_contents($url);
        $jsondecode = json_decode($weixin, true); //对JSON格式的字符串进行编码
        //        $array = get_object_vars($jsondecode);//转换成数组
        //        var_dump($array);
        $openid = $jsondecode['openid']; //输出openid
        //        var_dump($openid);
        $id = User::where("openid", $openid)->field("id")->find();
        if ($id)
            return result(0, $id);
        else
            $User = new User();
        $User->openid = $openid;
        $User->save();

        $id2 = User::where("openid", $openid)->field("id,user")->find();

        return result(0, $id2);
    }
    public function updateuser()
    {
        $data = input();
        $user = User::find($data["uid"]);
        $user->name = $data["nickName"];
        $user->save();
        return result(0);
    }
}
