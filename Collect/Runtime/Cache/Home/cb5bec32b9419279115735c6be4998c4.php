<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<title><?php echo (C("APPNAME")); ?></title>
<link rel="stylesheet" type="text/css" href="/Collect/Public/Extjs/resources/css/ext-all.css" />
<link rel="stylesheet" type="text/css" href="/Collect/Public/Extjs/resources/css/icon.css" />
<link rel="stylesheet" type="text/css" href="/Collect/Public/App/Css/main.css" />
<script type="text/javascript" src="/Collect/Public/Extjs/ext-all.js"></script>

<script type="text/javascript" src="/Collect/Public/App/Js/common.js"></script>
<script type="text/javascript">
	var resourcesUrl = "/Collect/Public/Extjs/resources/icons/";
    Ext.require(['*']);
	
	
    var store = Ext.create('Ext.data.TreeStore', {
    	proxy: {
	        type: 'ajax',
	        url: "<?php echo U('Home/Index/getNavs');?>"
    	},
    	root: {
            text: 'Ext JS',
            id: 'src',
            expanded: true
        }
        
    });

    var tab = Ext.create('Ext.tab.Panel', {
        region: 'center', 
        deferredRender: false,
        activeTab: 0,
        margins: '2 5 5 0',
        bodyPadding:8,
        items: [{
            contentEl: 'center',
            title: '后台主页',
            closable: false,
            autoScroll: true,
            iconCls:'House',
            loader:{
				url:"<?php echo U('Home/Index/main');?>",
				loadMask:true,
				contentType:'html'
            },
            listeners: {
                activate: function(t) {
                    t.loader.load();
                }
            }
        }]
    });
    
    Ext.onReady(function() {

        var viewport = Ext.create('Ext.Viewport', {
            id: 'border-index',
            layout: 'border',
            items: [
            Ext.create('Ext.Component', {
                region: 'north',
                id:'header-panel',
                height: 32
                
            }),Ext.create('Ext.Panel',{
            	region: 'north',
                id:'nav-panel',
                height: 28, 
                title: '',
                //border:0,
                margins:'0 5 0 5',
                items:[
                	Ext.create('Ext.toolbar.Toolbar',{
                    	width:'100%',
                    	border:0,
                    	
						items:["->",{
							text:'帮助',
							iconCls: 'Help',
							listeners: {
								click:function() {
									Ext.Msg.alert('帮助提示', '有疑问请邮件联系yimiao@iflytek.com');
								}
							}
						},{
							text:'修改密码',
							iconCls: 'Useredit'
						},{
							text:'退出',
							iconCls: 'User',
							listeners: {
								click:function() {
									Ext.MessageBox.confirm('退出提示', '确定退出？', function(action) {
										if(action == "yes") {
											location.href = "<?php echo U('Home/Login/logout');?>";
										}
									});
								}
							}
						}]
                   	})
                ]
            }), {
                region: 'west',
                stateId: 'navigation-panel',
                id: 'west-panel', 
                title: '<?php echo (C("APPNAME")); ?>',
                split: true,
                width: 200,
                minWidth: 175,
                maxWidth: 400,
                collapsible: true,
                animCollapse: true,
                margin: '2 0 5 5',
                layout: 'fit',
                items: [
                    {
	                    xtype:'treepanel',
	                    store: store,
	                    border:0,
	                    useArrows:true,
	                    rootVisible:false,
	                    padding:'3',
	                    listeners:{
                    		itemclick:function(view, record, item, index, e, eOpts) {
                				
                				if(record.raw.leaf == "true") {
                					if(!Ext.getCmp(record.raw.id)) {
	                					tab.add({
	                    					id:record.raw.id,
											title:record.raw.text,
											closable:true,
											loader:{
												url:record.raw.url,
												contentType:'html',
												loadMask:true,
												scripts:true
											},
											listeners: {
								                activate: function(t) {
								                    t.loader.load();
								                }
								            }
	                    				});
                					}
                					
                					tab.setActiveTab(record.raw.id);
                    			}
								
                			}
	                    }
                    }
                ]
            },tab]
        });
        
        
    });
    </script>
</head>
<body>
    <!-- use class="x-hide-display" to prevent a brief flicker of the content -->
    <div id="header">
    	<h1><?php echo (C("APPLOGONAME")); ?></h1>
    </div>
    
    <div id="nav"></div>

    <div id="west" class="x-hide-display"></div>
    <div id="center" class="x-hide-display"></div>
    </div>
</body>
</html>