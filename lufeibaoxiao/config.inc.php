<?php
	define("DEBUG", 0);							//��������ģʽ 1 ���� 0 �ر�
	define("DRIVER","pdo");						//���ݿ����������ϵͳ֧��pdo(Ĭ��)��mysqli����
	//define("DSN", "mysql:host=localhost;dbname=brophp"); //���ʹ��PDO����ʹ�ã���ʹ����Ĭ������MySQL
	define("HOST", "192.168.3.246");				//���ݿ�����
	define("USER", "zjobsshujuku121");                     //���ݿ��û���
	define("PASS", "yaogongzuo123*()");                          //���ݿ�����
	define("DBNAME","yaogongzuo");			 				//���ݿ���
	define("TABPREFIX", "bb_");								//���ݱ�ǰ׺
	define("CSTART", 0);                                  //���濪�� 1������0Ϊ�ر�
	define("CTIME", 60*60*24*7);                          //����ʱ��
	define("TPLPREFIX", "tpl");                           //ģ���ļ��ĺ�׺��
	define("TPLSTYLE", "default");                        //Ĭ��ģ���ŵ�Ŀ¼

	//$memServers = array("localhost", 11211);	     //ʹ��memcache������
	/*
	����ж�̨memcache����������ʹ�ö�ά����
	$memServers = array(
			array("www.lampbrother.net", '11211'),
			array("www.brophp.com", '11211'),
			...
		);
	*/