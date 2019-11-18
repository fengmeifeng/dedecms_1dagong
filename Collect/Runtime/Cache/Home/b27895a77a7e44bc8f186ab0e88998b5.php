<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">
Ext.require(['Ext.data.*']);

Ext.onReady(function() {    
	
	var formPanel = Ext.create('Ext.form.Panel', {
        //frame: true,
        //title: 'Form Fields',
        border:0,
        width: '100%',
        height:'100%',
        bodyPadding: 10,
		
        fieldDefaults: {
            labelAlign: 'left',
            labelWidth: 60,
            msgTarget: 'side',
            anchor: '100%',
            blankText:'此项必须填写'
        },
		
        dockedItems:[{
        	xtype:'toolbar',
        	dock: 'top',
        	items: [{
                text:'关闭',
                iconCls:'Bulletcross',
                listeners:{
                	click:function() {
                		Collect.closeWindow(0);
                	}
                }
            }, '-', {
                text:'保存后关闭',
                iconCls:'Layoutedit',
                listeners:{
                	click:function() {
                		Collect.submitForm(this,"<?php echo U('Home/Group/edit');?>");
                	}
                }
            }]
        }],
        items: [{
            xtype: 'hiddenfield',
            name: 'id',
            value: "<?php echo ($info["id"]); ?>"
        },{
            xtype: 'textfield',
            name: 'name',
            fieldLabel: '用户组名',
            allowBlank:false,
            layout: 'anchor',
            value:'<?php echo ($info["name"]); ?>',
            defaults: {
                anchor: '50%'
            }
        },{
            xtype: 'radiogroup',
            fieldLabel: '状态',
            columns:1,
            items:[
            	{boxLabel:"开启",name:"status",inputValue:1<?php if(($info["status"]) == "1"): ?>,checked:true<?php endif; ?>},
            	{boxLabel:"关闭",name:"status",inputValue:2<?php if(($info["status"]) == "2"): ?>,checked:true<?php endif; ?>}
            ]
        } ,{
            xtype: 'textareafield',
            name: 'remark',
            value:'<?php echo ($info["remark"]); ?>',
            fieldLabel: '描述'
        }]
    });

    formPanel.render('group-edit');
});
</script>
<div id="group-edit"></div>