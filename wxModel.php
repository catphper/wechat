<?php 

class wxModel
{
	public $appid = "wx302310672a0a630d";
             public $secret = "7a63f0e4816eb17f888deb53f1b6de93";
    //接口配置信息
	public function valid()
            {
                $echoStr = $_GET["echostr"];

                //valid signature , option
                if($this->checkSignature()){
                	echo $echoStr;
                	exit;
                }
            }


//微信发送信息，开发者服务器接受到XML格式数据，进行处理
    public function responseMsg()
    {
             $postStr = file_get_contents('php://input');

             //写入到数据库
             require './db.php';
             $data = array(
                'xml'=>$postStr,
                );
             $database->insert('wechat',$data);

	if (!empty($postStr)){

                            libxml_disable_entity_loader(true);
                            //接受到微信服务器XML发过来的数据：分为时间、消息，按照msgType分，转换为对象
                            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

                            $fromusername = $postObj->FromUserName;
                            $tousername = $postObj->ToUserName;
                            $keyword = $postObj->Content;
                            $msgtype = $postObj->MsgType;
                            $keyword = trim($postObj->Content);

                            //订阅后发送文本事件
                            if ( $msgtype == 'event' ) {
	                            $event = $postObj->Event;
	                            if ( $event == 'subscribe' ) {
	                                //订阅后发送的文本消息
	                                 $textTpl = "<xml>
	                                                    <ToUserName><![CDATA[%s]]></ToUserName>
	                                                    <FromUserName><![CDATA[%s]]></FromUserName>
	                                                    <CreateTime>%s</CreateTime>
	                                                    <MsgType><![CDATA[%s]]></MsgType>
	                                                    <Content><![CDATA[%s]]></Content>
	                                                    <FuncFlag>0</FuncFlag>
	                                                    </xml>";
	                                 $time = time();
	                                 $msgtype = 'text';
	                                 $content = "客官，终于等到你啦！";
	                                 $retStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $content);
	                                echo $retStr;
                          	  }

                          	  //点击菜单的事件推送
                           	 if ( $event == 'CLICK' ) {

                           	 	$key = $postObj->EventKey;

                           	 	switch ( $key ) {
                           	 		case '20000':
	                                 			$content = "你点击的是图文列表菜单！";
                           	 		break;
                           	 		case '30000':
	                                 			$content = "我们是专业挖坑的！";
                           	 		break;
                           	 		case '40000':
	                                 			$content = "没有帮助！";
                           	 		break;
                           	 		default:
						$content = "不存在！";
                           	 		break;
                           	 	}
                           	 		 $textTpl = "<xml>
	                                                    <ToUserName><![CDATA[%s]]></ToUserName>
	                                                    <FromUserName><![CDATA[%s]]></FromUserName>
	                                                    <CreateTime>%s</CreateTime>
	                                                    <MsgType><![CDATA[%s]]></MsgType>
	                                                    <Content><![CDATA[%s]]></Content>
	                                                    <FuncFlag>0</FuncFlag>
	                                                    </xml>";
	                                 $time = time();
	                                 $msgtype = 'text';
	                                 $retStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $content);
	                                echo $retStr;
                          	  }

                          }


