<!DOCTYPE html>
<html lang="zh-cn">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Cache-Control" content="no-transform" />
	<meta http-equiv="Cache-Control" content="no-siteapp" />
	<meta name="keywords" content="打工网,手机招聘网,招工网,壹打工网" />
	<meta name="description" content="壹打工网是专业提供各大企业招聘招工信息的大型普工类网站。我们致力于为普工提供更好的工作,为企业输送更多的普工." />
	<title>壹打工网-工作让生活更精彩</title>
	<!-- head_css-->
	<link href="/files/style/css/bootstrap.css" type="text/css" rel="stylesheet" /> 

	<link href="/files/style/css/all.css" type="text/css" rel="stylesheet" />

	<script src="/files/style/js/jquery.min.js" language="JavaScript" type="text/javascript" ></script>
	<script src="/files/style/js/bootstrap.min.js" language="JavaScript" type="text/javascript" ></script>
    <script src="/files/style/js/a_modal.js" language="JavaScript" type="text/javascript" ></script>
	<script language="javascript" type="text/javascript" src="/include/login.js"></script>
	<script language="javascript" type="text/javascript">
		<!--
			
			function CheckLogin(){
			  var taget_obj = document.getElementById('headlogin');
			  myajax = new DedeAjax(taget_obj,false,false,'','','');
			  myajax.SendGet2("/home/headlogin.php");
			  DedeXHTTP = null;
			}
		-->
		<!--
			function Checkbaoming(){
				var checkbaoming= document.getElementById('checkbaoming');
				var aid= document.getElementById('aid');
				var mid= document.getElementById('mid');
				var type= document.getElementById('type');
				//alert(type.value);
				myajax = new DedeAjax(checkbaoming,false,false,'','','');
				myajax.SendGet2("/home/checkbaoming.php?aid="+aid.value+"&mid="+mid.value+"&type="+type.value);
				DedeXHTTP = null;
			}
		-->

	</script>
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media
		queries -->
		<!--[if lt IE 9]>
			<script src="/files/js/html5shiv.min.js">
			</script>
			<script src="/files/js/respond.min.js">
			</script>
		<![endif]-->
	<script src="/plus/zdgx.php" language="javascript"></script>    
	<!--head_css end -->	
</head>
<body>
<!-- head-->

<div class=" beijing">
<div class="container" >
<div class="top_sh row">

     <div class="col-xs-12 col-md-6 mp">
        <ul class="login jidns pull-left">
       	  <li class="pr_10 hotline dropwnd"><a data-trigger="modal" href="http://www.1dagong.com/ajax/number.html" data-title="Modal title">免费咨询</a></li>
          <li class="phone pr_10"><a data-trigger="modal" href="http://www.1dagong.com/ajax/qrcode.html" data-title="Modal title">手机壹打工</a></li>
        </ul>
     </div>
     
     <div class="col-xs-12 col-md-6 mp">
     	<div class="free">
        全国免费求职热线： 
        <a href="tel:400-118-5188">400-118-5188</a>
        </div>
     </div>
</div>    
</div>
</div>


<nav class="navbar navbar-default top">

  <div class="container">
    
    <div class="navbar-header col-xs-5 col-md-2">
      <a href="/" class="logo"><img src="/files/style/image/logo.png" height="90" width="190" class="img-responsive hidden-xs" />
      <img src="/files/style/image/logo.jpg" class="img-responsive visible-xs sjlogo" /></a>
    </div>
    
    
    <div  id="headlogin" class="col-md-3 logint pull-right mp">
     
        <ul class="login pull-right bcsa">
          <li class="pr_10 hogin dropwnd"><a href="/home/"  data-target="#denglu">登录</a></li>
          <li><a href="/home/p_register.php" class="#denglu">注册 </a></li>
        </ul>
		<script language="javascript" type="text/javascript">CheckLogin();</script>
    </div>
    
    
    <div class="navbar-header pull-left" >
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse col-md-7" id="bs-example-navbar-collapse-1">
	<script>
	$(document).ready(function() {
        
        //放置特效css cclassName
        var navUlliahover = "navUlliahover";
        //获取当前导航的位置
        var curl = window.location.href;
        var chost = window.location.host;
        var pageUrl = curl.substr(curl.lastIndexOf(chost) + chost.length);
        //导航栏滑动事件
        $(".navUl li a").hover(function() {
            this.className = navUlliahover;
            },
            function() {
                //当前url与导航url相匹配时，不清除特效
                if (pageUrl != $(this).attr("href")) {
                    this.className = "";
                }
            });
        //导航列表状态
        $(".navUl li a").each(function() {
            if ($(this).attr("href") == pageUrl) {
                this.className = navUlliahover;
            }
        });
    });
//-------------------------------------------------------------------------------------
	$(document).ready(function(){  
		$('.nav li a').each(function(){  
			if($($(this))[0].href==String(window.location))  
				$(this).parent().addClass('active');  
		});  
	})
	</script>
      <ul class="nav navbar-nav ">
      	<li><a href="/">首页</a></li>
        <li><a href="/plus/search.php?typeid=41&starttime=-1&areacode=-1&searchtype=-1">找工作</a></li>
        <li><a href="/gongzuo/">行业名企</a></li>
      </ul>
    
    </div><!-- /.navbar-collapse -->
    

  </div><!-- /.container-fluid -->
</nav>

<!--head end -->
        
