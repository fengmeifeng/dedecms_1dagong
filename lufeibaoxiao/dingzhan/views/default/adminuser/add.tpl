<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="<{$public}>/css/common.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<{$public}>/js/jquery.js"></script>
<title>�鿴����Ա</title>
<style>
table th{
	font-size: 12px;
	font-weight : 500;
}
</style>
</head>

<body style="background-color:#E0F0FE">
<div class="admin_main_nr_dbox">

 <div class="pagetit">
	<div class="ptit"> ��ӹ���Ȩ�� </div>
  <div class="clear"></div>
</div>

<div class="toptip">
<h2>���</h2>
</div>
<br />
<div class="pagetit">
<form action="<{$url}>/add" method="post">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="list" class="link_bk">
  <tr>
    <th scope="row" width="120" align="right">������&nbsp;</th>
    <td>
	  <select name="dq" >
		<{section loop=$dq name="ls"}>
		<option value="<{$dq[ls].s_districtname}>"><{$dq[ls].s_districtname}></option>
		<{/section}>
	  </select>
	</td>
  </tr>
  <tr>
	<th align="right">���������ˣ�&nbsp;</th>
	<td><input type="text" name="dqname" /></td>
  </tr>
  <tr>
	<th align="right">Ȩ�޵����룺&nbsp;</th>
	<td><input type="password" name="mima" /></td>
  </tr>
  <tr>
	<th align="right">��֤Ȩ�޵����룺&nbsp;</th>
	<td><input type="password" name="cfmima" /></td>
  </tr>
</table>
<br/>
<input type="submit" value="�ύ" class="admin_submit" />
</form>
</div>
<!--����-->
</div>
<div class="footer link_lan">
Powered by <a href="http://www.74cms.com" target="_blank"><span style="color:#009900">74</span><span style="color: #FF3300">CMS</span></a> 3.3.20130614
</div>
<div class="admin_frameset" >
  <div class="open_frame" title="ȫ��" id="open_frame"></div>
  <div class="close_frame" title="��ԭ����" id="close_frame"></div>
</div>
</body>
</html>