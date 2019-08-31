<?php 

    include "../../function.php";
    $currentPage=$_POST['currentPage'];
    $pageSize=$_POST["pageSize"];
    $offset=($currentPage-1) * $pageSize;
    //连接数据库
    $conn = connect();

    //sql语句
    $sql="SELECT c.id,c.author,c.content,c.created,c.`status`,p.title FROM comments c
    LEFT JOIN posts p ON p.id=c.post_id
    LIMIT {$offset},{$pageSize}";

    //执行sql
    $result=query($conn,$sql);
    $sqlCount="SELECT count(*) as count from comments";
    //返回结果
    $countArr=query($conn,$sqlCount);
    $count=$countArr[0]["count"];
    //分页
    $pageCount=ceil($count / $pageSize);
    $response=["code"=>0,"msg"=>"失败"];
    if($result){
        $response["code"]=1;
        $response["msg"]="成功";
        $response["data"]=$result;
        $response["count"]=$pageCount;

    }
    header("content-type:application/json");
    echo json_encode($response);

?>