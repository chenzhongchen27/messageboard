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

require dirname(__FILE__).'/includes/common.inc.php';
require dirname(__FILE__).'/includes/mysql.func.php';
if(!isset($_COOKIE['username'])){
    _alert_location("请先登录","./login.php");
}

if(isset($_GET['action'])&&$_GET['action']=='write'){
    $_clean[]=array();
    $_clean['to']=$_POST['to'];
    $_clean['title']=$_POST['title'];
    $_clean['content']=$_POST['content'];
    
    _mysql_query_before();
    $_sql="INSERT INTO message(     tg_type,
                                    tg_from,
                                    tg_to,
                                    tg_date,
                                    tg_title,
                                    tg_content
        ) VALUES(                   '0',
                                    '{$_COOKIE['username']}',
                                    '{$_clean['to']}',
                                     now(),
                                    '{$_clean['title']}',
                                    '{$_clean['content']}'
        )";
    _mysql_query($_sql);
    _mysql_close($_link);
    _alert_location("发送成功", "./message.php?people={$_GET['people']}");
}

_mysql_query_before();
if(!isset($_GET['people'])){
    _alert_back("交互对象不明！");
}else{
    $_sqlf="SELECT id,tg_title,tg_content,tg_from,tg_to FROM message WHERE tg_from='{$_COOKIE['username']}' AND tg_to='{$_GET['people']}' AND tg_type=0 ORDER BY tg_date DESC";
    $_sqlt="SELECT id,tg_title,tg_content,tg_from,tg_to FROM message WHERE tg_from='{$_GET['people']}' AND tg_to='{$_COOKIE['username']}' AND tg_type=0 ORDER BY tg_date DESC";
    $_sqlp="SELECT username FROM user WHERE username<>'{$_COOKIE['username']}'";
}
$_resultf = _mysql_query($_sqlf);
$_resultt = _mysql_query($_sqlt);
$_resultp = _mysql_query($_sqlp);


//exit('打印测试');

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/common.css">
	<link rel="stylesheet" type="text/css" href="css/message.css">
	<title>留言板</title>
</head>
<body>
<?php 
 require dirname(__FILE__).'/includes/header.inc.php';
?>  
	<div id="main" class="clearfix">
		<div class="menu">
			<h5>联系人</h5>
			<ul>	
			<?php while(!!$_row=mysqli_fetch_array($_resultp, MYSQL_ASSOC)){?>

				<li><a <?php if($_GET['people']==$_row['username']) echo "style='font-weight:bold'"; ?> href="./message.php?people=<?php echo $_row['username']?>">联系人：<?php echo $_row['username']?></a></li>
			<?php } ?>
			</ul>
		</div>
		<div class="content">
			<div id="newmsg">
				<form method="post" action="./message.php?people=<?php echo $_GET['people']?>&action=write">
					<input type="hidden" name="to" value="<?php echo isset($_GET['people'])?$_GET['people']:'nobody' ?>">
					<div class="inputbox">
						<label>主题：</label>
						<input name="title" type="text" placeholder="请输入主题">
					</div>
					<div class="inputbox">
						<label for="content">内容：</label>
						<textarea id="content" cols="80" rows="3" name="content" placeholder='给<?php echo $_GET['people']?>的信息'></textarea>
					</div>
					<input class="subm" type="submit" value="发送新信息">
			</form>
			</div>
			
<!-- 			<div class="msg">
				<div class="msgt">
					<span class="del">删除</span><span class="unfold">展开</span>
					<h5>主题<span class="unread">未读</span></h5>
				</div>
				<div class="msgc">
					<ul class="clearfix">
						<li><span class="me">我</span>：晚上一块去吃饭吧！</li>
						<li><span class="he">他:</span><span class="right">晚上一块去吃饭吧！</span></li>
						<li><span class="me">我</span>：晚上一块去吃饭吧！</li>
						<li><span class="he">他:</span><span class="right">晚上一块去吃饭吧！</span></li>
					</ul>
				</div>
			</div> -->
	         <h3 class='centertitle'>我给<?php echo $_GET['people']?>的信息</h3>
			<?php 
			while(!!$_row = mysqli_fetch_array($_resultf,MYSQL_ASSOC)){ 
			?>
<!-- 			<div class='msgempty'>没有查询到信息</div> -->

			<div class="msg">
				<div class="msgt">
					<span class="del disable">删除</span><span class="unfold disable">展开</span>
					<h5>主题：<small><?php echo $_row['tg_title']?></small><span class="unread"> </span></h5>
				</div>
				<div class="msgc"><?php echo $_row['tg_content']?> </div>
			</div>
			<?php } ?>
			<h3 class="centertitle"><?php echo $_GET['people']?>给我的信息</h3>

<!-- 			  <div class="msgempty">没有查询到信息</div> -->
            
		<?php while(!!$_row = mysqli_fetch_array($_resultt,MYSQL_ASSOC)){ ?>
			<div class="msg">
				<div class="msgt">
					<span class="del disable">删除</span><span class="unfold disable">展开</span>
					<h5>主题：<small><?php echo $_row['tg_title']?></small><span class="unread">未读</span></h5>
				</div>
				<div class="msgc"> 首条信息预览： <?php echo $_row['tg_content']?> </div>
			</div>
		<?php } ?>
<!-- 			<div class="msg">
				<div class="msgt">
					<span class="del">删除</span><span class="unfold">展开</span>
					<h5>主题<span class="unread">未读</span></h5>
				</div>
				<div class="msgc">具体内容</div>
			</div> -->
		</div>
	</div>
<?php 
    require dirname(__FILE__).'/includes/footer.inc.php';
?>
</body>
</html>
