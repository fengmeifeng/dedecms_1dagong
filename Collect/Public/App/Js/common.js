/*
 * author yimiao@iflytek.com
 */

/*修正4.1.1 蒙板不消失的bug*/
Ext.define('Ext.form.SubmitFix', {
    override: 'Ext.ZIndexManager',
 
    register : function(comp) {
        var me = this,
            compAfterHide = comp.afterHide;
      
        if (comp.zIndexManager) {
            comp.zIndexManager.unregister(comp);
        }
        comp.zIndexManager = me;
 
        me.list[comp.id] = comp;
        me.zIndexStack.push(comp);
      
        // Hook into Component's afterHide processing
        comp.afterHide = function() {
            compAfterHide.apply(comp, arguments);
            me.onComponentHide(comp);
        };
    },
 
    unregister : function(comp) {
        var me = this,
            list = me.list;
      
        delete comp.zIndexManager;
        if (list && list[comp.id]) {
            delete list[comp.id];
          
            // Relinquish control of Component's afterHide processing
            delete comp.afterHide;
            Ext.Array.remove(me.zIndexStack, comp);
 
            // Destruction requires that the topmost visible floater be activated. Same as hiding.
            me._activateLast();
        }
    }
});




var Collect = (function(mod) {
	mod.timeOut = 6000;
	
	mod.showWindow = function(url,title,width,height) {
		var obj = Ext.getBody();
		obj.mask("正在加载...");
		
		var w = Ext.create('Ext.window.Window', {
			id:'window-remote',
		    title: title,
		    height: height,
		    width: width,
		    resizable:false,
		    //maximizable:true,
		    //constrain:true,
		    modal:true,
		    layout: 'fit',
		    loader:{
	    		url:url,
	    		loadMask:true,
				contentType:'html',
				scripts:true,
				autoLoad:true
	    	}
	    	//closable:false,
		}).show();
		
		obj.unmask();
	}
	
	mod.closeWindow = function(src,target) {
		var o = Ext.getCmp('window-remote');
		if(o) {
			//obj.up('form').getForm().reset();
			o.close();
			
			if(src == 1) mod.flushGrid(target);
		}
		
	};
	
	mod.flushGrid = function(target) {
		if(target != "") {
			var u = Ext.getCmp(target);
			u.store.reload();
		}
	};
	
	mod.searchGrid = function(target,query) {
		var u = Ext.getCmp(target);
		//console.log(query);
		u.store.reload();
	};
	
	mod.submitForm = function(obj,url,cb) {
		var f = obj.up("form").getForm();

		if(f.isValid()) {
			//var ajaxData = Ext.JSON.encode(f.getValues());
			f.submit({
				url:url,
				waitMsgTarget:true,
				waitTitle:'请稍后...',
			    waitMsg:'正在提交数据,请稍后...',
			    method:'post',
			    success:function(form, action) {
			    	Collect.createTip(action.result.msg);
			        if(action.result.status == 1) {
			        	mod.closeWindow(1,action.result.target);
			        	
			        }else if(action.result.status == -1) {
			        	
			        }
			    }
			});
		}
	};
	
	mod.ajaxSubmit = function(url,param) {
		Ext.Ajax.request({
		    url: url,
		    params: param,
		    method:'post',
		    timeout:mod.timeOut,
		    success: function(response){
		    	var res = Ext.JSON.decode(response.responseText);
		    	
		    	Collect.createTip(res.msg);
		    	if(res.status == 1) {
		    		if(res.close == true) {
		    			var o = Ext.getCmp('window-remote');
		    			if(o) o.close();
		    		}
		    		
		    		mod.flushGrid(res.target);
		    	}else if(res.status == -1) {
		    		
		    	}
		    },
		    type:'json'
		});
	};
	
	
	mod.confirmWindow = function(url,param) {
		Ext.MessageBox.confirm('删除提示', '确定删除这些数据？', function(action) {
			if(action == "yes") {
				mod.ajaxSubmit(url,param);
			}
		});
	};
	
	mod.confirmWindowOth = function(title,content,url,param) {
		Ext.MessageBox.confirm(title, content, function(action) {
			if(action == "yes") {
				mod.ajaxSubmit(url,param);
			}
		});
	};
	
	mod.callBackTip = null;
	
	mod.createTip = function(msg) {
		if(mod.callBackTip == null) {
			mod.callBackTip = Ext.DomHelper.insertFirst(document.body, {id:'callback-msg-div'}, true);
		}
		
		var m = Ext.DomHelper.append(mod.callBackTip, "<div class='callback-msg'>"+msg+"</div>", true);
		m.hide();
        m.slideIn('t').ghost("t", { delay: 1500, remove: true});
	};
	
	
	return mod;
})(window.Collect || {});

function change(val){
	var res = '';
	if(val == 1) {
		res = '<img src="'+resourcesUrl+'tick.png" title="开启">';
	}else if(val == 2) {
		res = '<img src="'+resourcesUrl+'bullet_cross.png" title="开启">';
	}
	
	return res;
}

function regxEnglish(str) {
	if(Ext.String.trim(str) == '') return str + "不能为空";
	
	var r = new RegExp("^([a-zA-Z])*$"); 
	if(!r.test(str)) return str + "要为英文";
	
	return true;
}

function regxChinese(str) {
	if(Ext.String.trim(str) == '') return str + "不能为空";
	
	var r = new RegExp("^([\u4E00-\uFA29]|[\uE7C7-\uE7F3])*$"); 
	if(!r.test(str)) return str + "要为中文";
	
	return true;
}
