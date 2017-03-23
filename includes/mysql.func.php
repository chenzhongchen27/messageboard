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

// define('DB_HOST', 'localhost');
// define('DB_USERNAME', 'root');
// define('DB_PASSWORD','');
// define('DB_NAME', 'msgboard');
define('DB_HOST', 'qdm210673477.my3w.com');
define('DB_USERNAME', 'qdm210673477');
define('DB_PASSWORD','12345678');
define('DB_NAME', 'qdm210673477_db');


function _mysql_query($_sql){
    global $_link;
    if($_result=mysqli_query($_link,$_sql)){
        return $_result;
    }else{
        exit('查询出错');
    }
}

function _mysql_query_fetch($_sql){
    global $_link;
    if($_result=mysqli_query($_link,$_sql)){
        return mysqli_fetch_array($_result, MYSQL_ASSOC);
    }else{
       exit('查询出错');
    }
     
}

// function _mysql_setdb(){
//     if(!mysqli_select_db($_link, DB_NAME)){
//         exit('找不到指定的数据库');
//     }
// }


function _mysql_close($_link){
    if(!mysqli_close($_link)){
        exit('关闭异常');
    }
}

/**
 * _mysql_connect()  连接数据库，并选择数据库，并设定字符集为utf8.
 * @return boolean
 */

function _mysql_query_before(){
    global $_link;
    $_link=mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
    if(!$_link){
        exit("数据库连接出错：错误代码，".mysqli_connect_errno().'；错误详细信息,'.mysqli_connect_error());
    }else {
//         return true;慎用return!!
    }
    if(!mysqli_set_charset($_link, 'utf8')){
        exit("字符集设置错误");
    }else{
//         $_charset=mysqli_character_set_name($_link);
//         _alert_back('默认字符集为：'.$_charset);
    }
    if(!mysqli_query($_link,'SET NAMES UTF8')){
        exit('字符集错误');
    }
  
//     function _set_names() {
//         if (!mysql_query('SET NAMES UTF8')) {
//             exit('字符集错误');
//         }
//     }

    //     if($_result=mysqli_query($_link, 'SELECT DATABASE()')){
    //         $_row=mysqli_fetch_row($_result);
    //         print_r($_row);
    //     }
}



?>