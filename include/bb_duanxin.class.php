<?php
/**
*短信类。2014-2-13 冰冰写
*/
define("ROOT", str_replace("\\", "/", dirname(__FILE__)).'/');  //类的目录

class Duanxin {
		private $phone="";    				//手机号码
		private $content=""; 	 			//短信内容
		// private $url="http://61.191.26.181:8888/SmsPort.asmx/SendSms?Epid=1000&User_Name=shenbohr&password=5b805590a1636888";		//短信发送地址
		//更换短信平台服务商 By Z
		private $url="http://qd.qxt666.cn/interface/tomsg.jsp?user=shenbo&pwd=shenborl";		//短信发送地址
		

	function __construct($phone="",$content=""){	
		$this->phone=$phone; 
		$this->content=$content;
	}
	function fs(){
		//如果不是手机号码，不发送短信，节省短信条数 By Z
		if(substr($this->phone, 0, 1)!=1){
			return 0;
			exit;
		}
		$this->url.="&phone=".$this->phone."&msgcont=".$this->content;
		// $xml=$this->scurl($this->url);
		$data=$this->scurl($this->url);
		$data=trim($data);
		if(isset($data)){
			// var_dump($data);exit;
			switch ($data){
				//获取短信状态
				case 0:
					$str=date("Y-m-d H:i:s",time())."	号码:".$this->phone."	验证码发送成功！\r\n";
					error_log($str,3,ROOT.'../errors_cg.log');
					return "1";
					break;
				case -1:
					$str=date("Y-m-d H:i:s",time())."	参数不正确！\r\n";
					error_log($str,3,ROOT.'../errors.log');
					return "0";
					break; 	  
				case -2:
					$str=date("Y-m-d H:i:s",time())."  号码,内容等为空或内容长度超过70字限制 \r\n";
					error_log($str,3,ROOT.'../errors.log');
					return "0";
					break;
				case -3:
					$str=date("Y-m-d H:i:s",time())."  号码过多 \r\n";
					error_log($str,3,ROOT.'../errors.log');
					return "0";
					break;
				case -4:
					$str=date("Y-m-d H:i:s",time())."	错误号码！\r\n";
					error_log($str,3,ROOT.'../errors.log');
					return "0";
					break;
				case -5:
					$str=date("Y-m-d H:i:s",time())."	serial只支持20位以内！\r\n";
					error_log($str,3,ROOT.'../errors.log');
					return "0";
					break;
				case -6:
					$str=date("Y-m-d H:i:s",time())."	用户或密码错误！\r\n";
					error_log($str,3,ROOT.'../errors.log');
					return "0";
					break;		 
				case -7:
					$str=date("Y-m-d H:i:s",time())."  余额不足 \r\n";
					error_log($str,3,ROOT.'../errors.log');
					return "0";
					break;
				case -8:
					$str=date("Y-m-d H:i:s",time())."  敏感字符 \r\n";
					error_log($str,3,ROOT.'../errors.log');
					return "0";
					break;
				case -9:
					$str=date("Y-m-d H:i:s",time())."  账户被停用 \r\n";
					error_log($str,3,ROOT.'../errors.log');
					return "0";
					break;
				case -10:
					$str=date("Y-m-d H:i:s",time())."  数据库繁忙 \r\n";
					error_log($str,3,ROOT.'../errors.log');
					return "0";
					break;			
				default:
					$str=date("Y-m-d H:i:s",time())."  短信发送失败 \r\n";
					error_log($str,3,ROOT.'../errors.log');
					return "0";
			}
		}else{
			$str=date("Y-m-d H:i:s",time())."  网络故障短信发送失败 \r\n";
			error_log($str,3,ROOT.'../errors.log');
			return "0";
		}
	}
	//xml 转 数组	
	private function xml2array($xmlobject) {
		$xml = simplexml_load_string($xmlobject);
		if ($xml) {
			foreach ((array)$xml as $k=>$v) {
				$data[$k] = !is_string($v) ? xml2array($v) : $v;
			}
			return $data;
		}
	}	
	//curl函数
	private function scurl($url){
		$ch = curl_init();//初始化一个会话
		curl_setopt($ch, CURLOPT_URL, $url);
		// curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);        
		return curl_exec($ch);
		curl_close($ch);
	}
}

		/*$content1="【壹打工网】您好，您的壹打工网注册验证码为123123。电脑或手机访问www.1dagong.com，随时随地找工作。";
        $content1=mb_convert_encoding($content1, "GBK","UTF-8");
		$dx=new duanxin('15555136682',$content1);		//申明短信类
		$id=$dx->fs();	*/