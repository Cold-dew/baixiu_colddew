<?php 
  $conn=mysqli_connect(DB_HOST,DB_USER, DB_PASS,DB_NAME);
  $sql="SELECT * FROM categories where id !=1";
  $result=mysqli_query($conn, $sql);
  $res=[];
  while ($arr = mysqli_fetch_assoc($result)) {
    $res[]=$arr;
  };

  

?>

<div class="header">
      <h1 class="logo"><a href="index.php"><img src="static/assets/img/logo.png" alt=""></a></h1>
      <ul class="nav">
      <?php foreach ($res as $key => $value) { ?>

<li><a href="list.php?id=<?php echo $value['id'] ?>"><i class="fa <?php echo $value['classname'] ?>"></i><?php echo $value['name'] ?></a></li>
<?php  } ?>
      </ul>
      <div class="search">
        <form>
          <input type="text" class="keys" placeholder="输入关键字">
          <input type="submit" class="btn" value="搜索">
        </form>
      </div>
      <div class="slink">
        <a href="javascript:;">链接01</a> | <a href="javascript:;">链接02</a>
      </div>
    </div>