<!-- Carousel
    ================================================== -->
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators qihuna hidden-xs">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        <li data-target="#carousel-example-generic" data-slide-to="3"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
      
            <div class="item active">
              <img src="/files/style/image/banner_da3.jpg" alt="First slide">
              <div class="container">
                <div class="carousel-caption col-md-6" style="margin-top:10px;">
                  <h1 style="line-height:48px;">找工作？222<br/>
					不！我们让工作来找你</h1>
                  <p style="font-size:18px; margin-bottom:10px;">壹打工网携手各地优质企业，带着好工作来到你家门口！<br />
                  2015年全国最大的求职盛宴——<strong>壹打工网全国巡回招聘会已经开幕！</strong><br />
                  我们诚邀你的加入！量身打造属于你的职业之路！<br />
                  安徽、苏州、上海、常熟、重庆、武汉、郑州……！ 2015，不见不散
                  ！
                  </p>
                  
                  
                  <p><a href="/zt/xunhui/" class="btn btn-primary" role="button" style="width:160px;">招聘会详情 >> </a></p>
                  <p class="fl">
                      <a href="#" class="btn btn-default" role="button" style="font-size:16px; color:#606">4月11日 上海站</a>
                      
                      <a href="#" class="btn btn-default" role="button" style="font-size:16px; color:#606">5月16日 常熟站</a>
                      <a href="#" class="btn btn-default" role="button" style="font-size:16px; color:#606">重庆站  （筹备中）</a>
                      
                   </p>
                </div>
              </div>
            </div>
            
            <div class="item">
              <img src="/files/style/image/banner_da.jpg" alt="First slide">
              <div class="container">
                <div class="carousel-caption col-md-6">
                  <h1>打造国内第一蓝领求职服务平台</h1>
                  <br />
                  <ul>
                    <li><span>专</span>：专业的求职招聘网站，最了解蓝领需求，专为蓝领服务</li>
                    <li><span>快</span>：求职快、入职快</li>
                    <li><span>优</span>：精心审核、优质企业，更有保障</li>
                    <li><span>简</span>：简约但不简单。找工作更方便</li>
                    <li><span>奖</span>："1+2事业平台"，赢奖金活动送不停</li>
                  </ul>
                </div>
              </div>
            </div>
          
            <div class="item">
              <img src="/files/style/image/banner_da2.jpg" alt="First slide">
              <div class="container">
                <div class="carousel-caption col-md-6">
                  <h1>壹打工网“1+2”事业平台</h1>
                  <p>全球行销之神—杰.亚伯拉罕<br/>专为中国蓝领设计，帮助中国普通工人实现财富梦想！</p>
                  <br />
                  <p><a href="/neijian/" class="btn btn-primary" style="width:200px;" role="button">了解“1+2”事业平台 >></a></p>
                </div>
              </div>
            </div>
            
        
        
            <div class="item">
              <img src="/files/style/image/banner_da1.jpg" alt="First slide" class="img-responsive">
              <div class="container">
                <div class="carousel-caption col-md-6">
                  <ul class="banner_xiao row">
                  <li><a href="/zt/jiyu/index.html"><img src="/file/1401/1411/1-14111916013LK.jpg" alt="致广大普通劳动者的一封" ></a></li>
<li><a href="http://www.1dagong.com/jiezhan/"><img src="/file/1401/1409/1-140Z910355ba.jpg" alt="接站" ></a></li>
<li><a href="http://www.1dagong.com/neijian/"><img src="/file/1401/1406/1-140616135019108.jpg" alt="1+2内荐行动" ></a></li>
<li><a href="http://www.1dagong.com/zhengwen/"><img src="/file/allimg/1404/1-140415123H10-L.jpg" alt="一起为梦想打工" ></a></li>
  
                  </ul>
                </div>
              </div>
            </div>
            
        
        <a class="left carousel-control visible-xs" href="#carousel-example-generic" role="button" data-slide="prev" style="z-index:1000">
          </a>
          <a class="right carousel-control visible-xs" href="#carousel-example-generic" role="button" data-slide="next" style="z-index:1000">
          </a>
          
      </div>
      <div class="row mp">
      		
<!--           <div class="erweima"><a href="#" style="height:30px; width:30px; background:#999; display:inline-block;"></a></div>
-->            
          <form class="form-signin zhuce col-md-3 col-xs-12 pull-right" role="form" method="post" action="/home/p_register.php" id="regUser">
                <div class="pull-right mren"><a type="button" href="/home/" class="btn btn-info">企业招聘服务入口</a></div>
                <input type="hidden" value="regbase" name="dopost"/>
                <input type="hidden" value="1" name="step"/>
                <input type="hidden" value="个人" name="mtype"/>
    
                <h3 class="form-signin-heading">免费报名 <span>海量职位，任你挑选</span></h3>
    
                <span class="help-block">填写您的手机号码：</span>
    
                <input type="text" class="form-control" placeholder="手机号码" required autofocus  name="shouye" maxlength="13">
                <span class="checkbox">
                 仅仅只需一步，让工作来找你。
                </span>
                <button class="btn btn-lg btn-purple btn-block" type="submit">提交</button>
                
           </form>
           
               
       
       
    </div>
