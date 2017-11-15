<?php


	// 其实就是过滤从表单提交来的数据，使用php过滤函数就可以达到很好的目的。
	
    if (isset($_POST['name'])){  
        $str = trim($_POST['name']);  //清理空格  
        $str = strip_tags($str);   //过滤html标签  
        $str = htmlspecialchars($str);   //将字符内容转化为html实体  
        $str = addslashes($str);  
        echo $str;  
    }  

?>  
   