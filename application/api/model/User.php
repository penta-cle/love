<?php


namespace app\api\model;

use think\Model;
use traits\model\SoftDelete;

class User extends Model{

        public function getuid($openid){
            if (!input("?openid"))
                return result(401);
            $openid = input("openid");
            if ($openid == "" || $openid ==  NULL)
            $openid = User::where("openid",$openid)->field("id")->find();
            return $openid;
        }

        public function addNewUser($openid,$session){
            if($openid == NULL)
                return false;
            $attendee = User::where("openid", $openid)->find();
            if($attendee){
                $attendee->session = $session;
                return $attendee->id;
            }else {
                $user = new User();
                $user->openid = $openid;
                $user->session = $session;
                $user->save();
                return $user->id;
            }
        }

}