</div>  
        
      
<!--By Z首页搜索开始-->       
<div class="container">
  <div class="row in_bac">
        <div class="col-xs-12 col-md-8 col-md-offset-2 mt_20" style="z-index:999;">
          <form action="/plus/search.php" method="get">
              <input type="hidden" name="typeid" value="41">
              <input type="hidden" name="starttime" value="-1">
              <div class="search row">
                  
                  <div class="left col-xs-3 col-md-1 mp" id="left1" style="position:relative;">
                    <label class="change_area" style="margin-bottom:0;">
                      <span href="javascript:;" style="font-weight:100">职位</span><b class="caret"></b>
                      <input type="hidden" name="searchtype" value="-1">
                    </label>
                    <div class="sou_down col-md-12" style="display: none;">
                      <ul>
                        <li><a rel="-1" href="javascript:;">职位</a></li>
                        <li><a rel="comtype" href="javascript:;">公司</a></li>
                      </ul>
                    </div>
                  </div>
                  
                  <input type="text" class="col-xs-6 col-md-7 text" name="q" style="color:#999" value="职位搜索 ..."  onfocus="this.value=''" onblur="if(this.value==''){this.value='职位搜索 ...'}" >
              
                  <div class="left col-xs-3 col-md-2 mp" id="left2" style="position:relative;">
                    <label class="change_area" style="margin-bottom:0;">
                      <span href="javascript:;" style="font-weight:100;">地区</span><b class="caret"></b>
                      <input type="hidden" name="areacode" value="-1">
                    </label>
                    <div class="sou_down col-md-12" style="display: none;">
                      <ul>
                        <li><a rel="0" href="javascript:;">不限</a></li>
                        <li><a rel="1" href="javascript:;">合肥</a></li>
                        <li><a rel="2" href="javascript:;">上海</a></li>
                        <li><a rel="3" href="javascript:;">重庆</a></li>
                        <li><a rel="4" href="javascript:;">江苏</a></li>
                        <li><a rel="5" href="javascript:;">湖北</a></li>
                      </ul>
                    </div>
                  </div>
                  <input class="col-xs-3 col-md-2 btn btn-yellow pdsf mp" type="submit" value="搜 索" />
              </div>
          </form>
        </div>

        <div class="col-xs-12 col-md-8 heis col-md-offset-2">热门搜索：     
            <a href="/plus/search.php?typeid=45&areacode=-1&starttime=-1&searchtype=-1">技工</a>
            <a href="/plus/search.php?typeid=53&areacode=-1&starttime=-1&searchtype=-1">销售</a>
            <a href="/plus/search.php?typeid=50&areacode=-1&starttime=-1&searchtype=-1">仓储</a>
            <a href="/plus/search.php?typeid=46&areacode=-1&starttime=-1&searchtype=-1">服务员</a>
            <a href="/plus/search.php?typeid=49&areacode=-1&starttime=-1&searchtype=-1">家政服务</a>
            <a href="/plus/search.php?typeid=51&areacode=-1&starttime=-1&searchtype=-1">汽车修理</a>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
/*$('#jingxuanku').find('li').mouseover(function(){
$('#jingxuanku').find('.licon').attr('class', 'licon hide');
$(this).find('.licon').removeClass('hide');
});*/

$('#left2 .change_area').mouseover(function(){
$('#left2 .sou_down').show();
}).mouseout(function(){
$('#left2 .sou_down').hide();
});

$('#left2 .sou_down').mouseover(function(){
$('#left2 .sou_down').show();
}).mouseout(function(){
$('#left2 .sou_down').hide();
});

$('#left2 .sou_down li a').click(function(){
$('#left2 .change_area input[name=areacode]').val($(this).attr('rel'));
$('#left2 .change_area span').text($(this).text());
$('#left2 .sou_down').hide();
});

//新加按公司名搜索js By Z
$('#left1 .change_area').mouseover(function(){
$('#left1 .sou_down').show();
}).mouseout(function(){
$('#left1 .sou_down').hide();
});

$('#left1 .sou_down').mouseover(function(){
$('#left1 .sou_down').show();
}).mouseout(function(){
$('#left1 .sou_down').hide();
});

$('#left1 .sou_down li a').click(function(){
$('#left1 .change_area input[name=searchtype]').val($(this).attr('rel'));
$('#left1 .change_area span').text($(this).text());
$('#left1 .sou_down').hide();
});
});
</script>
<!--By Z首页搜索结束-->

