<?php
	class Common extends Action {
		function init(){
			if(!(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"]===1)){
					$this->redirect("login/index");
			}
		}
	}