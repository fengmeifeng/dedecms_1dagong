<?php
/** ******************************************************************************
 * brophp.com 分页类，可以自定义分页显示内容。                                   *
 * *******************************************************************************
 * 许可声明：专为《细说PHP》读者及LAMP兄弟连学员提供的“学习型”超轻量级php框架。*
 * *******************************************************************************
 * 版权所有 (C) 2011-2013 北京易第优教育咨询有限公司，并保留所有权利。           *
 * 网站地址: http://www.lampbrother.net (LAMP兄弟连)                             *
 * *******************************************************************************
 * $Author: 高洛峰 (skygao@lampbrother.net) $                                    *
 * $Date: 2011-07-18 10:00:00 $                                                  * 
 * ******************************************************************************/
	class Page {
		private $total;    //数据表中总记录数
		private $listRows; //每页显示行数
		private $limit;    //SQL语句使用limit从名
		private $uri;      //url地址
		private $pageNum;  //页数
		private $page;
		//在分页信息中显示内容，可以自己设置
		private $config=array('head'=>"条记录", "prev"=>"上一页", "next"=>"下一页", "first"=>"首页", "last"=>"末页");
		private $listNum=5; //默认分页列表显示的个数

		/**
		 * 构造方法，可以设置分页类的属性
		 * @param	int	$total		计算分页的总记录数
		 * @param	int	$listRows	可选的，默认每页需要显示的记录数
		 * @param	string	$pa		可选的，为向目标页面传递参数
		 * @param 	bool	$ord		可选的，默认值为true, 如果为true默认页为第一页，false则为最后一页
		 */
		public function __construct($total, $listRows=25, $pa="", $ord=true){
			$this->total=$total;
			$this->listRows=$listRows;
			$this->uri=$this->getUri($pa);
			$this->pageNum=ceil($this->total/$this->listRows);
			if(!empty($_GET["page"])) {
				$page=$_GET["page"];
			}else{
				if($ord)
					$page=1;
				else
					$page=$this->pageNum;
			}

			if($total > 0) {
				if(preg_match('/\D/', $page) ){
					$this->page=1;
				}else{
					$this->page=$page;
				}
			}else{
				$this->page=0;
			}
			
			
			$this->limit=$this->setLimit();
		}

		/**
		 * 用于设置显示分页的信息，可以连贯操作
		 * @param	string	$param	是数组config的下标
		 * @param	string	$value	用于设置config下标对应的元素值
		 * @return	object		返回本对象自己$this
		 */
		function set($param, $value){
			if(array_key_exists($param, $this->config)){
				$this->config[$param]=$value;
			}
			return $this;
		}

		private function setLimit(){
			if($this->page > 0)
				return ($this->page-1)*$this->listRows.", {$this->listRows}";
			else
				return 0;
		}

		private function getUri($pa){
			if($pa=="")
				return "?";
			else
				return $pa."&";
		}

		function __get($args){
			if($args=="limit" || $args=="page")
				return $this->$args;
			else
				return null;
		}

		private function start(){
			if($this->total==0)
				return 0;
			else
				return ($this->page-1)*$this->listRows+1;
		}

		private function end(){
			return min($this->page*$this->listRows,$this->total);
		}

		private function firstprev(){
			if($this->page > 1) {
				$str="<li><a href='{$this->uri}page=1'>{$this->config["first"]}</a></li>";
				$str.="<li><a href='{$this->uri}page=".($this->page-1)."'>{$this->config["prev"]}</a></li>";
				return $str;
			}else{
				$str="<li class='disabled' ><span>{$this->config["first"]}</span></li>";
				return $str;
			}

		}
		
		/*----------------------------------------------------------*/
		private function firstprevsj(){
			if($this->page > 1) {
				$str.="<li class='previous'><a href='{$this->uri}page=".($this->page-1)."'>{$this->config["prev"]}</a></li>";
				return $str;
			}else{
				$str.="<li class='previous disabled'><span>{$this->config["prev"]}</li>";
				return $str;
			}
		}
		
		private function nextlastsj(){
			if($this->page != $this->pageNum) {
				$str.="<li class='next'><a href='{$this->uri}page=".($this->page+1)."'>{$this->config["next"]}</a></li>";
				return $str;
			}else{
				$str.="<li class='next disabled' ><span>{$this->config["next"]}</span></li>";
				return $str;
			}

		}
		/*-----------------------------------------------------------*/
		
		
		private function pageList(){
		
			$inum=floor($this->listNum/2);
			
			for($i=$inum; $i>=1; $i--){
				$page=$this->page-$i;

				if($page>=1)
					$linkPage.="<li><a href='{$this->uri}page={$page}'>{$page}</a></li>";
			}

			if($this->pageNum > 1)
				$linkPage.="<li class='active' ><span>{$this->page}</span></li>";
			

			for($i=1; $i<=$inum; $i++){
				$page=$this->page+$i;
				if($page<=$this->pageNum)
					$linkPage.="<li><a href='{$this->uri}page={$page}'>{$page}</a></li>";
				else
					break;
			}
			
			return $linkPage;
		}

		private function nextlast(){
			if($this->page != $this->pageNum) {
				$str="<li><a href='{$this->uri}page=".($this->page+1)."'>{$this->config["next"]}</a></li>";
				$str.="<li><a href='{$this->uri}page=".($this->pageNum)."'>{$this->config["last"]}</a></li>";
				return $str;
			}else{
				$str.="<li class='disabled' ><span>{$this->config["last"]}</span></li>";
				return $str;
			}

		}

		private function goPage(){
    			if($this->pageNum > 1) {
				return '&nbsp;<input style="width:20px;height:17px !important;height:18px;border:1px solid #CCCCCC;" type="text" onkeydown="javascript:if(event.keyCode==13){var page=(this.value>'.$this->pageNum.')?'.$this->pageNum.':this.value;location=\''.$this->uri.'page/\'+page+\'\'}" value="'.$this->page.'"><input style="cursor:pointer;width:25px;height:18px;border:1px solid #CCCCCC;" type="button" value="GO" onclick="javascript:var page=(this.previousSibling.value>'.$this->pageNum.')?'.$this->pageNum.':this.previousSibling.value;location=\''.$this->uri.'page/\'+page+\'\'">&nbsp;';
			}
		}

		private function disnum(){
			if($this->total > 0){
				return $this->end()-$this->start()+1;
			}else{
				return 0;
			}
		}
		/**
		 * 按指定的格式输出分页
		 * @param	int	为0-7的数字，每个数字作为一个参数，可以自定义输出分页结构和调整结构的顺序
		 * @return	string	分页信息内容
		 */
		function fpage(){
			$arr=func_get_args();

			$html[0]="共 {$this->total} {$this->config["head"]}&nbsp;";
			$html[1]="&nbsp;本页 ".$this->disnum()." 条&nbsp;";
			$html[2]="&nbsp;本页从 {$this->start()}-{$this->end()} 条&nbsp;";
			$html[3]="&nbsp;{$this->page}/{$this->pageNum}页&nbsp;";
			$html[4]=$this->firstprev();
			$html[5]=$this->pageList();
			$html[6]=$this->nextlast();
			$html[7]=$this->goPage();

			$fpage='<div>';
			if(count($arr) < 1)
				//$arr=array(0,1,2,3,4,5,6);
				$arr=array(0,1,2,3);

			for($i=0; $i<count($arr); $i++)
				$fpage.=$html[$arr[$i]];
		
			$fpage.='</div>';
			return $fpage;
		}
		
		/*电脑分页*/
		function pcfenye(){
			$arr=func_get_args();
			$html[4]=$this->firstprev();
			$html[5]=$this->pageList();
			$html[6]=$this->nextlast();
			$fpage='<ul class="pagination" style="margin:0px">';
			
			if(count($arr) < 1){
				$arr=array(4,5,6);
			}
			
			for($i=0; $i<count($arr); $i++){
				$fpage.=$html[$arr[$i]];
			}
			
			$fpage.='</ul>';
			return $fpage;
			
		}
		
		//手机分页
		function shoujifenye(){
			$arr=func_get_args();
			$html[4]=$this->firstprevsj();
			$html[6]=$this->nextlastsj();
			
			$fpage='<ul class="pager" style="margin:0px">';
			
			if(count($arr) < 1){
				$arr=array(4,6);
			}
			
			for($i=0; $i<count($arr); $i++){
				$fpage.=$html[$arr[$i]];
			}
			
			$fpage.='</ul>';
			return $fpage;
		}
		
	}
