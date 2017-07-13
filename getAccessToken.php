<?php
require './vendor/autoload.php';

$appid = "wx302310672a0a630d";
$secret = "7a63f0e4816eb17f888deb53f1b6de93";
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;

//1.cUrl初始化
$ch = curl_init();
//2.设置URL选项
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

//3.执行cUrl请求
$ret = curl_exec($ch);

//关闭请求
curl_close($ch);

echo $ret;
