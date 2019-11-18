<?php if (!defined('THINK_PATH')) exit();?>
<script type="text/javascript">


Ext.onReady(function() {  
	
	var combo = Ext.create('Ext.data.Store',{
		fields:['id','role'],
		data:[
			{"id":"1","role":"管理员"},
			{"id":"2","role":"管理员111"}
		]
	});
	
	Ext.define('UserList', {
        extend: 'Ext.data.Model',
        fields: [
            'username', 'role', 'status', 'lastlogintime', 'lastloginip','remark'
        ],
        idProperty: 'id'
    });
	
	var store = Ext.create('Ext.data.Store', {
        pageSize: <?php echo (C("WEBPAGE")); ?>,
        model: 'UserList',
        remoteSort: true,
        proxy: {
            type: 'ajax',
            url: "<?php echo U('Home/User/userList',array('isData' => 1));?>",
            reader: {
                root: 'data',
                totalProperty: 'total'
            },
            // sends single sort as multi parameter
            simpleSortMode: true
        },
        sorters: [{
            property: 'lastpost',
            direction: 'DESC'
        }]
    });
	
	var selModel = Ext.create('Ext.selection.CheckboxModel', {
        listeners: {
            selectionchange: function(sm, selections) {
                grid.down('#removeButton').setDisabled(selections.length == 0);
            }
        }
    });


    function handel(value, cellmeta, record, rowIndex, columnIndex, store) {
    	//console.log(record);
    	return '<img src="'+resourcesUrl+'pencil.png" class="app-edit" title="编辑" onclick="Collect.showWindow(\'<?php echo U("Home/User/edit");?>?id='+record.raw.id+'\',\'编辑用户\',400,280)">';
    }  
    
    
    
    // create the Grid, see Ext.
    var grid = Ext.create('Ext.grid.Panel', {
    	id:'userlist',
        store: store,
        columnLines: true,
        columns: [
            {
                text:'用户名',
                width:'10%',
                cls:'grid-td-height',
                sortable:false, 
                dataIndex:'username'
            },
            {
                text:'角色', 
                width:'10%', 
                cls:'grid-td-height',
                sortable:false, 
                dataIndex:'role'
            },
            {
                text:'状态', 
                width:'5%', 
                sortable:true, 
                cls:'grid-td-height',
                dataIndex:'status',
                renderer:change
            },
            {
                text:'最后登录时间', 
                width:'18%', 
                cls:'grid-td-height',
                dataIndex:'lastlogintime'
            },
            {
                text: '最后登录ip', 
                width: '18%', 
                cls:'grid-td-height',
                dataIndex: 'lastloginip'
            },
            {
                text: '描述', 
                width: '30%', 
                cls:'grid-td-height',
                dataIndex: 'remark'
            },
            {
                text: '', 
                width:'6%',
                cls:'grid-td-height',
                dataIndex: 'handel',
                renderer:handel
            }
        ],
        bbar: Ext.create('Ext.PagingToolbar', {
            store: store,
            displayInfo: true,
            displayMsg: '当前显示 {0} - {1} of {2}',
            emptyMsg: "没有数据"
        }),
        height: '100%',
        width: '100%',
        renderTo: 'user-grid',
        viewConfig: {
            stripeRows: true
        },
        selModel: selModel,
        dockedItems:[{
        	xtype:'toolbar',
        	padding:'3 10 3 0',
        	items: [{
                iconCls:'Arrowrefresh',
                margins:'0 0 0 3',
                text:'重新载入',
                listeners:{
                	click:function() {
                		store.load();
                	}
                }
        	},
        	'用户名称：',{
        		xtype:'textfield',
        		width:150,
        		id:'keyword'
        	},'用户角色：',{
        		xtype:'combobox',
        		store:combo,
            	id:"role",
            	displayField:"role",
            	valueField:"id",
            	editable:false,
            	emptyText:"请选择角色",
            	width:100
        	} ,{
        		text:'搜索',
                iconCls:'Bulletmagnify',
                margins:'0 0 0 3',
                listeners:{
                	click:function() {
                		var query = {};
                		query.keyword = Ext.getCmp("keyword").getValue();
                		query.role = Ext.getCmp("role").getValue();
                		
                		Collect.searchGrid("userlist",query);
                	}
                }
        	},"->",{
                text:'增加用户',
                iconCls:'Add',
                listeners:{
                	click:function() {
                		Collect.showWindow("<?php echo U('Home/User/add');?>"," 增加用户",400,280);
                	}
                }
            }, '-',{
            	itemId:'removeButton',
                text:'删除',
                iconCls:'Delete',
                disabled:true,
                listeners:{
                	click:function() {
                		var s = grid.getSelectionModel().getSelection();
                		if(s.length == 0) return false;
                		
                		var ids = [];
                		for(var i=0;i<s.length;i++) {
                			ids.push(s[i].raw.id)
                		}
                		
                		Collect.confirmWindow("<?php echo U('Home/User/del');?>",{"ids[]":ids});
                	}
                }
            }]
        }]
    });
    
    store.loadPage(1);
});
</script>
<div id="user-grid"></div>