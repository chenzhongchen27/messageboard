<?php
/**
 * 留言板 Version1.0
 * ================================================
 * Start 2016-4
 * Web: http://www.firstfly.cn/message
 * ================================================
 * Author: Firstfly
 * Date: 2016年4月29日
*/

//session_start();


require dirname(__FILE__).'/includes/common.inc.php';
require dirname(__FILE__).'/includes/login.func.php';
require dirname(__FILE__).'/includes/check.func.php';
require dirname(__FILE__).'/includes/fixed.inc.php';

if(!empty($_COOKIE['username'])&&isset($_GET['action']) && $_GET['action']=='exit'){
    _set_cookies($_COOKIE['username'], $_COOKIE['uniqid'], -1);
    _alert_location("已退出登录！", "login.php");
}
if(isset($_GET['action']) && $_GET['action']=='login'){

    $_clean=array();
    $_clean['username']=_check_username($_POST['username']);
    $_clean['password']=sha1(_check_password($_POST['password']));
    @$_clean['time']=$_POST['time']?1:0;
   
    _mysql_query_before();
    //$_sql="SELECT username FROM user";
    //$_sql_insert="INSERT INTO user(username) VALUES('艾玛')";
    $_sql="SELECT uniqid,username FROM `user` WHERE username='{$_clean['username']}' AND password='{$_clean['password']}' LIMIT 1";
  // global $_link;
    if(!!$_result=_mysql_query_fetch($_sql)){
        _set_cookies($_result['username'],$_result['uniqid'],$_clean['time']);
        _mysql_close($_link);
        header('location:'.'./index.php');
    }else{
        _alert_back("用户名或者密码不正确！");
    };
}else{
    $_uniqid=_sha1_uniqid();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/common.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<title>登录页面</title>
</head>
<body>
<?php 
 require dirname(__FILE__).'/includes/header.inc.php';
?>  
<div id='main'>
	<h3>用户登录</h3>
	<form id="userreg" action="login.php?action=login" method="post">
		<div class="regline clearfix">
			<div class="regtitle">用户名</div>
			<div class="regimpt"></div>
			<div class="regbox">
				<input class="regipt" type="text" name="username" value="" placeholder="请输入用户名"/>
			</div>
			<div class="regtip"></div>
		</div>
		<div class="regline clearfix">
			<div class="regtitle">密码</div>
			<div class="regimpt"></div>
			<div class="regbox">
				<input class="regipt"  type="password" name="password" value="" placeholder="请输入密码" />
			</div>
			<div class="regtip"></div>
		</div>
		<div class="regline clearfix">
			<div class="regtitle">*</div>
			<div class="regimpt"></div>
			<div class="regbox">
				<input name="time" id="time" type="checkbox" value="1" />
				<label for="time">十天内免登陆</label>
			</div>
			<div class="regtip"></div>
		</div>
		<div class="regline clearfix">
			<div class="regtitle">&nbsp;</div>
			<div class="regimpt"></div>
			<div class="regbox">
				<input id="submit" type="submit" value="登录">
				&nbsp;&nbsp;&nbsp;
			</div>
			<div class="regtip"></div>
		</div>
	</form>

</div>

<?php 
    require dirname(__FILE__).'/includes/footer.inc.php';
?>
</body>
</html>