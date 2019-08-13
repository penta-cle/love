<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/12
 * Time: 14:57
 */
namespace app\admin\Controller;
use app\admin\model\Vactive;
use think\Controller;
use think\Session;
class Vactives extends Controller{
    //判断登陆
    protected function _initialize()
    {
        if((Session::has('loged_name','admin'))==NULL)
            return $this->error('请先登录', 'Login/index');
        else
            ;
    }

    //新增活动跳转
    public function add(){
        return $this->fetch("add");
    }
    //编辑活动跳转
    public function edit(){
        if(!input("?id"))
            return $this->error("系统发生错误！");
        $id = input("id");
        if($id == "" || $id == NULL)
            return $this->error("系统发生错误！");
        $res = Vactive::getId($id);
        $vac = $res->getData();
        $this->assign("Vactive",$vac);
        return $this->fetch("edit");
    }
    //detail中转跳转
    public function detail(){
        if(!input("?id"))
            return result(0,"系统发生错误！");
        $id = input("id");
        if($id == "")
            return $this->error("系统发生错误！");
        $res = Vactive::getId($id);
        $this->assign("Vactive",$res);
        return $this->fetch("detail");
    }
    //查询活动信息
    public function select(){
        $list = Vactive::paginate(10);
        self::assign("list", $list);
        // $this->assign("list", $list);
        return  self::fetch("list");
    }
    //新增视频信息
    public function add_vactive()
    {
        if (!input("?vtitle") ||
            !input("?vname") ||
            !input("?vlianjie") ||
            !input("?cnumber")
        )
            return $this->error("系统发生错误！");
        $vtitle = input("vtitle");
        $vname = input("vname");
        $vlianjie = input("vlianjie");
        $cnumber = input("cnumber");
        if ($vtitle == "" || $vname == "" || $vlianjie == "" ||
            $cnumber == "" || $vtitle == NULL || $vname == NULL || $vlianjie == NULL || $cnumber == NULL
        )
            $this->error("请输入完整内容");
        $vactive = new vactive();
        $vactive->vtitle = $vtitle;
        $vactive->vname = $vname;
        $vactive->vlianjie = $vlianjie;
        $vactive->cnumber = $cnumber;
        $vactive->save();
        if ($vactive)
            return $this->success("添加成功","Vactives/detail?id=".$vactive->id);
        else if ($vactive == NUll)
            return $this->error("添加失败");
    }
//更改视频详情
    public function update_vactive(){
        if (!input("?vtitle") ||
            !input("?vname") ||
            !input("?vlianjie") ||
            !input("?cnumber")
        )
            return $this->error("系统发生错误！");
        $id = input("id");
        $vtitle = input("vtitle");
        $vname = input("vname");
        $vlianjie = input("vlianjie");
        $cnumber = input("cnumber");
        if ($vtitle == "" || $vname == "" || $vlianjie == "" ||
            $cnumber == "" || $vtitle == NULL || $vname == NULL || $vlianjie == NULL || $cnumber == NULL
        )
            $this->error("请输入完整内容");

        $vactive = vactive::find($id);
        $vactive->vtitle = $vtitle;
        $vactive->vname = $vname;
        $vactive->vlianjie = $vlianjie;
        $vactive->cnumber = $cnumber;
        $vactive->save();
        if ($vactive)
            return $this->success("修改成功","Vactives/detail?id=".$vactive->id);
        else if ($vactive == NUll)
            return $this->error("修改失败");
    }
    //删除视频
    public function del_vactive(){
        if(!input("?id"))
            return $this->error("系统发生错误！");
        $id = input("id");
        if($id == "")
            return $this->error("系统发生错误！");
        $res = Vactive::destroy($id);
        if($res)
            return $this->success("删除成功");
        else if($res == NULL)
            return $this->error("删除失败！");
    }
}