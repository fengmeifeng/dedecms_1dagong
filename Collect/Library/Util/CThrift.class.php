<?php
namespace Library\Util;

require_once './Library/Thrift/ClassLoader/ThriftClassLoader.php';
require_once './Library/Thrift/XpathServer/HdfsServer.php';

use Thrift\ClassLoader\ThriftClassLoader;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\THttpClient;
use Thrift\Transport\TBufferedTransport;
use Thrift\Exception\TException;
use XpathServer\HdfsServerClient;

class CThrift {
	
	public static $transport = null;
	public static $client = null;
	
	public static function getConnect() {
		$loader = new ThriftClassLoader();
		$loader->registerNamespace('Thrift', "./Library");
		$loader->register();
		
		$socket = new TSocket(C('THRIFTHOST'), C('THRIFTPORT'));
		
		$socket->setSendTimeout(C('SENDTIMEOUT'));
		$socket->setRecvTimeout(C('RECVTIMEOUT'));
		
		self::$transport = new TBufferedTransport($socket);
		$protocol = new TBinaryProtocol(self::$transport);
		self::$client = new HdfsServerClient($protocol);
		
		self::$transport->open();
		
	}	
	
	public static function getDomainList($path,$start,$perpage) {
		self::getConnect();
		
		$host = self::$client->getDomainList($path,$start,$perpage);
		
		$key = md5($path);
		$count = S($key);
		if(!$count) {
			$count = self::$client->getDomainCount($path);
			S(md5($path),$count,'86400');
		} 
		
		self::close();
		return array('total' => $count,'data' => json_decode($host,1));
	}
	
	public static function getPathList($path) {
		self::getConnect();
		
		$path = self::$client->getPathList($path);
		
		self::close();
		return json_decode($path,1);
	}
	
	public static function close() {
		self::$transport->close();
	}
}