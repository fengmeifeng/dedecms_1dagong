<?php if (!defined('THINK_PATH')) exit();?>
<script type="text/javascript">


Ext.onReady(function() {  
	
	
	Ext.define('BusinessList', {
        extend: 'Ext.data.Model',
        fields: [
            'name', 'status', 'dateline', 'remark'
        ],
        idProperty: 'id'
    });
	
	var store = Ext.create('Ext.data.Store', {
        pageSize: <?php echo (C("WEBPAGE")); ?>,
        model: 'BusinessList',
        remoteSort: true,
        proxy: {
            type: 'ajax',
            url: "<?php echo U('Collect/Bis/businessList',array('isData' => 1));?>",
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
    	return '<img src="'+resourcesUrl+'pencil.png" class="app-edit" title="编辑" onclick="Collect.showWindow(\'<?php echo U("Collect/Bis/editBusiness");?>?id='+record.raw.id+'\',\'编辑业务分类\',400,230)">';
    }  
    
    
    
    // create the Grid, see Ext.
    var grid = Ext.create('Ext.grid.Panel', {
    	id:'businesslist',
        store: store,
        columnLines: true,
        columns: [
            {
                text:'类别名称',
                width:'25%',
                cls:'grid-td-height',
                sortable:false, 
                dataIndex:'name'
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
                text:'添加时间', 
                width:'20%', 
                cls:'grid-td-height',
                dataIndex:'dateline'
            },
            {
                text: '描述', 
                width: '40%', 
                cls:'grid-td-height',
                dataIndex: 'remark'
            },
            {
                text: '', 
                width:'5%',
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
        renderTo: 'business-list',
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
        	"->",{
                text:'新建类别',
                iconCls:'Add',
                listeners:{
                	click:function() {
                		Collect.showWindow("<?php echo U('Collect/Bis/addBusiness');?>","新建业务分类",400,230);
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
                		
                		Collect.confirmWindow("<?php echo U('Collect/Bis/delBusiness');?>",{"ids[]":ids});
                	}
                }
            }]
        }]
    });
    
    store.loadPage(1);
});
</script>
<div id="business-list"></div>