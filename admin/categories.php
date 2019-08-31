<?php 
include_once "../function.php";
checkLogin();


?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>

<body>
  <script>
    NProgress.start()
  </script>

  <div class="main">
    <?php include "public/_navbar.php" ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none">
        <strong>错误！</strong><span id="msg">发生错误</span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id="data">
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="name">类名</label>
              <input id="classname" class="form-control" name="classname" type="text" placeholder="类名">
            </div>
            <div class="form-group">
              <!-- <button class="btn btn-primary" type="submit">添加</button> -->
              <input type="button" id="btn-add" value="添加" class="btn btn-primary">
              <input type="button" style="display:none;" id="btn-edit" value="编辑完成" class="btn btn-primary">
              <input type="button" style="display:none;" id="btn-cancle" value="取消编辑" class="btn btn-primary">
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input class="checkall" type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th>类名</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
             
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php $currentPage="categories" ?>
  <?php include_once "public/_aside.php"; ?>
  <!-- //执行模板引擎 -->

  <script type="text/template" id="add">

    {{each data as value index}}
             <tr data-id="{{value.id}}">
                <td class="text-center"><input type="checkbox"></td>
                <td>{{value.name}} </td>
                <td>{{value.slug}}</td>
                <td> {{value.classname}}</td>
                <td class="text-center">
                  <a href="javascript:;"  class="btn btn-info btn-xs edit">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>
                </td>
              </tr>

  {{/each}}
  </script>
  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>
    NProgress.done()
  </script>
  <script src="../static/assets/vendors/art-template/template.js"></script>
  <script>
    $(function () {
      $.ajax({
        type: "post",
        url: "api/_getCategories.php",
        data: "data",
        dataType: "json",
        success: function (res) {
          // console.log(res);

          if (res["code"] == 1) {
            var html = template("add", res);
            $("tbody").html(html);
          }
        }
      });

      //给提交按钮btn-add注册点击事件
      $("#btn-add").on("click", function () {
        //1 收集用户信息,判断是否合法
        var name = $("#name").val();
        var slug = $("#slug").val();
        var classname = $("#classname").val();
        if (name == "") {
          $("#msg").text("输入的名称不能为空");
          $(".alert").show();
          return;
        }
        if (slug == "") {
          $("#msg").text("输入的别名不能为空");
          $(".alert").show();
          return;
        }
        if (classname == "") {
          $("#msg").text("输入的图标类不能为空");
          $(".alert").show();
          return;
        }
        var data = $("#data").serialize();
        $.ajax({
          type: "post",
          url: "api/_addCategories.php",
          data: data,
          dataType: "json",
          success: function (res) {
            if (res.code == 1) {
              var str = `<tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>` + name + ` </td>
                <td>` + slug + `</td>
                <td>` + classname + `</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>`;
              $(str).appendTo("tbody");
              $("#name").val('');
              $("#slug").val('');
              $("#classname").val('');
            }

          }
        });


      })
      var currentRow;
      //点击 编辑edit
      $("tbody").on("click", ".edit", function () {
        var dataId = $(this).parents("tr").attr("data-id");

        //获取当前被点击的tr
        currentRow=$(this).parents("tr");
        // console.log(dataId);
        $("#btn-edit").attr("data-id", dataId);

        $("#btn-add").hide();
        $("#btn-cancle").show();
        $("#btn-edit").show();
        //点击编辑获取值
        var name = $(this).parents("tr").children().eq(1).text();
        var slug = $(this).parents("tr").children().eq(2).text();
        var classname = $(this).parents("tr").children().eq(3).text();
        //将值展示在左侧
        $("#name").val(name);
        $("#slug").val(slug);
        $("#classname").val(classname);
      });


      //给编辑完成注册点击事件

      $("#btn-edit").on("click", function () {
        var dataId = $(this).attr("data-id");
        //    获取表单的数据,进行数据验证
        var name = $("#name").val();
        var slug = $("#slug").val();
        var classname = $("#classname").val();
        if (name == "") {
          $("#msg").text("输入的名称不能为空");
          $(".alert").show();
          return;
        }
        if (slug == "") {
          $("#msg").text("输入的别名不能为空");
          $(".alert").show();
          return;
        }
        if (classname == "") {
          $("#msg").text("输入的图标类不能为空");
          $(".alert").show();
          return;
        }
        $.ajax({
          type: "post",
          url: "api/_update.php",
          data:{
            dataId:dataId,
            name:name,
            slug:slug,
            classname:classname,
          },
          dataType: "json",
          success: function (res) {
            if(res.code==1){
        $("#btn-add").show();
        $("#btn-cancle").hide();
        $("#btn-edit").hide();
         //清空之前获取数据
         var name = $("#name").val();
        var slug = $("#slug").val();
        var classname = $("#classname").val();     

              
        $("#name").val("");
        $("#slug").val("");
        $("#classname").val("");
        currentRow.children().eq(1).text(name);
        currentRow.children().eq(2).text(slug);
        currentRow.children().eq(3).text(classname);
            }
          }
        });

      });
      //点击取消编辑按钮
      $("#btn-cancle").on("click", function () {
        $("#btn-add").show();
        $("#btn-cancle").hide();
        $("#btn-edit").hide();    
        $("#name").val("");
        $("#slug").val("");
        $("#classname").val("");
      });

      //点击删除按钮

      $("tbody").on("click",".del", function () {
        var row=$(this).parents("tr");
        var id=row.attr("data-id");
        $.ajax({
          type: "post",
          url: "api/_delCategories.php",
          data: {id:id},
          dataType: "json",
          success: function (res) {
            if(res.code==1){
              row.remove();
            }
          }
        });
      });

      //点击多选,删除多个
      $(".checkall").click(function() {
        // console.log($(this).prop("checked"));
        $("tbody input,.checkall").prop("checked", $(this).prop("checked"))
        if($(this).prop("checked")){
          $(".btn-sm").fadeIn();
        }else{
          $(".btn-sm").fadeOut();
        }
    });
    // 2.点击单选按钮，全部都选了，全选按钮被选择
    $("tbody").on("change","input", function () {
      // if ($("tbody input:checked").length == $("tbody input").length) {
      //       $(".checkall").prop("checked", true)
      //   } else {
      //       $(".checkall").prop("checked", false)
      //   }
      $(".checkall").prop("checked",$("tbody input:checked").length == $("tbody input").length );
      if($("tbody input:checked").length>=2){
        $(".btn-sm").fadeIn();
      }else{
        $(".btn-sm").fadeOut();
      }
    });

    //点击批量删除按钮,删除所选的那一行

    $(".btn-sm").on("click", function () {
      var ids=[];
      var cks=$("tbody input:checked");
      // console.log(cks);
      cks.each(function (index, value) { 
         var id=$(value).parents("tr").attr("data-id");
         ids.push(id);
      });
     
      

      $.ajax({
        type: "post",
        url: "api/_delAll.php",
        data: {ids:ids},
        dataType: "json",
        success: function (res) {
          if(res.code==1){
            cks.parents("tr").remove();
            $(".btn-sm").fadeOut();
          }
        }
      });


    });
    


    })
  </script>
</body>

</html>