<div class="container">
      <div class="over toue">
          热门行业
          
      </div>
      <div class="newre row">
       <div class="col-md-4 mt_20">
          <ul>
           <h3><a href="/plus/search.php?typeid=45&starttime=-1&areacode=-1&searchtype=-1">技工</a><span><a href="/plus/search.php?typeid=45&starttime=-1&areacode=-1&searchtype=-1">更多</a></span></h3>
            
            <li><a href="/plus/search.php?typeid=55&starttime=-1&areacode=-1&searchtype=-1">综合维修工</a></li>
            
            <li><a href="/plus/search.php?typeid=68&starttime=-1&areacode=-1&searchtype=-1">化验/检验工</a></li>
            
            <li><a href="/plus/search.php?typeid=67&starttime=-1&areacode=-1&searchtype=-1">铸造/注塑/模具</a></li>
            
            <li><a href="/plus/search.php?typeid=66&starttime=-1&areacode=-1&searchtype=-1">铲车/叉车工</a></li>
            
            <li><a href="/plus/search.php?typeid=65&starttime=-1&areacode=-1&searchtype=-1">车床/磨床/铣床</a></li>
            
            <li><a href="/plus/search.php?typeid=64&starttime=-1&areacode=-1&searchtype=-1">切割/焊工</a></li>
            
            <li><a href="/plus/search.php?typeid=63&starttime=-1&areacode=-1&searchtype=-1">制冷/水暖工</a></li>
            
           
          </ul>
          
        </div><div class="col-md-4 mt_20">
          <ul>
           <h3><a href="/plus/search.php?typeid=53&starttime=-1&areacode=-1&searchtype=-1">销售/市场</a><span><a href="/plus/search.php?typeid=53&starttime=-1&areacode=-1&searchtype=-1">更多</a></span></h3>
            
            <li><a href="/plus/search.php?typeid=121&starttime=-1&areacode=-1&searchtype=-1">市场营销</a></li>
            
            <li><a href="/plus/search.php?typeid=122&starttime=-1&areacode=-1&searchtype=-1">销售代表</a></li>
            
            <li><a href="/plus/search.php?typeid=123&starttime=-1&areacode=-1&searchtype=-1">房产经纪人</a></li>
            
            <li><a href="/plus/search.php?typeid=124&starttime=-1&areacode=-1&searchtype=-1">房产经理人</a></li>
            
            <li><a href="/plus/search.php?typeid=125&starttime=-1&areacode=-1&searchtype=-1">电话销售</a></li>
            
            <li><a href="/plus/search.php?typeid=126&starttime=-1&areacode=-1&searchtype=-1">医药代表</a></li>
            
            <li><a href="/plus/search.php?typeid=127&starttime=-1&areacode=-1&searchtype=-1">其他销售职位</a></li>
            
           
          </ul>
          
        </div><div class="col-md-4 mt_20">
          <ul>
           <h3><a href="/plus/search.php?typeid=50&starttime=-1&areacode=-1&searchtype=-1">仓储/物流</a><span><a href="/plus/search.php?typeid=50&starttime=-1&areacode=-1&searchtype=-1">更多</a></span></h3>
            
            <li><a href="/plus/search.php?typeid=97&starttime=-1&areacode=-1&searchtype=-1">仓库管理员</a></li>
            
            <li><a href="/plus/search.php?typeid=98&starttime=-1&areacode=-1&searchtype=-1">快递员</a></li>
            
            <li><a href="/plus/search.php?typeid=99&starttime=-1&areacode=-1&searchtype=-1">单证员</a></li>
            
            <li><a href="/plus/search.php?typeid=100&starttime=-1&areacode=-1&searchtype=-1">装卸/搬运工</a></li>
            
            <li><a href="/plus/search.php?typeid=101&starttime=-1&areacode=-1&searchtype=-1">物流专员/助理</a></li>
            
            <li><a href="/plus/search.php?typeid=102&starttime=-1&areacode=-1&searchtype=-1">物流经理/主管</a></li>
            
           
          </ul>
          
        </div><div class="col-md-4 mt_20">
          <ul>
           <h3><a href="/plus/search.php?typeid=46&starttime=-1&areacode=-1&searchtype=-1">服务员</a><span><a href="/plus/search.php?typeid=46&starttime=-1&areacode=-1&searchtype=-1">更多</a></span></h3>
            
            <li><a href="/plus/search.php?typeid=70&starttime=-1&areacode=-1&searchtype=-1">厨师/厨师长</a></li>
            
            <li><a href="/plus/search.php?typeid=71&starttime=-1&areacode=-1&searchtype=-1">后厨</a></li>
            
            <li><a href="/plus/search.php?typeid=72&starttime=-1&areacode=-1&searchtype=-1">传菜员</a></li>
            
            <li><a href="/plus/search.php?typeid=73&starttime=-1&areacode=-1&searchtype=-1">配菜/打荷</a></li>
            
            <li><a href="/plus/search.php?typeid=74&starttime=-1&areacode=-1&searchtype=-1">洗碗工</a></li>
            
            <li><a href="/plus/search.php?typeid=75&starttime=-1&areacode=-1&searchtype=-1">面点师</a></li>
            
            <li><a href="/plus/search.php?typeid=76&starttime=-1&areacode=-1&searchtype=-1">茶艺师</a></li>
            
           
          </ul>
          
        </div><div class="col-md-4 mt_20">
          <ul>
           <h3><a href="/plus/search.php?typeid=49&starttime=-1&areacode=-1&searchtype=-1">家政服务</a><span><a href="/plus/search.php?typeid=49&starttime=-1&areacode=-1&searchtype=-1">更多</a></span></h3>
            
            <li><a href="/plus/search.php?typeid=89&starttime=-1&areacode=-1&searchtype=-1">保洁</a></li>
            
            <li><a href="/plus/search.php?typeid=90&starttime=-1&areacode=-1&searchtype=-1">保姆</a></li>
            
            <li><a href="/plus/search.php?typeid=91&starttime=-1&areacode=-1&searchtype=-1">月嫂</a></li>
            
            <li><a href="/plus/search.php?typeid=92&starttime=-1&areacode=-1&searchtype=-1">育婴师</a></li>
            
            <li><a href="/plus/search.php?typeid=93&starttime=-1&areacode=-1&searchtype=-1">洗衣工</a></li>
            
            <li><a href="/plus/search.php?typeid=94&starttime=-1&areacode=-1&searchtype=-1">钟点工</a></li>
            
            <li><a href="/plus/search.php?typeid=95&starttime=-1&areacode=-1&searchtype=-1">保育员</a></li>
            
           
          </ul>
          
        </div><div class="col-md-4 mt_20">
          <ul>
           <h3><a href="/plus/search.php?typeid=47&starttime=-1&areacode=-1&searchtype=-1">店员/营业员</a><span><a href="/plus/search.php?typeid=47&starttime=-1&areacode=-1&searchtype=-1">更多</a></span></h3>
            
            <li><a href="/plus/search.php?typeid=79&starttime=-1&areacode=-1&searchtype=-1">收银员</a></li>
            
            <li><a href="/plus/search.php?typeid=80&starttime=-1&areacode=-1&searchtype=-1">促销/导购员</a></li>
            
            <li><a href="/plus/search.php?typeid=81&starttime=-1&areacode=-1&searchtype=-1">理货员</a></li>
            
            <li><a href="/plus/search.php?typeid=82&starttime=-1&areacode=-1&searchtype=-1">防损员/内保</a></li>
            
            <li><a href="/plus/search.php?typeid=83&starttime=-1&areacode=-1&searchtype=-1">店长/卖场经理</a></li>
            
            <li><a href="/plus/search.php?typeid=84&starttime=-1&areacode=-1&searchtype=-1">招商经理/主管</a></li>
            
           
          </ul>
          
        </div>
      
      </div>
