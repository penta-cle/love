<?php
namespace app\admin\controller;
use app\admin\model\Baoming;
use think\Controller;
use think\Session;
use think\Cache;

class Index extends Controller
{

//判断登陆
    protected function _initialize()
    {
        if((Session::has('loged_name','admin'))==NULL)
            return $this->error('请先登录', 'Login/index');
        else
            ;
    }
    public function index()
    {
        //获取系统概要信息
        $this->redirect("login/index");
    }
//
//
//    //清除缓存
//    public function clear()
//    {
//        Cache::clear();
//        return $this->index();
//    }

//上传文件
    public function uploads()
    {
        // 获取表单上传文件
        $imgs = request()->file('imgs');
        $i = 0;$error=[];$path=[];
        $head = input('server.REQUEST_SCHEME') . '://' . input('server.SERVER_NAME');
        foreach($imgs as $file){

            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH .'public'. DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                $path[$i] = $head."/uploads/".$info->getSavename();

            }else{
                // 上传失败获取错误信息
                $error[$i] = $file->getError();
            }
            $i++;
        }
        $data = [
            "path"=> $path,
            "error"=> $error,
        ];
        return json($data);
    }

    //上传文件
    public function upload()
    {
        // 获取表单上传文件
        $imgs = request()->file('imgs');
        $i = 0;$error=0;$path=[];
        $head = input('server.REQUEST_SCHEME') . '://' . input('server.SERVER_NAME');
        foreach($imgs as $file){

            $linshi = $file->move(ROOT_PATH .'public'. DS . 'linshi');
            if($linshi){

                $linshiname =  ROOT_PATH .'public'. DS . 'linshi'.DS;
                $linshiname .=  $linshi->getSavename();
                $image = \think\Image::open($linshiname);
                $image->thumb(750, 750)->save(ROOT_PATH .'public'. DS . 'uploads'.DS.$linshi->getSavename());
                // 移动到框架应用根目录/public/uploads/ 目录下
                //$info = $file->move(ROOT_PATH .'public'. DS . 'uploads');

                // 成功上传后 获取上传信息
                $path[$i] = $head."/uploads/".$linshi->getSavename();

//                $move_url = config(‘excel_path’);
//                $file = request()->file(‘xls_file’);
//                $info = $file->validate([‘size’=>52428800,’ext’=>’xls,xlsx’])->rule(‘uniqid’)->move($move_url);
//                unset($info);
//                unlink($linshiname);

            }else{
                // 上传失败获取错误信息
                $error[$i] = $file->getError();
            }
            $i++;
        }
        $data = [
            "data"=> $path,
            "errno"=> $error,
        ];
        return json($data);
    }

    //导出excel表格 -- 报名表信息
    public function exportSignup(){
        $data = Baoming::alias('s')
            //            ->join('attendee a', 's.aid=a.id')
//            ->join('meeting m', 's.mid=m.id')
            ->field("s.*")
            ->order('id')//按id排序
            ->select();
        $field = array(
            'A' => array('id', 'ID'),
            'B' => array('uname', '用户姓名'),
            'C' => array('birth', '出生日期'),
            'D' => array('address', '住址'),
            'E' => array('tel', '联系方式（个人）'),
            'F' => array('qudao', '报名渠道'),
            'G' => array('alone', '独生子女'),
            'H' => array('kname', '监护人'),
            'I' => array('guanxi', '关系'),
            'J' => array('kage', '年龄'),
            'K' => array('ktel', '联系方式（监护人）'),
            'L' => array('kwork', '工作单位'),
            'M' => array('state', '报名状态'),
            'N' => array('create_time', '报名时间')
        );

        $this->phpExcelList($field, $data, '报名明细_' . date("Y-m-d H时i分"));

    }

    //phpexcel
    public function phpExcelList($field, $list, $title='文件')
    {
        vendor('phpExcel.PHPExcel');
        $objPHPExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel); //设置保存版本格式
        foreach ($list as $key => $value) {
            foreach ($field as $k => $v) {
                if ($key == 0) {
                    $objPHPExcel->getActiveSheet()->setCellValue($k . '1', $v[1]);
                }
                $i = $key + 2; //表格是从2开始的
                $objPHPExcel->getActiveSheet()->setCellValue($k . $i, $value[$v[0]]);
            }

        }
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename='.$title.'.xls');
        header("Content-Transfer-Encoding:binary");
        //        $objWriter->save($title.'.xls');
        $objWriter->save('php://output');
    }

}