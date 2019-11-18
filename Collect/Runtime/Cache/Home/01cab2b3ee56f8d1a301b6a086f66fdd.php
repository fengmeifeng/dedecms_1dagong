<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<title><?php echo (C("APPNAME")); ?>登录页</title>
<link rel="stylesheet" type="text/css" href="/Collect/Public/Extjs/resources/css/ext-all.css" />
<link rel="stylesheet" type="text/css" href="/Collect/Public/Extjs/resources/css/icon.css" />
<link rel="stylesheet" type="text/css" href="/Collect/Public/App/Css/main.css" />

<script type="text/javascript" src="/Collect/Public/Extjs/ext-all.js"></script>
<script type="text/javascript" src="/Collect/Public/App/Js/common.js"></script>
<script>
Ext.onReady(function() {
	
	var login = Ext.create('Ext.form.Panel', {
        //url:'save-form.php',
        frame:true,
        title: '用户登录',
        region:'center',
        bodyStyle:'padding:5px 5px 0',
        width:350,
        height:130,
        fieldDefaults: {
            msgTarget: 'side',
            labelWidth: 75
        },
        defaultType: 'textfield',
        defaults: {
            anchor: '100%'
        },
        style: { //formpanel位置  
            marginRight: 'auto', //
            marginLeft: 'auto',
            marginTop: '250px',
            marginBottom: 'auto'
        },
        items: [{
            fieldLabel: '用户名',
            name: 'username',
            allowBlank:false
        },{
            fieldLabel: '密码',
            name: 'password',
            inputType: 'password',
            allowBlank:false
        }],

        buttons: [{
            text: '登录',
            handler:function() {
            	var f = login.form;
            	
            	if(f.isValid()) {
        			//var ajaxData = Ext.JSON.encode(f.getValues());
        			f.submit({
        				url:"<?php echo U('Home/Login/checkLogin');?>",
        				waitMsgTarget:true,
        				waitTitle:'请稍后...',
        			    waitMsg:'正在登录...',
        			    method:'post',
        			    success:function(form, action) {
        			    	if(action.result.status == 1) {
        			    		location.href = action.result.url;
        			    	}else if(action.result.status == -1) {
        			    		Collect.createTip(action.result.msg);
        			    	}
        			    }
        			});
        		}
            }
        },{
            text: '重置内容',
            handler:function() {
            	login.form.reset();
            }
        }]
    });
	
	

	login.render("login");
});
</script>

</head>
<body style="background-color:#DFE9F6">
    <div id="login"></div>
</body>
</html>