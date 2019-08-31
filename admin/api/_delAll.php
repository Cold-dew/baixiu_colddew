<?php 
include_once "../../function.php";
$ids=$_POST["ids"];
$str=implode(",",$ids);
// print_r($str);
$conn=connect();
//准备sql语句
$sql="DELETE FROM categories WHERE id in ({$str})";
//执行sql
$result=mysqli_query($conn,$sql);
$res=["code"=>0,"msg"=>"删除失败"];
if($result){
    $res["code"]=1;
    $res["msg"]="删除成功";
}
header("content-type:application/json");
echo json_encode($res);

?>