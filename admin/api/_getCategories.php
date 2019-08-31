<?php 
require_once "../../function.php";
//1.连接数据库
$conn=connect();
//2.sql语句
$sql="SELECT * FROM categories";
//3.执行sql
$result=query($conn,$sql);



//4.输出结果
$response=["code"=>0,"msg"=>"操作失败"];
if($result){
    $response["code"]=1;
    $response["msg"]="操作成功";
    $response["data"]=$result;
}
header("content-type:application/json;charset=utf-8");
echo  json_encode($response);



?>