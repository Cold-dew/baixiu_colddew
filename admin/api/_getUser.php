<?php 
include "../../function.php";
session_start();
$userId=$_SESSION["userId"];
//连接数据库
$conn=connect();
//sql语句
$sql="select * FROM users WHERE id={$userId}";
//执行sql语句
$postArr=query($conn,$sql);
$res=["code"=>0,"msg"=>"执行错误"];
if($postArr){
    $res["code"]=1;
    $res["msg"]="执行成功";
    $res["avatar"]=$postArr[0]["avatar"];
    $res["nickname"]=$postArr[0]["nickname"];

}
header("content-type:application/json;charset=utf-8");
echo json_encode($res);





?>