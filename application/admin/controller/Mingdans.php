<?php
/**
 * Created by PhpStorm.
 * User: Pentacle
 * Date: 2019/7/12
 * Time: 14:57
 */

namespace app\admin\Controller;

use app\admin\model\Mingdan;
use think\Controller;
use think\Session;

class Mingdans extends Controller
{
    //判断登陆
    protected function _initialize()
    {
        if((Session::has('loged_name','admin'))==NULL)
            return $this->error('请先登录', 'Login/index');
        else
            ;
    }
    //添加按钮跳转
    public function add()
    {
        return $this->fetch("add");
    }

    //编辑跳转
    public function edit()
    {
        if (!input("?id"))
            return $this->error("系统发生错误！");
        $id = input("id");
        if ($id == "" || $id == NULL)
            return $this->error("系统发生错误！");
        $res = Mingdan::getId($id);
        $art = $res->getData();
        $this->assign("Mingdan", $art);
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
        $res = Mingdan::getId($id);
        $this->assign("Mingdan", $res);
        return $this->fetch("detail");
    }

    //名单详情跳转
    public function view_xiangqing()
    {
        $list = Mingdan::order('id desc')->paginate(10);
        self::assign("list", $list);
        //        $this->assign("list",$list);
        return self::fetch("view");
    }

    //查询名单介绍信息
    public function select()
    {
        $list = Mingdan::order('id desc')->paginate(10);
        self::assign("list", $list);
        // $this->assign("list", $list);
        return self::fetch("list");
    }

    //查看名单详情
    public function view()
    {
        $list = Mingdan::order('id desc')->paginate(10);
        self::assign("list", $list);
        return self::fetch("view");
    }

    //添加名单
    public function add_Mingdan()
    {
        if (!input("?ltitle") ||
            !input("?lpic") ||
            !input("?lname") ||
            !input("?ltext")
        )
            return $this->error("系统发生错误");
        $ltitle = input("ltitle");
        $lpic = input("lpic");
        $lname = input("lname");
        $ltext = input("ltext");
        if ($ltitle == "" || $lpic == "" || $lname == "" || $ltext == "" ||
            $ltitle == NULL || $lpic == NULL || $lname == NULL || $ltext == NULL
        )
            return $this->error("请输入完整内容");
        $Mingdan = new Mingdan();
        $Mingdan->ltitle = $ltitle;
        $Mingdan->lpic = $lpic;
        $Mingdan->lname = $lname;
        $Mingdan->ltext = $ltext;
        $Mingdan->save();
        if ($Mingdan)
            return $this->success("添加成功", "Mingdans/detail?id=" . $Mingdan->id);
        else if ($Mingdan == NULL)
            return $this->error("添加失败");
    }

    //编辑名单
    public function update_Mingdan()
    {
        if (!input("?ltitle") ||
            !input("?lpic") ||
            !input("?lname") ||
            !input("?ltext")
        )
            return $this->error("系统发生错误");
        $id = input("id");
        $ltitle = input("ltitle");
        $lpic = input("lpic");
        $lname = input("lname");
        $ltext = input("ltext");
        if ($id == "" || $ltitle == "" || $lpic == "" || $lname == "" || $ltext == "" ||
            $id == NULL || $ltitle == NULL || $lpic == NULL || $lname == NULL || $ltext == NULL
        )
            return $this->error("请输入完整内容");
        $Mingdan = Mingdan::find($id);
        $Mingdan->ltitle = $ltitle;
        $Mingdan->lpic = $lpic;
        $Mingdan->lname = $lname;
        $Mingdan->ltext = $ltext;
        $Mingdan->save();

        if ($Mingdan)
            return $this->success("修改成功", "Mingdans/detail?id=" . $Mingdan->id);
        else if ($Mingdan == NULL)
            return $this->error("修改失败");
    }

    //删除名单
    public function del_Mingdan()
    {
        if (!input("?id"))
            return $this->error("系统发生错误！");
        $id = input("id");
        if ($id == "")
            return $this->error("系统发生错误！");
        $res = Mingdan::destroy($id);
        if ($res)
            return $this->success("删除成功");
        else if ($res == NULL)
            return $this->error("删除失败！");
    }
}