</div>


<!--111111111111111-->
<div class="container">
  <div class="over">
    <div class="col-md-2 bac hotdoor hotd">VIP企业</div>
    <div class="col-md-10 hotdoor door">行业名企，让您更放心的工作！</div>
  </div>
<!--  <ul  class="nav nav-tabs mb1" role="tablist">
    <li role="presentation" class="active"><a href='/gongzuo/'>全国招聘企业</a></li>
    
    
    <li role='presentation'><a href='/hefei/'>合肥</a></li>
    
    <li role='presentation'><a href='/wuhu/'>芜湖</a></li>
    
    <li role='presentation'><a href='/bangbu/'>蚌埠</a></li>
    
    <li role='presentation'><a href='/chongqing/'>重庆</a></li>
    
    <li role='presentation'><a href='/shanghai/'>上海</a></li>
    
    <li role='presentation'><a href='/changshu/'>常熟</a></li>
    
    <li role='presentation'><a href='/hubei/'>湖北</a></li>
    
    <li role='presentation'><a href='/suzhou/'>苏州</a></li>
    
    <li role='presentation'><a href='/wuxi/'>无锡</a></li>
    
  </ul>
-->  
  <div class="pb_20 over" style="border:1px solid #eee; border-top:none;">
    
    <div class="col-md-3 mt_20">
      <div class="bac_hui">
        <p><a href="/hefei/0325312014.html"><img src="/file/1403/1-14032515143QX.jpg" class="img-responsive" /></a></p>
        <ul>
          <li> <a target="_blank" href="/hefei/0325312014.html" class="fon">合肥洽洽食品股份有限公司</a> </li>
          <li> 月综合工资：<font color="ff6600" size="3">2500-3500元</font> </li>
          <li> 接站：提供接站服务</li>
          <li> <font color="#999">多劳多得，上不封顶</font></li>
          <li> <span class="btn btn-default ptii">732人报名</span> <a class="btn btn-yellow ptii pull-right"  target="_blank" href="/hefei/0325312014.html">去看看</a> </li>
        </ul>
      </div>
    </div>
<div class="col-md-3 mt_20">
      <div class="bac_hui">
        <p><a href="/shanghai/012Q92014.html"><img src="/file/allimg/1401/1-14012Q021510-L.jpg" class="img-responsive" /></a></p>
        <ul>
          <li> <a target="_blank" href="/shanghai/012Q92014.html" class="fon">广达上海制造城上海达丰电脑</a> </li>
          <li> 月综合工资：<font color="ff6600" size="3">3317~4220元</font> </li>
          <li> 接站：松江火车站</li>
          <li> <font color="#999">交纳社会保险</font></li>
          <li> <span class="btn btn-default ptii">1164人报名</span> <a class="btn btn-yellow ptii pull-right"  target="_blank" href="/shanghai/012Q92014.html">去看看</a> </li>
        </ul>
      </div>
    </div>
<div class="col-md-3 mt_20">
      <div class="bac_hui">
        <p><a href="/hefei/012432014.html"><img src="/file/images/1401/1-14012P922101H.jpg" class="img-responsive" /></a></p>
        <ul>
          <li> <a target="_blank" href="/hefei/012432014.html" class="fon">合肥联宝电子科技有限公司</a> </li>
          <li> 月综合工资：<font color="ff6600" size="3">2800～3800元</font> </li>
          <li> 接站：经开区寅特尼人才市场 </li>
          <li> <font color="#999">待遇丰厚</font></li>
          <li> <span class="btn btn-default ptii">736人报名</span> <a class="btn btn-yellow ptii pull-right"  target="_blank" href="/hefei/012432014.html">去看看</a> </li>
        </ul>
      </div>
    </div>
<div class="col-md-3 mt_20">
      <div class="bac_hui">
        <p><a href="/suzhou/0R53W2014.html"><img src="/file/1408/1-140R5145503914.jpg" class="img-responsive" /></a></p>
        <ul>
          <li> <a target="_blank" href="/suzhou/0R53W2014.html" class="fon">吴江三美电子有限公司</a> </li>
          <li> 月综合工资：<font color="ff6600" size="3">3300-3700元</font> </li>
          <li> 接站：</li>
          <li> <font color="#999">福利待遇丰厚，五险一金</font></li>
          <li> <span class="btn btn-default ptii">518人报名</span> <a class="btn btn-yellow ptii pull-right"  target="_blank" href="/suzhou/0R53W2014.html">去看看</a> </li>
        </ul>
      </div>
    </div>
