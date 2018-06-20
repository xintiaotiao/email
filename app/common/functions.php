<?php
/**
 * laravel框架引入外部文件或自定义函数
 * 1、做composer.json配置
 * 2、通过composer  dump-auto 重新生成自动加载文件
 * 3、在php文件中或者模板中可以直接调用自定义函数
 * 4、可以取代连表查询，在模板显示的时候
 */

//通过pid获取当前pid的上级部门名称
function deptGetName($pid)
{
	if($pid == 0){
		return '根部门';
	} if($pid == 1) {
		return '顶级部门';
	} else if($pid >1) {
		return	DB::table('em_dept')->where('id',$pid)->first()->name;
	}
	
}

//通过部门dept_id 获取当前部门名称
function deptName($dept_id)
{
	return	DB::table('em_dept')->where('id',$dept_id)->first()->name;
}

//通过id获取当前id的账号类别，1超级管理员，2，管理员，3普通用户
function roleGetName($role_id)
{
	if($role_id == 1) {
		return '超级管理员';
	}else if($role_id == 2) {
		return '管理员';
	}else if($role_id == 3){
		return '普通用户';
	}

}


//通过id寻找当前id有多少个子对象
function childNum($id)
{
	return DB::select("select count(*) as count from em_dept where pid =  " . $id);
}

//根据dept_id获取用户em_user的信息
function userFromDept($dept_id)
{
	 return DB::table('em_user')->where("dept_id",$dept_id)->get();
}

//通过用户id读取用户信息
function userInfo($id)
{
	return DB::table('em_user')->where('id',$id)->first();
}

//江一个数组链接为一个字符串
function arrayToString($array)
{
	$str = '';
	foreach($array as $k=>$v){
		$str .= $v . ',';
	}
	return trim($str,',');
}

//定义一个方法，获取当前用户的未读邮件
function getEmail($id)
{
	//通过id获取当前用户的未读邮件数量
	return DB::table('em_email')->where('to_id',$id)->where('is_read',0)->count();
}

//通过role_id 获取角色表信息
function getRole($role_id)
{
	return DB::table('em_role')->where('id',$role_id)->first();
}

//判断当前权限是否在权限列表中，如果在则选中，用in_array
function auth_exists($str,$arrStr)
{
	//把字符串分割成数组
	$array = explode(',',$arrStr);
	return in_array($str,$array);

	
}

//通过角色id，获取权限信息表中的权限字段
function getAuth($id)
{
	$info = DB::table('em_role_auth')->where('role_id',$id)->first();
	if($info){
		return $info->auth_id;
	}else{
		return null;
	}
}

//导出excel
function out($table)
    {
    	//导出     
    	//控制器中use PHPExcel;  use IOFactory;
    	 //$objPHPExcel = new PHPExcel();    
    
       //print_r($objPHPExcel);    
    
        $query =DB::table($table)->get();    
    
        //$query =$this ->db->query($sql);    
    
       //print_r($query);    
    
        if(!$query)return false;    
    
        //Starting the PHPExcel library    
    
        //加载PHPExcel类    
    
       //$this->load->library('PHPExcel');    
    
        //$this->load ->library('PHPExcel/IOFactory');    
    
        $objPHPExcel= new PHPExcel();    
    
       //include_once('../app/libs/PHPExcel/IOFactory.php');    
    
        $objPHPExcel->getProperties()-> setTitle("output") ->setDescription("none");    
    
        $objPHPExcel-> setActiveSheetIndex(0);    
    
        //Fieldnamesinthefirstrow    
    
        $fields = DB::select('select COLUMN_NAME from information_schema.COLUMNS where    
    
           table_name = '. "'".$table."'" .';'); 

    
       //print_r($fields);die;    
    
        $col = 0;    
    
       foreach($fields as $field){    
    
            $field =$field->COLUMN_NAME;    
    
            $objPHPExcel-> getActiveSheet() -> setCellValueByColumnAndRow($col, 1,$field);    
    
            $col++;    
    
        }    
    
       // die;    
       //Fetchingthetabledata    
    
       $row = 2;    
    
        foreach($query as $key=>$data)    
        {    
    
             $col =0;    
    
              foreach($fields as $field)
              {    
    
            	  $field =$field->COLUMN_NAME;      
    
                 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,!empty($data->$field)?$data->$field : '');    
    
                 $col++;    
    
             }   
    
            $row++;    
    
        }    
    
        //die;    
    
        $objPHPExcel-> setActiveSheetIndex(0);    
    
        $objWriter = IOFactory :: createWriter($objPHPExcel, 'Excel5');    
    
        //Sendingheaderstoforcetheusertodownloadthefile    
    
        header('Content-Type:application/vnd.ms-excel');    
    
       //header('Content-Disposition:attachment;filename="Products_' .date('dMy') . '.xls"');    
    
        header('Content-Disposition:attachment;filename="Brand_' .date('Y-m-d') . '.xls"');    
    
        header('Cache-Control:max-age=0');    
    
        $objWriter-> save('php://output'); 

    }

//read
function read($filename,$encode='utf-8')     
{    
    
 // ../  一般情况不管处于什么子目录子需要这样子即可 例如\app\Admin\Controllers\WechatMercharntPay\OrderListTodayController.php  
        //include_once('../app/libs/phpexcel/phpexcel/IOFactory.php');    
    
        //$this->load ->library('PHPExcel/IOFactory');    
    
        $objReader =IOFactory::createReader('Excel5');    
    
        $objReader->setReadDataOnly(true);    
    
        $objPHPExcel= $objReader->load($filename);    
    
        $objWorksheet= $objPHPExcel->getActiveSheet();    
    
        $highestRow =$objWorksheet->getHighestRow();    
    
        //echo$highestRow;die;    
    
        $highestColumn = $objWorksheet->getHighestColumn();    
    
        //echo$highestColumn;die;    
    
        $highestColumnIndex =PHPExcel_Cell::columnIndexFromString($highestColumn);    
    
        $excelData =array();    
    
        for($row = 1;$row <= $highestRow; $row++) {    
    
            for ($col= 0; $col < $highestColumnIndex; $col++) {    
    
                   $excelData[$row][]=(string)$objWorksheet->getCellByColumnAndRow($col,$row)->getValue();    
    
             }    
    
        }    
        return $excelData;    
    
} 
