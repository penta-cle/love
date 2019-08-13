<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/12
 * Time: 14:57
 */

namespace app\admin\Controller;

use app\admin\model\Lactive;
use app\admin\model\Vactive;
use app\api\model\Pinglun;
use think\Controller;
use think\Session;

class Lactives extends Controller
{

    //判断登陆
    protected function _initialize()
    {
        if((Session::has('loged_name','admin'))==NULL)
            return $this->error('请先登录', 'Login/index');
        else
            ;
    }
    //新增活动跳转
    public function add()
    {
        return $this->fetch("add");
    }

    //编辑活动跳转
    public function edit()
    {
        if (!input("?id"))
            return $this->error("系统发生错误！");
        $id = input("id");
        if ($id == "" || $id == NULL)
            return $this->error("系统发生错误！");
        $res = Lactive::getId($id);
        $lac = $res->getData();
        $this->assign("Lactive", $lac);
        return $this->fetch("edit");
    }

    //detail中转跳转
    public function detail()
    {
        if (!input("?id"))
            return result(0, "系统发生错误！");
        $id = input("id");
        if ($id == "")
            return $this->error("系统发生错误！");
        $res = Lactive::getId($id);
//            $pinglun = Pinglun::getId($id);
//            $this->assign("Pinglun",$pinglun);
        $this->assign("Lactive", $res);
        return $this->fetch("detail");
    }

    //查询活动信息
    public function select()
    {
        $list = Lactive::order('id desc')->paginate(10);
        $arr = Pinglun::order('id desc')->paginate(10);
        self::assign("list", $list);
        self::assign("arr", $arr);
        // $this->assign("list", $list);
        return self::fetch("list");
    }

    //查看活动详情
    public function view()
    {
        $list = Lactive::order('id desc')->paginate(10);
        self::assign("list", $list);
//        $this->assign("list",$list);
        return self::fetch("view");
    }

    //查看评论详情
    public function pinglun()
    {
        $arr = Pinglun::order('id desc')->paginate(10);
        self::assign("arr", $arr);
        return self::fetch("pinglun");
    }

    //添加活动详情
    public function add_lactive()
    {
        if (!input("?ltitle") ||
            !input("?atext") ||
            !input("?vname") ||
            !input("?vlianjie")
        )
            return $this->error("系统发生错误！");
        $ltitle = input("ltitle");
        $atext = input("atext");
        $vname = input("vname");
        $vlianjie = input("vlianjie");
        if ($ltitle == "" || $atext == "" || $vname == "" || $vlianjie == "" || $ltitle == NULL || $atext == NULL || $vname == NULL || $vlianjie == NULL
        )
            $this->error("请输入完整内容");

        $arr1 = substr($vlianjie, 73);  //截取视频链接vid
        $arr2 = substr($arr1, 0, 11);
        $Lactive = new Lactive();
        $Lactive->ltitle = $ltitle;
        $Lactive->vid = $arr2;
        $Lactive->atext = $atext;
        $Lactive->vname = $vname;
        $Lactive->vlianjie = $vlianjie;
        $Lactive->save();

        if ($Lactive)
            return $this->success("添加成功", "Lactives/detail?id=" . $Lactive->id);
        else if ($Lactive == NUll)
            return $this->error("添加失败");
    }


    //更改活动详情
    public function update_lactive()
    {
        if (!input("?ltitle") ||
            !input("?atext") ||
            !input("?vname") ||
            !input("?vlianjie")
        )
            return $this->error("系统发生错误！");
        $id = input("id");
        $ltitle = input("ltitle");
        $cname = input("cname");
        $atext = input("atext");
        $ctext = input("ctext");
        $vname = input("vname");
        $vlianjie = input("vlianjie");
        $cnumber = input("cnumber");
        if ($ltitle == "" || $atext == ""
            || $vname == "" || $vlianjie == "" || $ltitle == NULL || $atext == NULL || $vname == NULL || $vlianjie == NULL
        )
            $this->error("请输入完整内容");
        $arr1 = substr($vlianjie, 73);
        $arr2 = substr($arr1, 0, 11);

        $Lactive = Lactive::find($id);
        $Lactive->vid = $arr2;
        $Lactive->ltitle = $ltitle;
        $Lactive->atext = $atext;
        $Lactive->vname = $vname;
        $Lactive->vlianjie = $vlianjie;
        $Lactive->save();

        if ($Lactive)
            return $this->success("修改成功", "Lactives/detail?id=" . $Lactive->id);
        else if ($Lactive == NUll)
            return $this->error("修改失败");
    }

    //删除活动详情
    public function del_lactive()
    {
        if (!input("?id"))
            return $this->error("参数错误！");
        $id = input("id");
        if ($id == "") {
            return $this->error("参数不足！");
        }
        $pingluns = Pinglun::where("aid", $id)->field("id")->select();

        foreach ($pingluns as $pinglun) {  //遍历删除所有相关评论
            $pinglun->delete();
        }
        $res = Lactive::destroy($id);
        if ($res)
            return $this->success("删除成功");
        else
            return $this->error("删除失败！");

    }

    //删除评论
    public function del_pinglun()
    {
        if (!input("?id"))
            return $this->error("系统发生错误！");
        $id = input("id");
        if ($id == "")
            return $this->error("系统发生错误！");

        $res = Pinglun::where("id", $id)->field("aid")->find();
        $aid = $res->aid;
        $Lactive = Lactive::where("id", $aid)->field("allpinglun")->find();
        $Lactive->allpinglun -= 1;
        $Lactive->save();

        if ($res) {
            $res = Pinglun::destroy($id);
            return $this->success("删除成功");
        } else if ($res == NULL)
            return $this->error("删除失败！");
    }

    //截取获取腾讯视频真实连接vid
    public function getvid()
    {

        $id = input("id");
        $lianjie1 = input("vlianjie");
        $arr1 = substr($lianjie1, 73);
        $arr2 = substr($arr1, 0, 11);
        $Lactive = Lactive::find($id);
        $Lactive->vid = $arr2;
        $Lactive->save();
        return result(0, $Lactive);

    }
}