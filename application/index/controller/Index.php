<?php
namespace app\index\controller;
use app\admin\model\Admin;
use think\Controller;
use think\Session;
class Index extends Controller
{
    public function index()
    {
        return $this->redirect('admin/Login/index');
    }
}
