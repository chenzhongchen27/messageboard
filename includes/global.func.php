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
 * 弹出窗口并返回
 * @param unknown $_string
 */
function _alert_back($_string){
    echo "<script type='text/javascript'>alert('$_string');history.back()</script>";
    exit();
}

/**
 * 弹出窗口并重定向
 * @param unknown $_string
 */
function _alert_location($_string,$_url){
    echo "<script type='text/javascript'>alert('$_string');location.href='$_url'</script>";
    exit();
}

/**
 *_sha1_uniqid() 生成唯一标识符
 */
function _sha1_uniqid(){
    return _mysql_string(sha1(uniqid(rand(),true)));
}

/**
 * _mysql_string($string) 对表单提交的数据进行处理
 * @param unknown $string
 * @return unknown
 */
function _mysql_string($string){
    if(!GPC){
        if(is_array($string)){
            foreach ($string as $_key => $_value){
                $string[$_key]= _mysql_string($_value);
            }
        }else{
            $string=mysql_real_escape_string($string);
        }
    }else {
        return $string;
    }
    
}

/**
 * 
 */
 function _mysql_unstring($_string){
     $_value=is_array($_string)?
                array_map('stripslashes_deep', $_string):
                stripcslashes($_string);
     return $_value;
 }



?>