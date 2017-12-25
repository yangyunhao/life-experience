<?php
class study{

    /*
     * effect  冒泡排序
     * author  YangYunHao
     * email   1126420614@qq.com
     * time    2017-12-24 18:04:41
     * */
    public function bubbleOrder(array $arr = [])
    {
        if(count($arr) > 1){
            $length = count($arr);
            for($i = 0;$i<$length-1;$i++){
                for($a = 0;$a<$length-1;$a++){
                    if($arr[$a] > $arr[$a+1]){
                        list($arr[$a],$arr[$a+1]) = [$arr[$a+1],$arr[$a]];
                    }
                }
            }
            print_r($arr);
        }else{
            print_r($arr);
        }
    }

    /*
     * effect  快速排序
     * author  YangYunHao
     * email   1126420614@qq.com
     * time    2017-12-24 18:04:41
     * */
    public function fastOrder(array $arr = [])
    {
        if(count($arr) > 1){
            $rule     = $arr[0]; // 定义标尺
            $smallArr = []; // 定义小数组存放小于标尺的数据
            $bigArr   = []; // 定义大数组存放大于标尺的数据
            for($i=1;$i<count($arr);$i++){
                if($arr[$i] < $rule){ // 如果当前数据小于标尺
                    $smallArr[] = $arr[$i]; // 放入小数组
                }else{ // 当前数据大于标尺
                    $bigArr[]   = $arr[$i]; // 放入大数组
                }
                $smallArr = $this->fastOrder($smallArr); // 小数组内的值继续进行排序 直到值只有一个的时候停止
                $bigArr   = $this->fastOrder($bigArr); // 大数组内的值继续进行排序 直到值只有一个的时候停止
            }

            return array_merge($smallArr,[$rule],$bigArr); // 数组合并返回
        }else{
            return $arr; // 不需要排序数组原样返回
        }
    }
}

$obj = new study(); // 实例化类
//$obj->bubbleOrder([6,4,7,3,8,2,9,1,0,5]); // 冒泡排序
$order = $obj->fastOrder([6,4,7,3,8,2,9,1,0,5]); // 快速排序
?>