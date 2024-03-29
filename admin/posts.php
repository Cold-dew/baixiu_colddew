<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.php"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="login.php"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select name="" id="category" class="form-control input-sm">
            <option value="all">所有分类</option>
            
          </select>
		  
          <select name="" id="status" class="form-control input-sm">
            <option value="all">所有状态</option>
            <option value="drafted">草稿</option>
            <option value="published">已发布</option>
			<option value="trashed">已删除</option>
          </select>
		  <input id="select" class="btn btn-default btn-sm" type="button" value="筛选">
          <!-- <button id="select" class="btn btn-default btn-sm">筛选</button> -->
        </form>
        <ul class="pagination pagination-sm pull-right">
          <!-- <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li> -->
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
    
        </tbody>
      </table>
    </div>
  </div>

  <!-- <div class="aside">
    <div class="profile">
      <img class="avatar" src="../static/uploads/avatar.jpg">
      <h3 class="name">布头儿</h3>
    </div>
    <ul class="nav">
      <li>
        <a href="index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <li class="active">
        <a href="#menu-posts" data-toggle="collapse">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse in">
          <li class="active"><a href="posts.php">所有文章</a></li>
          <li><a href="post-add.php">写文章</a></li>
          <li><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <li>
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li>
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <li>
        <a href="#menu-settings" class="collapsed" data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse">
          <li><a href="nav-menus.php">导航菜单</a></li>
          <li><a href="slides.php">图片轮播</a></li>
          <li><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div> -->
  <?php $currentPage="posts" ?>
  <?php include_once "public/_aside.php"; ?>
  <!-- <script type="text/template" id="add">
  
  {{each data as value index}}
        <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>{{value.title}} </td>
            <td>{{value.nickname}}</td>
            <td>{{value.name}}</td>
            <td class="text-center">{{value.created}}</td>
            <td class="text-center"> {{obj[value.status]}}</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
  {{/each}}
  </script> -->
  <script type="text/template" id="getdata">
  {{each data as value index}}
  <option value="{{value.id}} ">{{value.name}} </option>
  {{/each}}
  </script>
  <script src="../static/assets/vendors/art-template/template.js"></script>

  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>
    //动态生成分页结构
	var currentPage=1; //当前页
	//总页数=Math.cell(文章总条数/每页显示条数)

    var pageCount=10; //总页数
	var pageSize=20; //每页显示条数
	

	function getPage(){
	var start=currentPage-2;
    if(start<=1){
	  start=1;
	 
    }
	var end =start+4;
    if(end>pageCount||currentPage==pageCount){
      start=end-4;
      end=pageCount;
	}


    
    var html="";
    if(currentPage!=1){
html+='<li class="item" data-page="'+(currentPage-1)+'"><a href="javascript:;">上一页</a></li>';
}
for (var i = start; i <= end; i++) {
  if(currentPage==i){
  html+='<li class="item active" data-page="'+i+'"><a href="javascript:;">'+i+'</a></li>';
  }else{
    html+='<li class="item" data-page="'+i+'"><a href="javascript:;">'+i+'</a></li>';
  } 
}

if(currentPage!=pageCount){

html+='<li class="item" data-page="'+(currentPage+1)+'"><a href="javascript:;">下一页</a></li>';
}
	$('.pagination').html(html);

	
	}
	

  $(function(){
    var obj={
                drafted:"草稿",
                published:"已发布",
                trashed:"作废"
			  };
			  
		//生成html结构
    function getPostsList(data){
		//先清空
		$('tbody').empty();
      $.each(data,function (index, value) {
              var html=`<tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>`+value.title+` </td>
            <td>`+value.nickname+`</td>
            <td>`+value.name+`</td>
            <td class="text-center">`+value.created+`</td>
            <td class="text-center"> `+obj[value.status]+`</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>`;
            
          $(html).appendTo('tbody');
          })
	}
	

    //初始渲染页面
    $.ajax({
        type: "post",
        url: "api/_getPosts.php",
		data: {
			currentPage:currentPage,
			pageSize:pageSize,
			status:$('#status').val(),
			id:$('#category').val()
		},
        dataType: "json",
        success: function (res) {
          // console.log(res);

          if (res["code"] == 1) {
			pageCount=res['pageCount'];
			getPage();
			getPostsList(res["data"]);
			
          // $("tbody").html(html);
        }
        }
      });

	  //点击分页按钮item 实现数据切换
	  $(".pagination").on("click", ".item",function () {
		currentPage=parseInt($(this).attr("data-page"));
		// console.log(currentPage);
		$.ajax({
			type: "post",
			url: "api/_getPosts.php",
			data: {
				currentPage:currentPage,
			pageSize:pageSize,
			status:$('#status').val(),
			id:$('#category').val()
			},
			dataType: "json",
			success: function (res) {
				if(res.code==1){
					pageCount=res.pageCount
					getPage();
					getPostsList(res["data"]);
					
				}
			}
		});
		
	  });



	  //获取所有分类
	  
      $.ajax({
        type: "post",
        url: "api/_getCategories.php",
    
        dataType: "json",
        success: function (response) {
          if (response["code"] == 1) {
            var html = template("getdata", response);
          $(html).appendTo("#category");
          }
          
        }
      });

	  //点击筛选按钮
	  $("#select").on("click", function () {
		  var status= $("#status").val();
		  var id =$("#category").val();

		//发送ajax请求
		$.ajax({
			type: "post",
			url: "api/_getPosts.php",
			data: {
				currentPage:currentPage,
				pageSize:pageSize,
				status:status,
				id:id,
			},
			dataType: "json",
			success: function (res) {
				var data=res.data;
				if(res.code==1){
					pageCount=res.pageCount;
					console.log(pageCount);
					
					currentPage=1;
					getPostsList(data)
					getPage();
          }
			}
		});
	  });



  })

  </script>
  <script>NProgress.done()</script>
</body>
</html>
