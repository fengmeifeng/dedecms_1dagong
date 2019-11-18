<?php
namespace Collect\Controller;

use Library\Common\BaseController;

class SourceController extends BaseController {
	
    public function sourceList() {
        $this->display();
    }
    
    public function add() {
    	if(IS_POST) {
    		
    	}else {
    		$this->display();
    	}
    }
}