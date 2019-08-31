<?php 
require_once "../../function.php";
$id=$_POST["id"];
$conn=connect();
//准备sql
$sql="DELETE FROM categories WHERE id = '{$id}'";
$result=mysqli_query($conn,$sql);
$res=["code"=>0,"msg"=>"删除失败"];
if($result){
    $res["code"]=1;
    $res["msg"]="删除失败";
}
header("content-type:application/json");
echo json_encode($res);


?>