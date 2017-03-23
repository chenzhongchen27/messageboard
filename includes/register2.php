<?php
/**
 * 留言板 Version1.0
 * ================================================
 * Start 2016-4
 * Web: http://www.firstfly.cn/message
 * ================================================
 * Author: Firstfly
 * Date: 2016年4月28日
*/
session_start();




require dirname(__FILE__).'/includes/common.inc.php';
require dirname(__FILE__).'/includes/check.func.php';
require dirname(__FILE__).'/includes/fixed.inc.php';

if(isset($_GET['action'])&&$_GET['action']=='query'){
     _mysql_query_before();
     $_sql="SELECT * FROM user WHERE username='{$_POST['username']}'";//user，即数据表不能用引号包裹
     $_result=_mysql_query($_sql);    
     if(!!mysqli_fetch_array($_result)){
         echo true;//该用户名存在，不能用该用户名注册，则返回false
     }else{
         echo false;//用户名不存在，可以注册，则返回true
     };
     exit();
}

if(isset($_GET['action']) && $_GET['action']=='register'){

    $_clean=array();
    $_clean['uniqid']=$_POST['uniqid'];
    $_clean['username']=_check_username($_POST['username']);
    $_clean['password']=_check_password($_POST['password']);
    $_clean['password2']=_check_password($_POST['password2']);
    $_clean['email']=_check_email($_POST['email']);
    $_clean['sex']=$_POST['sex']; //0为男，1代表女
    if($_clean['password']!==$_clean['password2']){
        _alert_back('两次输入的密码不一样，请重新输入！');
        exit();
    }else{
        $_clean['password']=sha1($_clean['password']);
        $_clean['password2']=null;
    }
    if(_username_ifEqual($_POST['username'])){
       _alert_back("用户名已存在，不能注册！");
       exit();
    }
    $_clean['email']=_mysql_string($_clean['email']);
   
    _mysql_query_before();
    //$_sql="SELECT username FROM user";
    //$_sql_insert="INSERT INTO user(username) VALUES('艾玛')";
    $_sql="INSERT INTO user(        uniqid,
                                    username,
                                    password,
                                    email,
                                    sex,
                                    reg_time,
                                    last_time,
                                    last_ip
                                    )
                     VALUES(
                                    '{$_clean['uniqid']}',
                                    '{$_clean['username']}',
                                    '{$_clean['password']}',
                                    '{$_clean['email']}',
                                    '{$_clean['sex']}',
                                     now(),
                                     now(),
                                    '{$_SERVER['REMOTE_ADDR']}'
                           )";
  // global $_link;
    mysqli_query($_link, $_sql);
  //  echo '影响的行数'.mysqli_affected_rows($_link);
    if(mysqli_affected_rows($_link)==1){
        _mysql_close($_link);
        include './includes/login.func.php';
        _set_cookies($_clean['username'], $_clean['uniqid'],0);
        _alert_location("注册成功","./index.php");
    }else{
        _alert_back("注册失败，请重新注册");
    }
    //print_r($_clean);
   // exit('注册成功');
}else{
    $_SESSION['uniqid']=$_uniqid=sha1(uniqid(rand(),true));
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/common.css">
	<link rel="stylesheet" type="text/css" href="css/register2.css">
	<title>留言板注册页面</title>
</head>
<body>
<?php 
 require dirname(__FILE__).'/includes/header.inc.php';
?> 
<div id='main'>
	<h3>用户注册页面</h3>
	<form name="userreg" id="userreg" action="register2.php?action=register" method="post">
	 <input type="hidden" name="uniqid" value="<?php echo $_uniqid ?>">
		<div class="regline clearfix">
			<div class="regtitle">用户名</div>
			<div class="regimpt">*</div>
			<div class="regbox">
				<input class="regipt" type="text" name="username" value="" placeholder="请输入用户名"/>
				<div id="usernameexist"></div>
			</div>
			<div class="regtip">由1-10位字母、数字、汉字组成</div>
		</div>
		<div class="regline clearfix">
			<div class="regtitle">密码</div>
			<div class="regimpt">*</div>
			<div class="regbox">
				<input class="regipt"  type="password" name="password" value="" placeholder="请输入6-30位密码" />
				<div class="border"></div>
			</div>
			<div class="regtip">密码由6-16位字母、数字、下划线组成，必须包含字母、数字，不能以下划线开头</div>
		</div>
		<div class="regline clearfix">
			<div class="regtitle">密码确认</div>
			<div class="regimpt">*</div>
			<div class="regbox">
				<input class="regipt" type="password" name="password2" placeholder="请再输入一遍密码" value="" />
			</div>
			<div class="regtip"></div>
		</div>
		<div class="regline clearfix">
			<div class="regtitle">Email</div>
			<div class="regimpt"></div>
			<div class="regbox">
				<input class="regipt" type="text" name="email" placeholder="请输入您的Email地址" value="" />
			</div>
			<div class="regtip">请输入正确email，有留言时将通过email通知您</div>
		</div>
		<div class="regline clearfix">
			<div class="regtitle">性别</div>
			<div class="regimpt"></div>
			<div class="regbox">
				<label for="man">男</label>
				<input name="sex" id="man" type="radio" value="0" checked="checked" />
				<label for="woman">女</label>
				<input name="sex" id="woman" type="radio" value="1" />
			</div>
			<div class="regtip"></div>
		</div>
		<div id="msgtip"></div>
		<div class="regline clearfix">
			<div class="regtitle">&nbsp;</div>
			<div class="regimpt"></div>
			<div class="regbox">
				<input id="subbutton" type="submit" value="立即注册">
				&nbsp;&nbsp;&nbsp;
			</div>
			<div class="regtip"></div>
		</div>
	</form>

</div>
<?php 
    require dirname(__FILE__).'/includes/footer.inc.php';
?>
<script type="text/javascript" src="js/EventUtil.js"></script>
<script type="text/javascript" src="js/register2.js"></script>
</body>
</html>