                            //发送图片关键字，返回图片
                            if ( $msgtype == 'text' ) {

                                //判断关键字，来自定义回复消息
                                if ( $keyword == '图文' ) {

                                    //这里根据数据库拿到消息，这里只是模仿从数据库拿取消息
                                    $arr = array(
                                        array(
                                                'title'=>"王健林亏两亿卖掉西班牙大厦:其他项目也不投资了",
                                                'date'=>'2017-06-03',
                                                'url'=>"http://news.163.com/17/0602/10/CLTVSGR00001899N.html",
                                                'description'=>"公司已经向Baraka Global Invest出售了西班牙大厦的全部股权",
                                                'picUrl'=>"http://img3.cache.netease.com/photo/0003/2017-06-03/CLVF2KJQ00AJ0003.jpg"
                                            ),
                                        array(
                                                'title'=>"菜鸟、顺丰同意今日12时起恢复数据传输",
                                                'date'=>'2017-06-03',
                                                'url'=>"http://bendi.news.163.com/guangdong/17/0603/10/CM0IJ0RS04178D6J.html",
                                                'description'=>"菜鸟、顺丰同意今日12时起恢复数据传输",
                                                'picUrl'=>"http://img3.cache.netease.com/photo/0003/2017-06-03/CLVF2KJQ00AJ0003.jpg"
                                            ),
                                        array(
                                                'title'=>"菜鸟、顺丰同意今日12时起恢复数据传输",
                                                'date'=>'2017-06-03',
                                                'url'=>"http://bendi.news.163.com/guangdong/17/0603/10/CM0IJ0RS04178D6J.html",
                                                'description'=>"菜鸟、顺丰同意今日12时起恢复数据传输",
                                                'picUrl'=>"http://wmtp.net/224986"
                                            )
                                        );
$textTpl = <<<EOT
                                <xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <ArticleCount>%s</ArticleCount>
                                <Articles>
EOT;
                             $str = "";
                             foreach ($arr as $v) {
                                $str .= "<item>";
                                $str .= "<Title><![CDATA[" . $v['title'] . "]]></Title>";
                                $str .= "<Description><![CDATA[" . $v['description'] . "]]></Description>";
                                $str .= "<PicUrl><![CDATA[" . $v['picUrl'] . "]]></PicUrl>";
                                $str .= "<Url><![CDATA[" . $v['url'] . "]]></Url>";
                                $str .= "</item>";
 		       	 		}

                             $textTpl .= $str;
                             $textTpl .= "</Articles></xml>";

                             $time = time();
                             $msgtype = 'news';
                             $nums = count($arr);
                             $retStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $nums);
                             echo $retStr;

                                }

                                // //测试
                                // if ( $keyword = '测试' ) {

                                //    $textTpl = "<xml>
                                //             <ToUserName><![CDATA[%s]]></ToUserName>
                                //             <FromUserName><![CDATA[%s]]></FromUserName>
                                //             <CreateTime>%s</CreateTime>
                                //             <MsgType><![CDATA[%s]]></MsgType>
                                //             <Content><![CDATA[%s]]></Content>
                                //             <FuncFlag>0</FuncFlag>
                                //             </xml>";
                                //     $time = time();
                                //     $msgtype = 'text';
                                //     $content = '<a href="http://39.108.74.106/www/test.php">测试</a>';
                                //     $retStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $content);
                                //     echo $retStr;
                                // }

