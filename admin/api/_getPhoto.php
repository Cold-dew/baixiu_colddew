<?php 

include "../../function.php";
$email=$_POST["email"];

//链接数据库
$conn=connect();
//sql语句
$sql="SELECT * FROM users where email='{$email}'  AND `status` ='activated'";
$postArr=query($conn,$sql);
// print_r($postArr);
$response=["code"=>0,"msg"=>"登录失败"];
if($postArr){
    $response["code"]=1;
    $response["msg"]="登陆成功";
    session_start();
    $_SESSION["isLogin"]=1;
    $_SESSION["userId"]=$postArr[0]['id'];
    $response["avatar"]=$postArr[0]["avatar"];
}

header('content-type:application/json;charset=utf-8');
echo json_encode($response);

?>