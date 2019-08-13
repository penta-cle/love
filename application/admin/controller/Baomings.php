<?php
/**
 * Created by PhpStorm.
 * User: Pentacle
 * Date: 2019/7/12
 * Time: 14:57
 */

namespace app\admin\Controller;

use app\admin\model\Article;
use app\admin\model\Baoming;
use app\admin\model\Zhuangtai;
use app\admin\model\Baomingq;
use think\Controller;
use think\Session;
use think\Request;

class Baomings extends Controller
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
        $types = Baomingq::getall();
        $this->assign("types", $types);
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
        $res = Baoming::getId($id);
        $bao = $res->getData();
        $types = Baomingq::getall();
        $this->assign("Baoming", $bao);
        $this->assign("types", $types);

//        var_dump($bao);
        return $this->fetch("edit");
    }

    //detail跳转
    public function detail()
    {
        if (!input("?id"))
            return result(0, "系统发生错误！");
        $id = input("id");
        if ($id == "")
            return $this->error("系统发生错误！");
        $res = Baoming::getId($id);
        $this->assign("Baoming", $res);
        return $this->fetch("detail");
    }

    //查询报名信息
    public function select()
    {
        $list = Baoming::order('id desc')->paginate(10);
        $this->assign([
            "list" => $list,
            "qudao" => Baomingq::all(),
            "id" => Article::all(),
            "state" => Zhuangtai::all(),
        ]);
        return $this->fetch("list");
    }

    //报名渠道分类搜索
    public function getByType()
    {
        $qudao = input("qudao");
//        $res = input("qudao");
        if ($qudao == "all") {
            $all = Baoming::paginate(10,false,['query' => request()->param()]);
            $this->assign([
                "qudao" => Baomingq::all(),
                "id" => Article::all(),
                "state" => Zhuangtai::all(),
                "list" => $all,
            ]);

        } else {
            $lists = Baoming::where('qudao', $qudao)->paginate(10,false,['query' => request()->param()]);
            $this->assign([
                "qudao" => Baomingq::all(),
                "id" => Article::all(),
                "state" => Zhuangtai::all(),
                "list" => $lists,
            ]);
        }
        return $this->fetch("list");
    }

//报名状态
    public function getByState()
    {
        $state = input("state");
        if ($state == "all") {
            $all = Baoming::order('id desc')->paginate(10,false,['query' => request()->param()]);
            $this->assign([
                "qudao" => Baomingq::all(),
                "state" => Zhuangtai::all(),
                "id" => Article::all(),
                "list" => $all,
            ]);

        } else {
            $lists = Baoming::where('state', $state)->paginate(10,false,['query' => request()->param()]);
            $this->assign([
                "state" => Zhuangtai::all(),
                "qudao" => Baomingq::all(),
                "id" => Article::all(),
                "list" => $lists
            ]);
        }
        return $this->fetch("list");
    }

//文章分类查询
    public function getByArticle()
    {
        $article = input("article");
        if ($article == "all") {
            $all = Baoming::paginate(10,false,['query' => request()->param()]);
            $this->assign([
                "qudao" => Baomingq::all(),
                "id" => Article::all(),
                "state" => Zhuangtai::all(),
                "list" => $all,
            ]);

        } else {
            $lists = Baoming::where('aid', $article)->paginate(10,false,['query' => request()->param()]);
            $this->assign([
                "state" => Zhuangtai::all(),
                "id" => Article::all(),
                "qudao" => Baomingq::all(),
                "list" => $lists
            ]);
        }
        return $this->fetch("list");
    }

