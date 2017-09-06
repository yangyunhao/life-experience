<?php  
    header('content-type:text/html;charset=utf-8');
    //传值三个参数      访问路径  数值   方式
    function curlPost($url,$data,$method){  
        $ch = curl_init();   //1.初始化  
        curl_setopt($ch, CURLOPT_URL, $url); //2.请求地址  
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);//3.请求方式  
        //4.参数如下  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//https  
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');//模拟浏览器  
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);  
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept-Encoding: gzip, deflate'));//gzip解压内容  
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');  
          
        if($method=="POST"){//5.post方式的时候添加数据  
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
        }  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        $tmpInfo = curl_exec($ch);//6.执行  
      
        if (curl_errno($ch)) {//7.如果出错  
            return curl_error($ch);  
        }  
        curl_close($ch);//8.关闭  
        return $tmpInfo;  
    }
    //传值数组
    $data=array('name' => '1234');
    //路径
    $url="http://blog.jobbole.com/tag/php/";  
    //访问方式
    $method="GET";
    //调用传值
    $file=curlPost($url,$data,$method);
    //这个函数进行转码
    $file=mb_convert_encoding($file,'UTF-8','GBK');  

    echo $file;



    //当cookie认证登陆的时候
    

    $cookie_file = tempnam('./temp','cookie');  
    function weixinPost($url,$data,$method,$setcooke=false,$cookie_file=false){  
        $ch = curl_init();   //1.初始化  
        curl_setopt($ch, CURLOPT_URL, $url); //2.请求地址  
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);//3.请求方式  
        //4.参数如下      
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');  
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);  
          
        if($method=="POST"){//5.post方式的时候添加数据     
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
        }  
        if($setcooke==true){  
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);  
        }else{  
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);  
        }  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        $tmpInfo = curl_exec($ch);//6.执行  
  
        if (curl_errno($ch)) {//7.如果出错  
            return curl_error($ch);  
        }  
        curl_close($ch);//8.关闭  
        return $tmpInfo;  
    }  
    $data=array('username' => '***','password'=>'***');  
    $url="http://www.xinxinj.com/login.php";  
    $method="POST";  
    $file=weixinPost($url,$data,$method,true,$cookie_file);  
    echo $file;  
          
    $url="http://www.xinxinj.com/admin.php";  
    $method="GET";  
    $file=weixinPost($url,$data,$method,false,$cookie_file);  
    echo $file;  
?>  