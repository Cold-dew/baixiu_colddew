<?php 
include "../../function.php";
$id=$_POST["dataId"];
$name=$_POST["name"];
$slug=$_POST["slug"];
$classname=$_POST["classname"];
//连接数据库
$conn=connect();
//sql语句
$sql="UPDATE categories SET slug='{$slug}', name='{$name}', classname='{$classname}' where id='{$id}'";

//执行sql
$result=mysqli_query($conn,$sql);
//输出
$response=["code"=>0,"msg"=>"执行失败"];
if($result){
    $response["code"]=1;
    $response["msg"]="成功";
}
header("content-type:application/json;charset=utf-8");
echo  json_encode($response);





?>