<?php
namespace Demo;
use PHPExcel;
class Excel
{
    //导出
    public function export($name, $header,$data){
        $PHPExcel = new \PHPExcel();
        $PHPSheet = $PHPExcel->getActiveSheet();
        $PHPSheet->setTitle($name);
        $key = $this->letter();
        foreach($header as $k=>$v){
            $PHPSheet->setCellValue($key[$k].'1',$v);
        }
        $i=2;
        foreach($data as $k=>$v){
            $ii = 0;
            foreach($v as $k1=>$v1){
                $PHPSheet->setCellValue($key[$ii].$i,$v1);
                $ii++;
            }
            $i++;
        }
        $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, "Excel2007");
        header('Content-Disposition: attachment;filename="'.$name.'.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output");
    }
    //字母数组
    public function letter() {
        $data = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        return $data;
    }
}