//搜索名单姓名 或 id
    public function Search()
    {
        $key = input('key');
        $list = Baoming::searchArticle($key);
//        return result(0,$mingdans);
        $this->assign([
            "qudao" => Baomingq::all(),
            "id" => Article::all(),
            "state" => Zhuangtai::all(),
            "list" => $list
        ]);
        return $this->fetch("list");
    }

    public function addarticle()
    {
        $this->assign([
            "types" => Types::all(),
        ]);
        return $this->fetch("add");
    }


    //添加报名信息
    public function add_baoming()
    {
        if (!input("?uname") ||
            !input("?usex") ||
            !input("?address") ||
            !input("?birth") || !input("?ktel") || !input("?word") ||
            !input("?qudao") || !input("?state") || !input("?reason") || !input("?fname") || !input("?fage") ||
            !input("?fwork") || !input("?mname") || !input("?mage") ||
            !input("?mwork") || !input("?alone")
        )
            return $this->error("请检查信息是否遗漏！");

        $uname = input("uname");
        $usex = input("usex");
        $address = input("address");
        $birth = input("birth");
        $ktel = input("ktel");
        $word = input("word");
        $qudao = input("qudao");
        $state = input("state");
        $reason = input("reason");
        $fname = input("fname");
        $fage = input("fage");
        $fwork = input("fwork");
        $mname = input("mname");
        $mage = input("mage");
        $mwork = input("mwork");
        $alone = input("alone");

        if ($uname == "" || $usex == "" || $address == "" || $birth == "" ||
            $ktel == "" || $word == "" || $qudao == "" || $state == "" || $reason == "" || $fname == "" || $fage == "" ||
            $fwork == "" || $mname == "" || $mage == "" || $mwork == "" || $alone == "" || $alone == NULL || $mage == NULL || $mwork == NULL ||
            $fage == NULL || $fwork == NULL || $mname == NULL || $ktel == NULL || $state == NULL || $reason == NULL ||
            $word == NULL || $qudao == NULL || $fname == NULL || $uname == NULL || $usex == NULL || $address == NULL || $birth == NULL
        )
            $this->error("请输入完整内容");
        $Baoming = new Baoming();
        $Baoming->uname = $uname;
        $Baoming->usex = $usex;
        $Baoming->address = $address;
        $Baoming->birth = $birth;
        $Baoming->ktel = $ktel;
        $Baoming->word = $word;
        $Baoming->qudao = $qudao;
        $Baoming->state = $state;
        $Baoming->reason = $reason;
        $Baoming->fname = $fname;
        $Baoming->fage = $fage;
        $Baoming->fwork = $fwork;
        $Baoming->mname = $mname;
        $Baoming->mage = $mage;
        $Baoming->mwork = $mwork;
        $Baoming->alone = $alone;
        $Baoming->save();
        if ($Baoming)
            return $this->success("添加成功", "Baomings/detail?id=" . $Baoming->id);
        else if ($Baoming == NUll)
            return $this->error("添加失败");
    }

    //编辑报名信息
    public function update_baoming()
    {

        $id = input("id");
        $uname = input("uname");
        $usex = input("usex");
        $address = input("address");
        $birth = input("birth");
        $ktel = input("ktel"); //监护人联系方式
        $word = input("word");
        $qudao = input("qudao");
        $state = input("state");
        $reason = input("reason");

        $kname = input("kname");
        $kage = input("kage");
        $kwork = input("kwork");
        $guanxi = input("guanxi");
        $tel = input("tel"); //个人联系方式

        $alone = input("alone");

        $Baoming = Baoming::find($id);
        $Baoming->uname = $uname;
        $Baoming->usex = $usex;
        $Baoming->address = $address;
        $Baoming->birth = $birth;
        $Baoming->ktel = $ktel; //监护人联系方式
        $Baoming->tel = $tel; //个人联系方式

        $Baoming->word = $word;
        $Baoming->qudao = $qudao;
        $Baoming->state = $state;
        $Baoming->reason = $reason;
        $Baoming->kname = $kname;
        $Baoming->kage = $kage;
        $Baoming->kwork = $kwork;
        $Baoming->guanxi = $guanxi;
        $Baoming->alone = $alone;
        $Baoming->save();

        if ($Baoming)
            return $this->success("添加成功", "Baomings/detail?id=" . $Baoming->id);
        else if ($Baoming == NUll)
            return $this->error("添加失败");
        return result(200, "success", $Baoming);
    }

    //删除报名信息
    public function del_baoming()
    {
        if (!input("?id"))
            return $this->error("系统发生错误！");
        $id = input("id");
        if ($id == "")
            return $this->error("系统发生错误！");
        $res = Baoming::destroy($id);
        if ($res)
            return $this->success("删除成功");
        else if ($res == NULL)
            return $this->error("删除失败！");
    }

    //查看描述信息详情
    public function view()
    {
        $list = Baoming::order('id desc')->paginate(10);
        self::assign("list", $list);
//        $this->assign("list",$list);
        return $this->fetch("view");
    }

    //报名状态管理
    public function zhuangtai()
    {
        $list = Baoming::order('id desc')->paginate(10);

        self::assign("list", $list);
//        $this->assign("list",$list);
        return $this->fetch("zhuangtai");
    }

    //查看报名渠道
    public function qudao()
    {
        $list = Baomingq::order('id desc')->paginate(10);
        self::assign("list", $list);
//        $this->assign("list",$list);
        return $this->fetch("qudao");
    }

    //添加报名渠道跳转
    public function add_qudaos()
    {

        return $this->fetch("add_qudaos");
    }

    //添加报名渠道
    public function add_qudao()
    {

        if (!input("?qudao"))
            return $this->error("系统发生错误！");
        $qudao = input("qudao");

        if ($qudao == "" || $qudao == NULL)
            $this->error("请输入完整内容");
        $Qudao = new Baomingq();
        $Qudao->qudao = $qudao;

        $Qudao->save();
        if ($Qudao)
            return $this->success("添加成功", "Baomings/add_qudaos");
        else if ($Qudao == NUll)
            return $this->error("添加失败");
    }

    //删除报名渠道
    public function del_qudao()
    {
        if (!input("?id"))
            return $this->error("系统发生错误！");
        $id = input("id");
        if ($id == "")
            return $this->error("系统发生错误！");
        $res = Baomingq::destroy($id);
        if ($res)
            return $this->success("删除成功");
        else if ($res == NULL)
            return $this->error("删除失败！");
    }
}