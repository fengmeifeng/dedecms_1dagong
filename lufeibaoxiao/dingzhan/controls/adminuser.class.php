<?php
	class Adminuser {
		//Ȩ���û��б�
		function index(){
			$adminuser=D("vip_adminpassword");
			$data=$adminuser->select();
			$this->assign("data",$data);
			$this->display();
		}

		//��ӹ�����ԱȨ�޽���
		function adminuseradd(){
			$dq=D("qs_subsite")->field("s_id,s_districtname")->select();
			$this->assign("dq",$dq);
			$this->display(add);
		}

		//�������
		function add(){
			if(!empty($_POST)){
				if($_POST['mima']==$_POST['cfmima']){
					$_POST['mima']=MD5($_POST['mima']);
					$_POST['quanxian']="1";
					$id=D("vip_adminpassword")->insert();		
					if(!empty($id)){
						$this->success("�ɹ�!", 2, "adminuser/index");
					}else{
						$this->error("ʧ��!",2,"adminuser/adminuseradd");
					}
				}else{
					$this->error("Ȩ�������������벻���,����������",2,"adminuser/adminuseradd");
				}
			}
		}

		//�޸Ľ���
		function mod(){
			if(!empty($_GET['id'])){
				$data=D("vip_adminpassword")->where($_GET['id'])->select();
				$this->assign("data",$data[0]);
				$this->display(mod);
			}
		}

		//�޸�����
		function updata(){
			if(!empty($_POST)){
				if($_POST['mima']==$_POST['cfmima']){
				$_POST['mima']=MD5($_POST['mima']);
				$id=D("vip_adminpassword")->update(); 
				if(!empty($id)){
						$this->success("�ɹ�!", 2, "adminuser/index");
					}else{
						$this->error("ʧ��!",2,"adminuser/adminuseradd");
					}

				}else{
					$this->error("Ȩ�������������벻���,����������",2,"adminuser/adminuseradd");
				}
			}
		}

		//ɾ������
		function del(){
			if(!empty($_GET['id'])){
				$id=$_GET['id'];
				$id=D("vip_adminpassword")->delete($id);
				if(!empty($id)){
					$this->success("ɾ���ɹ�!", 1, "adminuser/index");
				}else{
					$this->error("ɾ��ʧ��!", 1, "adminuser/index");
				}
			}
			

		}
		
		//�鿴��־
		function rz(){
			if(!empty($_POST['key'])){
				$page=new Page(D("rizhi")->total(array('sqlx'=>"%".$_POST['key']."%")), 20);
				$sql="select * from rizhi where sqlx like '%".$_POST['key']."%' ORDER BY `time` DESC LIMIT ".$page->limit;
				$data=D("rizhi")->query($sql,"select");		
			}else{
				$page=new Page(D("rizhi")->total(), 20);
				$sql="select * from rizhi ORDER BY `time` DESC LIMIT ".$page->limit;
				$data=D("rizhi")->query($sql,"select");
			}
			$this->assign("data",$data);
			$this->assign("fpage", $page->fpage());
			$this->display(rizhi);
		}
}
	