<div class="col-md-3 mt_20">
      <div class="bac_hui">
        <p><a href="/hefei/0Q93U2014.html"><img src="/file/1401/1408/1-140Q9112RD46.jpg" class="img-responsive" /></a></p>
        <ul>
          <li> <a target="_blank" href="/hefei/0Q93U2014.html" class="fon">合肥京东方显示光源有限公司</a> </li>
          <li> 月综合工资：<font color="ff6600" size="3">2800-3800元</font> </li>
          <li> 接站：提供接站服务</li>
          <li> <font color="#999">包食宿、购五险</font></li>
          <li> <span class="btn btn-default ptii">688人报名</span> <a class="btn btn-yellow ptii pull-right"  target="_blank" href="/hefei/0Q93U2014.html">去看看</a> </li>
        </ul>
      </div>
    </div>
<div class="col-md-3 mt_20">
      <div class="bac_hui">
        <p><a href="/hubei/0206212014.html"><img src="/file/images/1402/1-140206140H4117.jpg" class="img-responsive" /></a></p>
        <ul>
          <li> <a target="_blank" href="/hubei/0206212014.html" class="fon">湖北健鼎电子有限公司</a> </li>
          <li> 月综合工资：<font color="ff6600" size="3">3200-4500元</font> </li>
          <li> 接站：火车天门南站</li>
          <li> <font color="#999">无试用期，培训机会多</font></li>
          <li> <span class="btn btn-default ptii">564人报名</span> <a class="btn btn-yellow ptii pull-right"  target="_blank" href="/hubei/0206212014.html">去看看</a> </li>
        </ul>
      </div>
    </div>
<div class="col-md-3 mt_20">
      <div class="bac_hui">
        <p><a href="/shanghai/012542014.html"><img src="/file/images/1401/1-14012P921433N.jpg" class="img-responsive" /></a></p>
        <ul>
          <li> <a target="_blank" href="/shanghai/012542014.html" class="fon">上海环维电子股份有限公司</a> </li>
          <li> 月综合工资：<font color="ff6600" size="3">3500~4000元</font> </li>
          <li> 接站：松江火车站</li>
          <li> <font color="#999">平均工作五天休息两天</font></li>
          <li> <span class="btn btn-default ptii">478人报名</span> <a class="btn btn-yellow ptii pull-right"  target="_blank" href="/shanghai/012542014.html">去看看</a> </li>
        </ul>
      </div>
    </div>
<div class="col-md-3 mt_20">
      <div class="bac_hui">
        <p><a href="/wuhu/0125162014.html"><img src="/file/images/1401/1-14012P91K41M.jpg" class="img-responsive" /></a></p>
        <ul>
          <li> <a target="_blank" href="/wuhu/0125162014.html" class="fon">芜湖雅图数字视频技术有限公司</a> </li>
          <li> 月综合工资：<font color="ff6600" size="3">2800~3400元</font> </li>
          <li> 接站：申博芜湖分公司</li>
          <li> <font color="#999">宾馆式员工宿舍</font></li>
          <li> <span class="btn btn-default ptii">278人报名</span> <a class="btn btn-yellow ptii pull-right"  target="_blank" href="/wuhu/0125162014.html">去看看</a> </li>
        </ul>
      </div>
    </div>

   
    </div>
    <div class="over"></div>
    <!--最低-->
   <!-- 工作库里-->
	<div class="row mt_30 pl_20">
    
      <div class="col-md-6 top_pa pr_0">
        <dl>
          <dt><a target="_blank" href="/plus/view.php?aid=740"><u>钣金工</u></a>[钣金工]</dt>
          <dd><span>月薪：</span> 2000-3000</dd>
          <dd><span>经验：</span>不限</dd>
          <dd><span>最低学历：</span>不限</dd>
          <dd><span>职位诱惑：</span>男，25-45岁，三年以上经验，中级以上</dd>
          <dd><span>发布日期：</span>2015-02-15</dd>
        </dl>
      </div>
      <div class="col-md-6 top_pa">
        <dl>
          <dt><a target="_blank" href="/home/index.php?uid=1&action=archives&channelid=81">合肥皖合叉车机械有限公司</a></dt>
          <dd><span>领域：</span>钣金工</dd>
          <dd><span>招聘人数：</span>5 人</dd>
          <dd><span>截至时间：</span>2015-03-24</dd>
          <ul class="mp">
          </ul>
        </dl>
      </div>
    </div>

    <!----------------------------------------------c-------------------------------------------------------------->
    
    
  </div>
</div>
<!--111111111111111-->

