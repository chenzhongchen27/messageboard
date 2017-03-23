<?php
/**
 * 留言板 Version1.0
 * ================================================
 * Start 2016-4
 * Web: http://www.firstfly.cn/message
 * ================================================
 * Author: Firstfly
 * Date: 2016年5月1日
*/
require './includes/common.inc.php';
require './includes/mysql.func.php';
$_clean=array();
if(!isset($_COOKIE['username'])){
    _alert_location("请先进行登录", "login.php");
}else{
    $_clean['username']=$_COOKIE['username'];
}
if(!isset($_GET['msgid'])){
    _alert_back('非法操作信息！');
}else{
    $_clean['msgid']=$_GET['msgid'];
}

if($_GET['action']=='add'){
    _mysql_query_before();
    $_sql="INSERT INTO message(     tg_type,
                                    tg_reid,
                                    tg_from,
                                    tg_to,
                                    tg_date,
                                    tg_title,
                                    tg_content
        ) VALUES(                   '1',
                                    '{$_clean['msgid']}',
                                    '{$_COOKIE['username']}',
                                    '{$_POST['to']}',
                                     now(),
                                    '回复消息',
                                    '{$_POST['content']}'
        )";
    $_result=_mysql_query($_sql);
    global $_link;
    if(mysqli_affected_rows($_link)!=-1){
        echo "{$_COOKIE['username']}：{$_POST['content']}";
    }else{
        echo "新增失败";
    }
    _mysql_close($_link);
}

if($_GET['action']=='fold'){
    _mysql_query_before();
    $_sql="SELECT id,tg_content,tg_from,tg_to,tg_date FROM message WHERE id='{$_clean['msgid']}' LIMIT 1";
    $_result=_mysql_query($_sql);
    if (!!$_row=mysqli_fetch_array($_result, MYSQL_ASSOC)){
        echo "<li>{$_row['tg_from']}：{$_row['tg_content']}</li>"; 
    }else{
        echo "<li>此信息已被删除！</li>";
    }
    _mysql_close($_link);
}

if($_GET['action']=='unfold'){
_mysql_query_before();
$_sql="SELECT id,tg_content,tg_from,tg_to,tg_date FROM message WHERE tg_reid='{$_clean['msgid']}' ORDER BY tg_date DESC";
$_sqlpeople="SELECT tg_from FROM message WHERE id='{$_clean['msgid']}' ";
$_result=_mysql_query($_sql);
$_resultpeople=_mysql_query($_sqlpeople);
$_rowpeople=mysqli_fetch_array($_resultpeople, MYSQL_ASSOC);
$_clean['class']='';
    while(!!$_row=mysqli_fetch_array($_result, MYSQL_ASSOC)){
        if($_clean['username']==$_row['tg_from']){$_clean['class']='he';};
        $_clean['date']=$_row['tg_date'];
        echo "<li class='{$_clean['class']}'>{$_row['tg_from']}：{$_row['tg_content']}<span class='time'>{$_clean['date']}</span></li>";
     }
     _mysql_close($_link);
     echo "
         		<li>
				  	<form method='post' action='./message-unfold.php?action=add&msgid={$_clean['msgid']}'>
				  	    <input type='hidden' name='to' value='{$_rowpeople['tg_from']}'>
				  		<textarea cols='80' rows='3' name='content' placeholder='对该主题进行回复'></textarea>
				  		<input class='subm' type='submit' value='回复'>
				  	</form>
				 </li>
         ";
}

if($_GET['action']=='del'){
    _mysql_query_before();
    $_sql="DELETE FROM message WHERE id='{$_clean['msgid']}' OR tg_reid='{$_clean['msgid']}'";
    $_result=_mysql_query($_sql);
    _mysql_close($_link);
    echo  "已删除！";
    _mysql_close($_link);
}
?>
