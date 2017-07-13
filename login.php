<?php 
	
	// var_dump($_GET);
include "./vendor/autoload.php";
include "./db.php";
require "wxModel.php";
$wechatObj = new wxModel();
$userMsgArr = $wechatObj->getUserMsg();
$data['name'] = $userMsgArr['nickname'];//用户昵称
 $data['sex'] = $userMsgArr['sex'];//用户昵称
 $data['province'] = $userMsgArr['province'];//用户昵称
 $data['city'] = $userMsgArr['city'];//用户昵称
// var_dump($wechatObj->getUserMsg());
 $database->insert('user',$data);
 var_dump($data);


