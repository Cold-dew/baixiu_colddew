<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
</head>

<body>
  <div class="login">
    <form class="login-wrap">
      <img class="avatar" src="../static/assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none">
        <span id="msg">用户名或密码错误！</span>
      </div>

      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" class="form-control" placeholder="密码">
      </div>
      <span class="btn btn-primary btn-block"">登 录</span>
    </form>
  </div>



  <script src=" ../static/assets/vendors/jquery/jquery.min.js"> </script> 
  
  <script>


        $(".btn").on("click",function(){
        var email=$("#email").val();
        var password=$("#password").val();
        var reg=/\w+[@]\w+[.]\w+/;
        // var regpwd=/^[a-zA-Z0-9_-]{6,16}$/;
        if(!reg.test(email)){
        $("#msg").text("你输入的邮箱有误,请重新输入");
        $(".alert").show();
        return;
        };
        // if(!regpwd.test(password)){
        // $("#pwd").text("你输入的密码不符合规范,请重新输入");
        // $(".wrong").show();
        // return;
        // }
        //如果油箱正确,把数据发给后台
        $.ajax({
        type: "POST",
        url: "api/_userLogin.php",
        data: {
        "email":email,
        "password":password
        },
        dataType: "json",
        success: function (response) {
        if(response["code"]==1){
        location.href="index.php";
        // header("Location:index.php");
        }else{
        $("#msg").text("输入的邮箱或密码有误,请重新输入");
        $(".alert").show();
        }
        }
        });

        });
        $("#email").on("blur",function(){
          var email=$("#email").val();
       
        var reg=/\w+[@]\w+[.]\w+/;
        // var regpwd=/^[a-zA-Z0-9_-]{6,16}$/;
        if(!reg.test(email)){
        $("#msg").text("你输入的邮箱有误,请重新输入");
        $(".alert").show();
        return;
        };
        // if(!regpwd.test(password)){
        // $("#pwd").text("你输入的密码不符合规范,请重新输入");
        // $(".wrong").show();
        // return;
        // }
        //如果油箱正确,把数据发给后台
        $.ajax({
        type: "POST",
        url: "api/_getPhoto.php",
        data: {
        "email":email,
       
        },
        dataType: "json",
        success: function (response) {
        if(response["code"]==1){
          $(".avatar").prop("src",response["avatar"])
        // header("Location:index.php");
        }else{
        $("#msg").text("输入的邮箱或密码有误,请重新输入");
        $(".alert").show();
        }
        }
        });
        })

        </script>
</body>

</html>