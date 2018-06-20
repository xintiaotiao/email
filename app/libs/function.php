<?php

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
    
           table_name = '. "'".$table."'" .' ;');    
    
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
    