<div class="container">
   <div class="row mt_30 mp pb_20" style="border:1px solid #eee">
       <div class="newzui"><h4>最新招聘职位</h4><a href="/plus/search.php?typeid=41&starttime=-1&areacode=-1&searchtype=-1">查看更多</a></div>
     <!-- <div class="over"></div>
        -->

       <!-----------h---------------->
       
       <div class="pt_20 over"></div>
       <!-----------------c-------------------------->
       <div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=1031" title="" target="_blank">55555555</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=19870&action=archives&channelid=81">测试测试测试测试</a>
                    <!-- <a href="/plus/view.php?aid=1031">3000-5000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>232321人</strong>发布日期：<font color="#999">2015-05-07</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=1024" title="" target="_blank">测试发布的职位名称</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=19870&action=archives&channelid=81">测试测试测试测试</a>
                    <!-- <a href="/plus/view.php?aid=1024">3000-5000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>4人</strong>发布日期：<font color="#999">2015-04-22</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=999" title="" target="_blank">343434323</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=19870&action=archives&channelid=81">测试测试测试测试</a>
                    <!-- <a href="/plus/view.php?aid=999">5000-8000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>23人</strong>发布日期：<font color="#999">2015-04-14</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=996" title="" target="_blank">测试发布工作123</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=19864&action=archives&channelid=81">测收到收到收到收到</a>
                    <!-- <a href="/plus/view.php?aid=996">3000-5000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>5人人</strong>发布日期：<font color="#999">2015-03-16</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=994" title="" target="_blank">测试111111</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">admin</a>
                    <!-- <a href="/plus/view.php?aid=994">2000-3000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>455454人</strong>发布日期：<font color="#999">2015-03-13</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=722" title="" target="_blank">生产线员工、品质检验员</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">安徽云森物联网科</a>
                    <!-- <a href="/plus/view.php?aid=722">3000-5000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>若干人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=723" title="" target="_blank">化验/检验（全职）</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">合肥东铭机械制造</a>
                    <!-- <a href="/plus/view.php?aid=723">5000-8000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>5人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=745" title="" target="_blank">急聘电工</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">安徽黄氏和盛（集</a>
                    <!-- <a href="/plus/view.php?aid=745">5000-8000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>2 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=747" title="" target="_blank">设备管理员</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">合肥市飞荣达新材</a>
                    <!-- <a href="/plus/view.php?aid=747">面议</a> -->
                    
                </dd>
                <dd>招聘<strong>1 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=740" title="" target="_blank">钣金工</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">上海威泽尔机械设</a>
                    <!-- <a href="/plus/view.php?aid=740">2000-3000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>5 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=746" title="" target="_blank">水电工</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">合肥瑞洁物业管理</a>
                    <!-- <a href="/plus/view.php?aid=746">8000以上元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>2 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=727" title="" target="_blank">钣金、注塑模具维修师傅</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">合肥世纪精信机械</a>
                    <!-- <a href="/plus/view.php?aid=727">3000-5000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>5 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=721" title="" target="_blank">质量检验员</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">合肥长城制冷科技</a>
                    <!-- <a href="/plus/view.php?aid=721">3000-5000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>10 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=730" title="" target="_blank">数控车床工</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">合肥一航航空设备</a>
                    <!-- <a href="/plus/view.php?aid=730">5000-8000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>2人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=731" title="" target="_blank">车工 普铣工 数铣工 钳工 氩弧焊工 剪板折弯工</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">合肥开泰工贸有限</a>
                    <!-- <a href="/plus/view.php?aid=731">3000-5000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>若干 人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=737" title="" target="_blank">操作工</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">admin</a>
                    <!-- <a href="/plus/view.php?aid=737">3000-5000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>2 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=716" title="" target="_blank">维修技术员</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">安徽锦研鑫电子科</a>
                    <!-- <a href="/plus/view.php?aid=716">3000-5000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>10 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=714" title="" target="_blank">叉车司机/驻外叉车司机</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">安徽春天物流有限</a>
                    <!-- <a href="/plus/view.php?aid=714">5000-8000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>若干人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=726" title="" target="_blank">注塑操作工</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">精英模具（合肥）</a>
                    <!-- <a href="/plus/view.php?aid=726">5000-8000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>若干人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=728" title="" target="_blank">普通车床</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">安徽安凯华夏汽车</a>
                    <!-- <a href="/plus/view.php?aid=728">2000-3000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>10 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=729" title="" target="_blank">车工师傅、车床学徒工</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">安徽省瑞杰锻造有</a>
                    <!-- <a href="/plus/view.php?aid=729">3000-5000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>2 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=744" title="" target="_blank">木工</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">合肥欧雅橱柜有限</a>
                    <!-- <a href="/plus/view.php?aid=744">2000-3000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>10 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=742" title="" target="_blank">钳工</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">合肥科特精密五金</a>
                    <!-- <a href="/plus/view.php?aid=742">2000-3000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>5 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=741" title="" target="_blank">钳工</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">安徽威迈光机电科</a>
                    <!-- <a href="/plus/view.php?aid=741">3000-5000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>3 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=739" title="" target="_blank">钣金、注塑模具维修师傅</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">合肥世纪精信机械</a>
                    <!-- <a href="/plus/view.php?aid=739">3000-5000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>5 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=738" title="" target="_blank">油漆工</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">合肥永升机械有限</a>
                    <!-- <a href="/plus/view.php?aid=738">2000-3000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>5 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=736" title="" target="_blank">缝纫熟练工</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">安徽丽军针织服装</a>
                    <!-- <a href="/plus/view.php?aid=736">2000-3000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>50 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=735" title="" target="_blank">缝纫工</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">合肥杭丝时装工业</a>
                    <!-- <a href="/plus/view.php?aid=735">2000-3000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>30 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=734" title="" target="_blank">熟练缝纫工</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">旗牌王（合肥）制</a>
                    <!-- <a href="/plus/view.php?aid=734">2000-3000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>5 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=733" title="" target="_blank">电焊工</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">合肥丁桥机械厂</a>
                    <!-- <a href="/plus/view.php?aid=733">3000-5000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>若干人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=732" title="" target="_blank">焊工</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">合肥固通管路科技</a>
                    <!-- <a href="/plus/view.php?aid=732">5000-8000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>10 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>
<div class="col-md-3 mp">
       	 <div class="column sidk">
            
            <dl>
                <dt><h4><a href="/plus/view.php?aid=724" title="" target="_blank">数控师傅</a></h4></dt>
                <dd>
					
					<a href="/home/index.php?uid=1&action=archives&channelid=81">安徽福达汽车模具</a>
                    <!-- <a href="/plus/view.php?aid=724">3000-5000元/月</a> -->
                    
                </dd>
                <dd>招聘<strong>3 人人</strong>发布日期：<font color="#999">2015-02-15</font></dd>
            </dl>
            
         </div>
       </div>

		<!------------------------c-------------------------------------------------->
       
  </div>
