<?php
require "wxModel.php";

define("TOKEN", "weixin");
$wechatObj = new wxModel();

if ($_GET['echostr'])
{
	$wechatObj->valid();
}
else
{
	$wechatObj->responseMsg();
}

$wechatObj->valid();






