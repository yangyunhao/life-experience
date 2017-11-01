<?php

// 初次访问 验证码生成
 <li class="validate">
    <input type="text" id="code" placeholder="请输入验证码"/>
    <img id="captcha_img" src="/Users/captcha?time=0.7279450597531716" alt=""/>
</li>


// 输入验证码后 验证码错误 自动 生成新二维码替换代码（js）
var src = $('#captcha_img').attr('src') + '?time=' + Math.random();
$('#captcha_img').attr('src', src);

// 点击更换验证码 (js)
$('#captcha_img').click(function () {
    var src = $(this).attr('src') + '?time=' + Math.random();
    $(this).attr('src', src);
});

// php 代码生成
public function captcha()
{
    $this->autoRender = false; // 禁止使用模板
    include 'CaptchaController.php'; // 引入二维码类
    $Captcha = new CaptchaController(); // 实例化类
    return $Captcha->create(); // 生成图片
}
?>