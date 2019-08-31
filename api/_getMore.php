<?php 

require "../function.php";
//获取前台数据
$id=$_POST['id'];
$page=$_POST['page'];
$pageSize=$_POST['pageSize'];
$offset=($page-1)*$pageSize;
//读取数据库
$conn=connect();
$sql="SELECT p.id,p.title,p.created,p.content,p.views,p.likes,p.feature,c.`name`,u.nickname,
# 根据文章id到comments表格中查找对应的评论数量
  (SELECT count(id) FROM comments WHERE post_id = p.id) as commentsCount
   FROM posts p
   # 联表查询
  LEFT JOIN categories c on c.id = p.category_id
  LEFT JOIN users u on u.id = p.user_id
  # 筛选一下不展示的分类
  WHERE p.category_id = {$id}
  # 倒序排列

  # 限定数量
LIMIT {$offset},{$pageSize}";
$postArr=query($conn,$sql);
$sql_num="SELECT count(*) as num FROM  posts WHERE category_id = {$id}";
$count=query($conn,$sql_num);
$num=$count[0]['num'];
$total=ceil($num/$pageSize);



$response=["code"=>0,"msg"=>"操作失败"];
if($postArr){
    $response["code"]=1;
    $response["msg"]="成功";
    $response['data']=$postArr;
    $response['total']=$total;
    
};
header("content-type:application/json;charset=utf-8");
echo json_encode($response);



?>