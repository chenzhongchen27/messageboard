<?php
/**
 * 留言板 Version1.0
 * ================================================
 * Start 2016-4
 * Web: http://www.firstfly.cn/message
 * ================================================
 * Author: Firstfly
 * Date: 2016年4月27日
*/
define('FEATURE','index');
require dirname(__FILE__).'/includes/common.inc.php';
require dirname(__FILE__).'/includes/mysql.func.php';

if(!isset($_COOKIE['username'])){
    _alert_location("请先进行注册或登录","./register2.php");
}

_mysql_query_before();
$_sqlt="SELECT id,tg_title,tg_content,tg_from,tg_to FROM message WHERE tg_to='{$_COOKIE['username']}' AND tg_type=0 ORDER BY tg_date DESC";
$_sqlp="SELECT username FROM user WHERE username<>'{$_COOKIE['username']}'";
$_resultt = _mysql_query($_sqlt);
$_resultp = _mysql_query($_sqlp);

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/common.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">

	<title>首页</title>
</head>
<body>
<?php 
 require dirname(__FILE__).'/includes/header.inc.php';
?>  
	<div id="main" class="clearfix">
		<div class="menu">
			<h5>已注册用户</h5>
			<ul>	
			     <?php while(!!$_row=mysqli_fetch_array($_resultp, MYSQL_ASSOC)){?>
				<li><a href="./message.php?people=<?php echo $_row['username']?>">用户：<?php echo $_row['username']?></a></li>
			     <?php } ?>
			</ul>
		</div>
		<div id="content" class="content">
			<h3 class="centertitle">我收到的信息</h3>
            <!-- <div class="msgempty">没有查询到信息</div> -->     
		      <?php while(!!$_row = mysqli_fetch_array($_resultt,MYSQL_ASSOC)){ ?>
			<div class="msg">
				<div class="msgt">
					<a class="del" href="message-unfold.php?action=del&msgid=<?php echo $_row['id']?>" >删除</a><a href="message-unfold.php?action=unfold&msgid= <?php echo $_row['id']?>" class="unfold" id="msg-<?php echo $_row['id']?>">展开</a><span class="from-people">【发件人：<?php echo $_row['tg_from']?>】</span>
					<h5>主题：<small><?php echo $_row['tg_title']?></small><span class="unread"><!-- 未读 --></span></h5>
				</div>
				<ul class="msgc">
				  <li><?php echo $_row['tg_from'].'：'.$_row['tg_content']?></li> 
				</ul>
			</div>
		      <?php } ?>
		</div>
	</div>
<?php 
    require dirname(__FILE__).'/includes/footer.inc.php';
?>
	<script type="text/javascript" src="js/EventUtil.js"></script>
<script type="text/javascript" src="js/index.js"></script>
</body>
</html>
