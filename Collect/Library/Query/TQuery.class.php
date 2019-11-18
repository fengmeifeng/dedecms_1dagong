<?php
namespace Library\Query;

class TQuery {
	
	public static $map = array();
	
    public static function TModel($model) {
    	if(!isset(self::$map[$model])) {
    		self::$map[$model] = D($model);
    	}
    	
    	return self::$map[$model];
    }
   
    public static function TService($model,$service) {
   		return D($model,$service);
    }
}