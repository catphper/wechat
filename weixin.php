<?php
/**
  * wechat php test
  */

//define your token
// define("TOKEN", "xdl2017");
// $wechatObj = new wechatCallbackapiTest();

// if ($_GET['echostr'])
// {
// 	$wechatObj->valid();
// }
// else
// {
// 	$wechatObj->responseMsg();
// }

// $wechatObj->valid();

// class wechatCallbackapiTest
// {
// 	public function valid()
//     {
//         $echoStr = $_GET["echostr"];

//         //valid signature , option
//         if($this->checkSignature()){
//         	echo $echoStr;
//         	exit;
//         }
//     }

//     public function responseMsg()
//     {
// 		//get post data, May be due to the different environments
// 		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

//       	//extract post data
// 		if (!empty($postStr)){
//                 /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
//                    the best way is to check the validity of xml by yourself */
//                 libxml_disable_entity_loader(true);
//               	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
//                 $fromUsername = $postObj->FromUserName;
//                 $toUsername = $postObj->ToUserName;
//                 $keyword = trim($postObj->Content);
//                 $time = time();
//                 $textTpl = "<xml>
// 							<ToUserName><![CDATA[%s]]></ToUserName>
// 							<FromUserName><![CDATA[%s]]></FromUserName>
// 							<CreateTime>%s</CreateTime>
// 							<MsgType><![CDATA[%s]]></MsgType>
// 							<Content><![CDATA[%s]]></Content>
// 							<FuncFlag>0</FuncFlag>
// 							</xml>"; 
// 				if(!empty( $keyword ))
//                 {
//               		$msgType = "text";
//                 	$contentStr = "Welcome to wechat world!";
//                 	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
//                 	echo $resultStr;
//                 }else{
//                 	echo "Input something...";
//                 }

//         }else {
//         	echo "";
//         	exit;
//         }
//     }
		
// 	private function checkSignature()
// 	{
//         /*
//         1）将token、timestamp、nonce三个参数进行字典序排序
//         2）将三个参数字符串拼接成一个字符串进行sha1加密
//         3）开发者获得加密后的字符串可与signature对比，标识该请求来源于微信
//          */
//         // you must define TOKEN by yourself
//         if (!defined("TOKEN")) {
//             throw new Exception('TOKEN is not defined!');
//         }
        
//         $signature = $_GET["signature"];
        
//         $timestamp = $_GET["timestamp"];
//         $nonce = $_GET["nonce"];
// 		$token = TOKEN;
		
//         $tmpArr = array($token, $timestamp, $nonce);
//         // use SORT_STRING rule
// 		sort($tmpArr, SORT_STRING);
// 		$tmpStr = implode( $tmpArr );
// 		$tmpStr = sha1( $tmpStr );
		
// 		if( $tmpStr == $signature ){
// 			return true;
// 		}else{
// 			return false;
// 		}
// 	}
// }

/**
  * wechat php test
  */
//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();
$wechatObj->responseMsg();


class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if($this->checkSignature()){
        echo $echoStr;
        exit;
        }
    }



    public function responseMsg()
    {
        //get post data, May be due to the different environments
        // $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postStr = file_get_contents('php://input');
        file_put_contents('1.txt',$postStr,FILE_APPEND);

        // file_put_contents('1.txt',$postStr,FILE_APPEND);
        //       //extract post data
        if (!empty($postStr)){
                
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            file_put_contents('1.txt', '@@@'.$postObj->Content,FILE_APPEND);

        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $time = time();
        $textTpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                <FuncFlag>0</FuncFlag>
                </xml>";
                file_put_contents('1.txt',$textTpl,FILE_APPEND);           
                if(!empty( $keyword ))
                {
                    $msgType = "text";
                    $contentStr = "Welcome to wechat world!";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                    }else{
                    echo "Input something...";
                }
        }else {
            file_put_contents('1.txt','bbb',FILE_APPEND);
            echo "sibiantai";
            exit;
        }
    }
private function checkSignature()
{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
       
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }
        else{
            return false;
        }
    }
    }

?>
