<?php
require_once('waf.php');

class weixin{
	private $times;				//消息发送时间
	private $tokey="";    		//tokey
	/*------------------*/
	private $fromUsername;		//发给的用户		
	private $toUsername;		//自己
	private $totime;			//消息时间
	private $type;				//消息类型
/*-----------------------------------------------------------*/
	private $path;
	private $name;
	
	function session($sess_name="",$sess_path="bingbing_weixin"){
		$this->path=$_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.$sess_path.DIRECTORY_SEPARATOR."session";
		$this->name=$sess_name; 
		ini_set("session.save_handler","user");
		session_set_save_handler(array(&$this, 'open'),array(&$this, 'close'),array(&$this, 'read'),array(&$this, 'write'),array(&$this, 'destroy'),array(&$this, 'gc'));
		session_start();
	}
	
	//------------session_start()-----------------//
	function open($savePath, $sessionName){
		if (!is_dir($this->path)||!file_exists($this->path)){
			@mkdir($this->path, 0777);
		}
		return true;
	}
	//--------------关闭session----------------//
	function close(){
		return true;
	}
	//-----------------读取session自动调用----------------------//
	function read($id){
		$s=(string)@file_get_contents(rtrim($this->path,DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR."sess_".$this->name);
		return $s;
		
	}
	//------------------写入session时自动调用--------------------------//
	function write($id, $data){
		if(!empty($data)){
			return file_put_contents(rtrim($this->path,DIRECTORY_SEPARATOR)."/sess_".$this->name, $data) === false ? false : true;
		}
	}
	//---------------------session_destroy()--------------------//
	function destroy($id){		
		$file = rtrim($this->path,DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR."sess_".$this->name;
		if (file_exists($file)) {
			unlink($file);
		}
		return true;
	}
	//--------------------session已经过期自动调用--------------//
	function gc($maxlifetime){		
		foreach (glob(rtrim($this->path,DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR."sess_".$this->name) as $file) {
			if (filemtime($file) + $maxlifetime < time() && file_exists($file)){
				unlink($file);
			}
		}
		return true;
	}
	
	
/*-----------------------------------------------------------*/	
	//接收tokey
	function __construct($tokey){	
		$this->tokey=$tokey; 
	}
	
	//微信链接调用
	public function valid(){
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }
	
	//微信验证消息真实性
	private function checkSignature(){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
		$token = $this->tokey;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	
	public function responseMsg(){	
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if(!empty($postStr)){
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$this->fromUsername = $postObj->FromUserName;
			$this->toUsername   = $postObj->ToUserName;
			$this->totime  = $postObj->CreateTime;
			$this->type    = $postObj->MsgType;
			
			$data=array("touser"=>$postObj->ToUserName,
						"fronuser"=>$postObj->FromUserName,
						"totime"=>$this->totime,
						"type"=>$this->type
						);

			switch($this->type){
				//获取文本消息
				case "text" :
					$data['key']=trim($postObj->Content);
					return $data;
					break;
				//获取图片消息
				case "image":
					$data['picurl']=$postObj->PicUrl;
					return $data;
					break;
				//获取语音推送
				case "voice":
					$data['mediaId']=$postObj->MediaId;
					$data['format']=$postObj->Format;
					$data['recognition']=$postObj->Recognition;
					return $data;
					break;
				//获取视频推送
				case "video":
					$data['mediaId']=$postObj->MediaId;
					$data['thumbMediaId']=$postObj->ThumbMediaId;
					return $data;
					break;
				//获取地理位置消息
				case "location":
					$data['x']=$postObj->Location_X;
					$data['y']=$postObj->Location_Y;
					$data['scale']=$postObj->Scale;
					$data['label']=$postObj->Label;
					return $data;
					break;
				//获取链接消息
				case "link":
					$data['title']=$postObj->Title;
					$data['descr']=$postObj->Description;
					$data['url']=$postObj->Url;
					return $data;
					break;
				//获取事件推送
				case "event":
					$data['event']=$postObj->Event;
					switch($postObj->Event){
						//获取2微码关注消息
						case "subscribe":
							$data['eventKey']=$postObj->EventKey;
							$data['ticket']=$postObj->Ticket;
							return $data;
							break;
						//获取2微码参数消息
						case "SCAN":
							$data['eventKey']=$postObj->EventKey;
							$data['ticket']=$postObj->Ticket;
							return $data;
							break;
						//上报地理位置
						case "LOCATION":
							$data['x']=$postObj->Latitude;
							$data['y']=$postObj->Longitude;
							$data['Precision']=$postObj->Precision;
							return $data;
							break;	
						//自定义菜单
						case "CLICK":
							$data['eventKey']=$postObj->EventKey;
							return $data;
							break;							
					}
					break;
			}
		}else{
			$this->reply("text","出错了！请联系开发者.");
			exit;
		}
	}
	//微信封装类,
	//type: text 文本类型, news 图文类型
	//text,array(内容),array(ID)
	//news,array(array(标题,介绍,图片,超链接),...小于10条),array(条数,ID)
	function reply($type,$value_arr,$o_arr=array(0)){
		$this->times = time();
		$con="<xml>
		<ToUserName><![CDATA[{$this->fromUsername}]]></ToUserName>
		<FromUserName><![CDATA[{$this->toUsername}]]></FromUserName>
		<CreateTime>{$this->times}</CreateTime>
		<MsgType><![CDATA[{$type}]]></MsgType>";
		 switch($type){
			//文本回复
			case "text" : 
				$con.="<Content><![CDATA[{$value_arr}]]></Content>
				<FuncFlag>{$o_arr}</FuncFlag>";  
				break;
			//音乐消息
			case "music" :
				$con.="<Music>
				 <Title><![CDATA[".$value_arr['title']."]]></Title>
				 <Description><![CDATA[".$value_arr['description']."]]></Description>
				 <MusicUrl><![CDATA[".$value_arr['musicurl']."]]></MusicUrl>
				 <HQMusicUrl><![CDATA[".$value_arr['hqmusicurl']."]]></HQMusicUrl>
				</Music>";
				break;
			//图文回复
			case "news" : 
				$con.="<ArticleCount>{$o_arr[0]}</ArticleCount>
				<Articles>";
				foreach($value_arr as $id=>$v){
				if($id>=$o_arr[0]) break; else null; 	//判断数组数不超过设置数
					$con.="<item>
					<Title><![CDATA[{$v[0]}]]></Title> 
					<Description><![CDATA[{$v[1]}]]></Description>
					<PicUrl><![CDATA[{$v[2]}]]></PicUrl>
					<Url><![CDATA[{$v[3]}]]></Url>
					</item>";
				}
				$con.="</Articles>
				<FuncFlag>{$o_arr[1]}</FuncFlag>";  
				break;
		 }
		echo $con."</xml>";
	}
}


//微信高级类操作类
class weixin_gj{

	public $appid = "";
	public $appsecret = "";
	
	//接收id,server
	function __construct($appid="",$appsecret=""){	
		$this->appid=$appid; 
		$this->appsecret=$appsecret; 
	}
	
	
	function key(){
	
		$token=$this->access_token();
		//print_r($token);
		//echo $token['access_token'];
	
	}
	
	//获得凭证接口
	//返回数组，access_token 和  time 有效期 
	public function access_token() {
		//$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsecret}";
		$url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET';
		$cont=$this->scurl($url);
		print_r($cont);
		//return json_decode($cont, 1);
		
	}
	
	//curl函数
	function scurl($url){
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);        
		return $aa=curl_exec($ch);
		echo $url;
		echo $aa;
		curl_close($ch);
	}
}