<?php 
include_once 'config.php';
    // function checklogin(){
    //     session_start();
    //     if(!isset($_SESSION["isLogin"])||$_SESSION["isLogin"]!=1){
    //         header("Location:login.php");
    //     }
    // };
    function checkLogin(){
        session_start();
        if(!isset($_SESSION['isLogin']) || $_SESSION['isLogin']!=1){
          header("Location:login.php");
        }
       }


    //链接数据库
    function connect(){
        $conn=mysqli_connect(DB_HOST,DB_USER, DB_PASS,DB_NAME);
        return $conn;
    };
    //查询语句
    function query($conn,$sql){
        $result=mysqli_query($conn, $sql);
        return fetch( $result);
    };
    //转换结果为二维数组
    function fetch($result){
        $arr=[];
        while ($row = mysqli_fetch_assoc($result)) {
        $arr[]=$row;
    };
    return $arr;
    };

    

?>