                                if ( $keyword == '美女' ) {

                                     $textTpl = <<<EOT
                                <xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Image>
                                <MediaId><![CDATA[%s]]></MediaId>
                                </Image>
                                </xml>
EOT;
                                $time = time();
                                $msgtype = 'image';
                                $mediaid = "VNrSRvlK8-TPcsz5hUv7oEe1-0TSxCOhxNAAwbSNMUp9EZE-7zt17elAmvV0myLm";
                                $retStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $mediaid);
                                echo $retStr;
                                }

                                //天气预报
                                if ( substr($keyword,0,6) == '天气') {
                                	$city = substr($keyword,6,strlen($keyword));
                                	$arr = $this->jsonToArray($this->getWeather($city));
                        	        $textTpl = "<xml>
                                            <ToUserName><![CDATA[%s]]></ToUserName>
                                            <FromUserName><![CDATA[%s]]></FromUserName>
                                            <CreateTime>%s</CreateTime>
                                            <MsgType><![CDATA[%s]]></MsgType>
                                            <Content><![CDATA[%s]]></Content>
                                            <FuncFlag>0</FuncFlag>
                                            </xml>";
                                            // file_put_contents("1.php",$str);

                                 $time = time();
                                 $msgtype = 'text';
                                 $content = $arr['result']['today']['temperature'];
                                 $retStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $content);
                                 echo $retStr;
                                }
                                

                            //发送消息的模板：文本消息
                            $textTpl = "<xml>
                                    <ToUserName><![CDATA[%s]]></ToUserName>
                                    <FromUserName><![CDATA[%s]]></FromUserName>
                                    <CreateTime>%s</CreateTime>
                                    <MsgType><![CDATA[%s]]></MsgType>
                                    <Content><![CDATA[%s]]></Content>
                                    <FuncFlag>0</FuncFlag>
                              </xml>"; 
                            $time = time();
                            $msgtype = 'text';
                            $content = "生活不止眼前的苟且！--LoveSea";
                              $resultStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $content);
                              echo $resultStr;


                            }


        }else {
        	echo "1";
        	exit;
        }
    }
		
        //验证服务器的有效性
    private function checkSignature()
    {
        /*
        1）将token、timestamp、nonce三个参数进行字典序排序
        2）将三个参数字符串拼接成一个字符串进行sha1加密
        3）开发者获得加密后的字符串可与signature对比，标识该请求来源于微信
         */
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
		$token = TOKEN;
		
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

    //curl请求，获取返回数据
    public function getData($url, $method='GET', $arr='') 
    {
        // 1.cUrl初始化
        $ch = curl_init();

        //2.设置cUrl选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        if (strtoupper($method) == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
        }

        //3.执行cUrl请求
        $ret = curl_exec($ch);

        //4.关闭请求
        curl_close($ch);
        return $ret;
    }

    //JSON转化为数组
    public function jsonToArray($json)
    {
        $arr = json_decode($json,1);
        return $arr;
    }

    public function getAccessToken()
    {
        session_start();

        if ( $_SESSION['access_token'] && (time() - $_SESSION['expire_time']) <7100 ) {
            return $_SESSION['access_token'];
        }else{
            
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->secret;
            $access_token = $this->jsonToArray($this->getData($url))['access_token'];
            // var_dump($access_token);
            //将token写入session
            $_SESSION['access_token'] = $access_token;
            $_SESSION['expire_time'] = time();
            return $access_token;
        }
    }

    //获取从第三方接口获取天气信息
    public function getWeather ($city)
   {
    	$appkey = "f0b2211096f48a858ebd8ba02e5c63ad";
    	$url = "http://v.juhe.cn/weather/index?format=2&cityname=".$city."&key=".$appkey;

    	return $this->getData($url);
    }

    //获取用户列表
    public function getUserOpenIdList () 
    {

    	$url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->getAccessToken().'&next_openid=';
    	return $this->jsonToArray($this->getData($url));

    }

    //网页授权的接口，获取用户信息
    public function getUserInfo ()
    {
             $redirect_uri = urlEncode("http://39.108.74.106/www/login.php");
             $code = 'code';
             $scope = 'snsapi_userinfo';
    	$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->appid.'&redirect_uri='.$redirect_uri.'&response_type='.$code.'&scope='.$scope.'&state=STATE#wechat_redirect';
            // $this->getData($url);
        // return $url;
        header('location:'.$url);
    }

    //拉取用户信息
    public function getUserMsg ()
    {
        //通过code换区网页授权access_token
        $code = $_GET['code']; 
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appid.'&secret='.$this->secret.'&code='.$code.'&grant_type=authorization_code ';
         $access_token_arr = $this->jsonToArray($this->getData($url));
         $access_token = $access_token_arr['access_token'];
         $openid = $access_token_arr['openid'];

         $url1 = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
         $userMsgArr = $this->jsonToArray($this->getData($url1));
         return $userMsgArr;
    }

    //群发消息
    public function sendMsg () 
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$this->getAccessToken();
        $data = array(
            'touser' => array(
                0 =>'opvcRw1EmOTA8q0y-GYCaTRu8_5c',
                1 => 'opvcRwxyO2Etu6m5F0FcpICmHwHw',
                2 => 'opvcRw95Xn4IEAWY4gWY99AnbtBg'
                ),
            'test' => array(
                'content' => '生活不止眼前的苟且'
                ),
            'msgtype' => 'text'
            );
        $ret = $this->getData($url, 'POST', $data);
        return $ret;
    }

    //生成临时二维码
    public function getQrCode ()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->getAccessToken();
        $postStr = '{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 666}}}';
        $arr = $this->jsonToArray( $this->getData($url, 'POST', $postStr) );
        $url1 = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.UrlEncode($arr['ticket']);
        return$url1;
    }

}
