<?php 
include_once "../../function.php";
//获取数据
$currentPage=$_POST["currentPage"];
$pageSize=$_POST["pageSize"];
$status=$_POST["status"];
$id=$_POST["id"];
//计算偏移量
$offset=($currentPage-1) * $pageSize;
$where = " where 1=1 ";
if($status!= "all"){
    $where .=" and p.`status`= '{$status}'";
}
if($id != "all"){
    $where .=" and p.category_id = '{$id}'";
}
//连接数据库
$conn=connect();
//sql语句
$sql="SELECT p.id,p.title,u.nickname,c.`name`,p.created,p.`status` FROM posts p
LEFT JOIN users u ON u.id=p.user_id
LEFT JOIN categories c ON c.id=p.category_id " . $where . " limit {$offset},{$pageSize} ";

//执行sql
$result=query($conn,$sql);

//查询文章的总条数
$countSql="select count(*) as count from posts p " . $where;
//执行查询
$countArr=query($conn,$countSql);
$count=$countArr[0]["count"];
//分页的数量
$pageCount=ceil($count/$pageSize);

$res=["code"=>0,"msg"=>"失败"];
if($result){
    $res["code"]=1;
    $res["msg"]="成功";
    $res["data"]=$result;
    $res["pageCount"]=$pageCount;
}
header("content-type:application/json");
echo json_encode($res);



?>