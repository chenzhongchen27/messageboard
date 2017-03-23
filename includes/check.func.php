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

/**
 * _check_email() 对密码进行校验
 * @param unknown $_string
 */
 
include 'mysql.func.php';


function _username_ifEqual($_string){
    _mysql_query_before();
    global $_link;
    $_sql="SELECT * FROM `user` WHERE username='$_string' LIMIT 1";
    $_result=mysqli_query($_link,$_sql);
    if(mysqli_fetch_array($_result, MYSQL_ASSOC)){
        return true;
    }else{
        return false;
    }
}

function _check_email($_string){
    // 密码必须由6-16位字母、数字、下划线组成，必须包含字母、数字，不能以下划线开头
    $_pattern='/^([0-9A-Za-z\-_\.]+)@([0-9a-z]+\.[a-z]{2,3}(\.[a-z]{2})?)$/';
    if(!preg_match($_pattern, $_string)&&!$_string==''){
        _alert_back("Email不符合规范，请重新输入");
        exit();
    }else{
        return $_string;
    }
}

/**
 * _check_password() 对密码进行校验
 * @param unknown $_string
 */
function _check_password($_string){
    // 密码必须由6-16位字母、数字、下划线组成，必须包含字母、数字，不能以下划线开头
    $_pattern='/^(?![_])(?=.*[a-zA-Z])(?=.*\d)\w{6,16}/';
   // echo ('匹配结果:'.preg_match($_pattern, $_string));
    if(!preg_match($_pattern, $_string)){
        _alert_back("密码不符合规范，请重新输入");
        exit();
    }else{
        return $_string;
    }
}

/**
 * _check_username() 对注册的用户名进行校验
 * @param unknown $_string
 */
function _check_username($_string){
  //包含汉字、字母、数字，且为1-10位
    $_pattern='/^[\x{4e00}-\x{9fa5}A-Za-z0-9]{1,10}$/u';
    if(!preg_match($_pattern, $_string)){
        _alert_back("用户名不符合规范");
        exit();
    }else{
        return $_string;
    }
}

?>