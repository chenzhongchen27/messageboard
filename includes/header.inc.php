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

?>
<div id="header">
	<h1>简易交流面板</h1>
	<div class="welcome">欢迎 <?php echo isset($_COOKIE['username'])?$_COOKIE['username']:'未注册用户'?> 的光临</div>
	<ul class="menu">
		<li><a <?php if(defined('FEATURE')&&FEATURE=='index'){echo "style='font-weight:bold'";} ?> href="./index.php">首页</a></li>
		<li><a  <?php if(defined('FEATURE')&&FEATURE=='register2'){echo "style='font-weight:bold'";} ?> href="./register2.php">注册</a></li>
		<?php if (!isset($_COOKIE['username'])){?>
		<li><a  <?php if(defined('FEATURE')&&FEATURE=='login'){echo "style='font-weight:bold'";} ?> href="./login.php">登录</a></li>
		<?php }else{ ?>
		<li><a href="./login.php?action=exit">退出</a></li>
		<?php } ?>
		<li class="disable">管理</li>
	</ul>
</div>

<div id="fixed">
	<dl>
		<dt>测试用户名 & 密码</dt>
		<dd>用户1 & 123qwe</dd>
		<dd>用户5 & 123qwe</dd>
	</dl>
</div>