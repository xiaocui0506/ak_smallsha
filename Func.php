<?php
/**
 * 是否是AJAx提交的
 * @return bool
 */
if(!function_exists('isAjax')){
	function isAjax(){
	  if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	    return true;
	  }else{
	    return false;
	  }
	}
}

/**
 * 是否是GET提交的
 */
if(!function_exists('isGet')){
	function isGet(){
	  return $_SERVER['REQUEST_METHOD'] == 'GET' ? true : false;
	}
}

/**
 * 是否是POST提交
 * @return int
 */
if(!function_exists('isPost')){
	function isPost() {
	  return ($_SERVER['REQUEST_METHOD'] == 'POST' && checkurlHash($GLOBALS['verify']) && (empty($_SERVER['HTTP_REFERER']) || preg_replace("~https?:\/\/([^\:\/]+).*~i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("~([^\:]+).*~", "\\1", $_SERVER['HTTP_HOST']))) ? true : false;
	}
}

/**
 * 对象数组转换
 * @return int
 */
if(!function_exists('jsonArray')){
	function jsonArray($to){
		if(gettype($to) == 'array'){
		  return $a= json_decode( json_encode( $to));
		}elseif(gettype($to)== 'object'){
          return json_decode( json_encode( $to),true);
		}
	}


/**
 * base64  结合 serialize 转化 array 
 * @return int
 */
if(!function_exists('baseSerialize')){
	function baseSerialize($to){
		if(gettype($to) == 'array'){
		  return base64_encode( serialize($to));
		}else{
          return unserialize( base64_decode( $to));
		}
	}

	发生的
}


 