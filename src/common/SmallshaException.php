<?php
namespace Smallsha\common;

/**
 * @author: smallsha
 * @description: 统一的异常处理类
 */

class SmallshaException extends \Exception {

   public function errorMessage()
    {
        return $this->getMessage();
    }
}
	
