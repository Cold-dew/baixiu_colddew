<div class="aside">
    <div class="profile">
      <img class="avatar" src="../static/uploads/avatar.jpg">
      <h3 class="name">布头儿</h3>
    </div>
    <ul class="nav">
      <li class= "<?php echo $currentPage=="index" ? "active":"" ?>">
        <a href="index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <li>
      <?php 
      $pageArr=["posts","post-add","categories"];
      $bool=in_array($currentPage,$pageArr);
      
      
      ?>
       <!-- <a href="#menu-posts" class="collapsed" data-toggle="collapse" aria-expanded="true">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a> -->
        <a href="#menu-posts" class="<?php echo $bool ?"":"collapsed" ?>" data-toggle="collapse" <?php echo $bool ? ' aria-expanded="true"':"" ?> >
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse <?php echo $bool ?"in":"" ?> " <?php echo $bool ? ' aria-expanded="true"':"" ?>>
          <li class= "<?php echo $currentPage=="posts" ? "active":"" ?>"><a href="posts.php">所有文章</a></li>
          <li class= "<?php echo $currentPage=="post-add" ? "active":"" ?>"><a href="post-add.php">写文章</a></li>
          <li class= "<?php echo $currentPage=="categories" ? "active":"" ?>"><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <li class= "<?php echo $currentPage=="comments" ? "active":"" ?>">
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li class= "<?php echo $currentPage=="users" ? "active":"" ?>">
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <li>
      <?php 
      $pageArr=["nav-menus","slides","settings"];
      $bool=in_array($currentPage,$pageArr);
      
      
      ?>
      
        <a href="#menu-settings" class="<?php echo $bool ? "":"collapsed" ?>" data-toggle="collapse"
        <?php echo $bool ? 'aria-expanded="true"':"" ?>>
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse <?php echo $bool ?"in":"" ?> " <?php echo $bool ? ' aria-expanded="true"':"" ?>>
          <li class= "<?php echo $currentPage=="nav-menus" ? "active":"" ?>"><a href="nav-menus.php">导航菜单</a></li>
          <li class= "<?php echo $currentPage=="slides" ? "active":"" ?>"><a href="slides.php">图片轮播</a></li>
          <li class= "<?php echo $currentPage=="settings" ? "active":"" ?>"><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>
  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script>
  $(function(){
      $.ajax({
          type: "post",
          url: "api/_getUser.php",
         
          dataType: "json",
          success: function (res) {
              // console.log(res);
              
            // var profile =$(".profile");
            $(".profile").children("img").prop("src",res["avatar"]);
            $(".profile").children("h3").html(res["nickname"]);
          }
      });
  })
  
  
  
  </script>