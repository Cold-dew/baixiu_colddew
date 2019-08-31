<?php 

include_once "../../function.php";
$name=$_POST["name"];
$slug=$_POST["slug"];
$classname=$_POST["classname"];
//连接数据库
$connect=connect();
//sql语句
$countSql="SELECT count(*) AS count FROM categories WHERE `name`='{$name}'";
$countResult=query($connect,$countSql);
$count=$countResult[0]["count"];//数据库中是否存在的条数
$response=["code"=>1,"msg"=>"操作失败"];
if($count>0){
    //则数据库中存在
 $response["msg"]="已存在,不能重复添加";
 return;
}else{
     //准备新的sql语句
     $addSql="INSERT INTO categories VALUES(null,'{$slug}','{$name}','{$classname}')";
     $addResult= mysqli_query($connect,$addSql);
     if($addResult){
        $response["code"]=1;
        $response["msg"]="添加成功";
     }
}
header("content-type:application/json;charset=utf-8");
echo  json_encode($response);

?>