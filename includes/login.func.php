<?php
/**
 * 留言板 Version1.0
 * ================================================
 * Start 2016-4
 * Web: http://www.firstfly.cn/message
 * ================================================
 * Author: Firstfly
 * Date: 2016年4月30日
*/


function _set_cookies($_username,$_uniqid,$_time){
    if($_time==1){
        setcookie('username',$_username,time()+10*24*60*60);
        setcookie('uniqid',$_uniqid,time()+10*24*60*60);
    }elseif($_time<0){
        setcookie('username',$_username,time()-1);
        setcookie('uniqid',$_uniqid,time()-1);
    }elseif($_time==0){
        setcookie('username',$_username);
        setcookie('uniqid',$_uniqid);
    }
}
?>