</div>


<div class="container">
	<section id="cards" class="h2" data-view="channel_cards" data-collection_params="{&amp;quot;category&amp;quot;:&amp;quot;Featured&amp;quot;}"
	data-collection_name="channels">
		<div class="row b3">
        
        <div class="container">
            <div class="navbar-header row">
                <h4 class="tose" >
                    我们的优势
                </h4>
            </div>
		</div>
        
        
			<div class="col-sm-4">
				<div class="card" data-name="安心">
					<img src="/files/style/image/youshi1.png" class="img-responsive"  data-height="64" data-width="65">
					</img>
					<div class="count">
						安心
					</div>
					<div class="description">
						<h2>
							世界500强合作伙伴
						</h2>
						<p>
							壹打工网，世界500强企业指定招聘合作网站。在大企业工作，倍有面儿！
						</p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card" data-name="贴心">
					<img src="/files/style/image/youshi2.png" class="img-responsive"  data-height="64" data-width="65">
					<div class="count">
						贴心
					</div>
					<div class="description">
						<h2>
							全程服务
						</h2>
						<p>
							我们帮助您便捷、快速的找到适合的岗位，全程全力支持您的工作。
						</p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card" data-name="放心">
					<img src="/files/style/image/youshi3.png" class="img-responsive" data-height="64" data-width="65">
					<div class="count">
						放心
					</div>
					<div class="description">
						<h2>
							大品牌，值得信赖
						</h2>
						<p>
							壹打工网，遍布全国的服务网络。从此让你和坑爹的中介说拜拜。
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>
    
</div>    
    
    
<!-------baoming------->   
<div class="extra">
	<div class="container">
		<div class="row">
			<div class="col-xs-6 col-sm-3">
				<h5>
					用户帮助
				</h5>
				<ul class="icons-list">
					
					<li>
						<i class="icon-li fa fa-angle-double-right">
						</i>
						<a href="#">
							帐户状态
						</a>
					</li>
					<li>
						<i class="icon-li fa fa-angle-double-right">
						</i>
						<a href="#">
							密码找回与修改
						</a>
					</li>
				</ul>
			</div>
			<!-- /span3 -->
			<div class="col-xs-6 col-sm-3">
				<h5>
					关注我们
				</h5>
				<ul class="icons-list">
					<li>
						<i class="icon-li fa fa-angle-double-right">
						</i>
						<a href="/home/weixin_x.php">
							微信
						</a>
					</li>
					<li>
						<i class="icon-li fa fa-angle-double-right">
						</i>
						<a href="http://www.1dagong.com/m/index.html">
							手机客户端
						</a>
					</li>
					<li>
						<i class="icon-li fa fa-angle-double-right">
						</i>
						<a href="http://www.1dagong.com/">
							手机网页版
						</a>
					</li>
					<li>
						<i class="icon-li fa fa-angle-double-right">
						</i>
						<a href="#">
							新浪微博
						</a>
					</li>
				</ul>
			</div>
			<!-- /span3 -->
			<div class="col-xs-12 col-sm-3">
				<h5>
					壹打工网相关
				</h5>
				<ul class="icons-list">
					<li>
						<i class="icon-li fa fa-twitter">
						</i>
						<a href="#" target="_blank">
							友情链接
						</a>
					</li>
				</ul>
			</div>
			<!-- /span3 -->
			<div class="col-xs-12 col-sm-3">
				<h5>
					免费报名
				</h5>
				<p>
					仅需留下您的手机或电话，我们专业的求职顾问便会迅速为您量身定制合适的职位。
				</p>
				<div id="mc_embed_signup">
					<form class="form-signin" role="form" method="post" action="/home/p_register.php" id="regUser">
						<input type="hidden" value="regbase" name="dopost"/>
						<input type="hidden" value="1" name="step"/>
						<input type="hidden" value="个人" name="mtype"/>

						<div class="mc-field-group form-group">
							<input type="text" class="required email form-control" placeholder="手机号码" required name="shouye" id="userid" maxlength="13">
							<datalist id="userid">
								<option value="0551-12345678">
								<option value="13912345678">
								<option value="055112345678">
							</datalist>

						</div>
						
						<div class="clear">
							<button class="btn btn-primary btn-block" type="submit">免费报名</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!--------baoming------->

<!-- /footer -->
<div class="footer">
	<div class="container">
		<ul class="nav footer-nav pull-left">
			<li>
				© 2013-2015 Www.1dagong.Com 本站所有招聘信息及作品，未经书面授权不得转载！<br />
				<a href="/help/aboutus.html">关于我们</a>
			</li>
		</ul>
		<ul class="nav footer-nav pull-right">
			<li>
				最专业的求职招聘网站，致力打造人才网第一品牌！
				<i class="fa fa-heart text-primary">
				</i>
				&amp;
				<a href="http://www.1dagong.com" target="_blank">
					壹打工网.
				</a><br />
				国家工业和信息化部备案号：<a href="http://www.miibeian.gov.cn/">皖ICP备13015030号-3</a>
			</li>
		</ul>
	</div>
	<!-- /container -->
</div>
<div class="none">
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fb41da31689d0e576af45aaeafc3be8d8' type='text/javascript'%3E%3C/script%3E"));
</script>
</div>
<!-- /footer -->
</body>
</html>
