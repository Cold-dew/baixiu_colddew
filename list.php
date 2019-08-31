<?php 

  include_once "function.php";
  // $id=$_GET['categoryId'];
  // $conn=mysqli_connect(DB_HOST,DB_USER, DB_PASS,DB_NAME);
  // $sql="SELECT p.title,p.created,p.content,p.views,p.likes,p.feature,c.`name`,u.nickname,
  // # 根据文章id到comments表格中查找对应的评论数量
  //   (SELECT count(id) FROM comments WHERE post_id = p.id) as commentsCount
  //    FROM posts p
  //    # 联表查询
  //   LEFT JOIN categories c on c.id = p.category_id
  //   LEFT JOIN users u on u.id = p.user_id
  //   # 筛选一下不展示的分类
  //   WHERE p.category_id != {$id}
  //   # 倒序排列
  //   order BY p.created desc
  //   # 限定数量
  //   LIMIT 8";
  // $res=mysqli_query($conn, $sql);
  // $listArr=[];
  // while($row= mysqli_fetch_assoc($res)){
  // $listArr[]=$row;
  // };

  //用函数执行
$id=$_GET['id'];
//查询数据库
$conn= connect();
//创建sql语句
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
  LIMIT 8";
  //执行查询语句
  $listArr=query($conn,$sql);
// print_r($listArr);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>阿里百秀-发现生活，发现美!</title>
  <link rel="stylesheet" href="static/assets/css/style.css">
  <link rel="stylesheet" href="static/assets/vendors/font-awesome/css/font-awesome.css">
</head>
<body>
  <div class="wrapper">
    <div class="topnav">
      <ul>
        <li><a href="javascript:;"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="javascript:;"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="javascript:;"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="javascript:;"><i class="fa fa-gift"></i>美奇迹</a></li>
      </ul>
    </div>
    <?php include "public/_header.php"; ?>
   <?php include "public/_aside.php"; ?>
    <div class="content">
      <div class="panel new">
        <h3><?php echo $listArr[0]['name']  ?></h3>
        <?php
        foreach($listArr as $value){ ?>
         <div class="entry">
          <div class="head">
            <span class="sort"> <?php echo $value["name"] ?> </span>
            <a href="detail.php?postId=<?php echo $value['id'] ?>"><?php echo $value["title"] ?></a>
          </div>
          <div class="main">
            <p class="info"><?php echo $value["nickname"] ?> 发表于<?php echo $value["created"] ?> </p>
            <p class="brief"><?php echo $value["content"] ?> </p>
            <p class="extra">
              <span class="reading">阅读(<?php echo $value["views"] ?>)</span>
              <span class="comment">评论(<?php echo $value["commentsCount"] ?>)</span>
              <a href="javascript:;" class="like">
                <i class="fa fa-thumbs-up"></i>
                <span>赞(<?php echo $value["likes"] ?>)</span>
              </a>
              <a href="javascript:;" class="tags">
                分类：<span> <?php echo $value["name"] ?></span>
              </a>
            </p>
            <a href="javascript:;" class="thumb">
            <img src="static/uploads/hots_2.jpg" alt="">
              
            </a>
          </div>
        </div>
     <?php } ?>
    

           <div class="loadmore">
            <span class="btn">点击加载更多</span>
           </div>
      </div>
    </div>
    <div class="footer">
      <p>© 2019 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
  <script src="static/assets/vendors/jquery/jquery.min.js"></script>
  <script src="static/assets/vendors/art-template/template.js"></script>
  <script type="text/template" id="more">
  {{each data as value index}}
  <div class="entry">
          <div class="head">
            <span class="sort">{{value.name}}</span>
            <a href="detail.php?postId={{value.id}}">{{value.title}}</a>
          </div>
          <div class="main">
            <p class="info">{{value.nickname}} 发表于 {{value.created}}</p>
            <p class="brief">{{value.content}}</p>
            <p class="extra">
              <span class="reading">阅读({{value.views}})</span>
              <span class="comment">评论({{value.commentsCount}})</span>
              <a href="javascript:;" class="like">
                <i class="fa fa-thumbs-up"></i>
                <span>赞({{value.likes}})</span>
              </a>
              <a href="javascript:;" class="tags">
                分类：<span>{{value.name}}</span>
              </a>
            </p>
            <a href="javascript:;" class="thumb">
              <img src="static/uploads/hots_2.jpg" alt="">
            </a>
          </div>
    </div>
  {{/each}}
  </script>
  <script>
  $(function(){
    var currentNum=1;
    $(".loadmore").on("click",".btn",function(){
      currentNum++;
      var id=location.search.split("=")[1];
      // console.log(id);
      
      $.ajax({
        type: "POST",
        url: "api/_getMore.php",
        data: {
          id:id,
          page:currentNum,
          pageSize:100,
        },
        dataType: "json",
        success: function (res) {
          console.log(res);
          
          if(res.code==1){
            var html=template("more",res);
            $(".loadmore").before(html);
          }
          if(currentNum==res.total){
            $(".loadmore ").hide();
          }
        }
      })

    })
  })
  
  </script>
</body>
</html>