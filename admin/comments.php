<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <!-- <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.php"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="login.php"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav> -->
    <?php include "public/_navbar.php" ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
        <ul class="pagination pagination-sm pull-right">
          <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li>
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
     
        </tbody>
      </table>
    </div>
  </div>
<?php $currentPage="comments" ?>
  <?php include_once "public/_aside.php"; ?>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script src="../static/assets/vendors/art-template/template-web.js"></script>
  <script src="../static/assets/vendors/twbs-pagination/jquery.twbsPagination.min.js"></script>
  <script type="text/template" id="getComm">
  {{each $data  v i }}
    <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>{{v.author}}</td>
            <td style="width:500px;">{{v.content}} </td>
            <td> {{v.title}}</td>
            <td>{{v.created}} </td>
            <td>
            {{if v.status=='held'}}
            待审核
            {{else if v.status=='approved'}}
            准许
            {{else if v.status=='rejected'}}
            拒绝
            {{else if v.status=='trashed'}}
            回收站
            {{/if}}
            </td>
            <td class="text-center">
              <a href="post-add.php" class="btn btn-warning btn-xs">驳回</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
  {{/each}}
  </script>
  <script>
  $(function(){
    var currentPage=1;
    var pageSize=10;
    var pageCount;
    getComments();
    function getComments(){
      $.ajax({
      type: "post",
      url: "api/_getComments.php",
      data: {
        currentPage:currentPage,
        pageSize:pageSize,
      },
      dataType: "json",
      success: function (res) {
        if(res.code==1){
          var html=template("getComm",res.data);
          $("tbody").html(html);
          pageCount=res.count;
         
          $('.pagination').twbsPagination({
            first: '首页',
        prev: '上一页',
        next: '下一页',
        last: '尾页',
        totalPages: pageCount,
        visiblePages: 7,
        onPageClick: function (event, page) {
        currentPage=page;
              getComments();
        }
        });
          
        }
      }
    })
    }


  })
    </script>
</body>
</html>
