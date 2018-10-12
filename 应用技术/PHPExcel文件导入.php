<?php
// 在网上下载PHPExcel文件下载完成后只保留Classes即可,这是本人的GitHub上的文件地址

// https://github.com/yangyunhao/life-experience/tree/master/Php%E7%AC%AC%E4%B8%89%E6%96%B9%E7%B1%BB

// 读取文件
public function read(){
    $filename = '../权限对照表.xlsx';
    include_once('../app/Libraries/PHPExcel/Classes/PHPExcel/IOFactory.php'); // 包含PHPExcel 文件
    $objPHPExcelReader = PHPExcel_IOFactory::load($filename);
    $reader = $objPHPExcelReader->getWorksheetIterator();
    //循环读取sheet
    foreach($reader as $sheet) {
        //读取表内容
        $content = $sheet->getRowIterator();
        //逐行处理
        $res_arr = array();
        foreach($content as $key => $items) {

            $rows = $items->getRowIndex();    			//行
            $columns = $items->getCellIterator();		//列
            $row_arr = array();
            //确定从哪一行开始读取
            if($rows < 2){
                continue;
            }
            //逐列读取
            foreach($columns as $head => $cell) {
                //获取cell中数据
                $data = $cell->getValue();
                $row_arr[] = $data;
            }
            $res_arr[] = $row_arr;
        }

    }
    return $res_arr;
}