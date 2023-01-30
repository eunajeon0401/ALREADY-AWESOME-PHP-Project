<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ALREADY AWESOME</title>
  <link rel="stylesheet" href="../css/main.css?after" >
  <link rel="stylesheet" href="../css/member.css" >
  <script src="https://kit.fontawesome.com/175029ae6b.js" defer crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Genos&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <?php include "../header.php";?>
  </header>
<?php
  include_once  $_SERVER['DOCUMENT_ROOT']."/ALREADY_AWESOME/db/db_connecter.php";
  if(empty($_SESSION['id'])){
    echo "
    <script>
      alert('로그인 후 이용가능합니다');
      history.go(-1)
    </script>
    ";
    exit();
  }
  $sql = "select * from members where id = '$userid'";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($result);

  $pass = $row['pass'];
  $name = $row['name'];
  $email = $row['email'];

  mysqli_close($con);
?>
  <main>
    <form action="./member_modify_set.php" name ="member_form" method = "post">  
      <input type="hidden" name="id" value = "<?=$userid?>" >
      <div id = "member_container"> 
        <h2>MODIFYING</h2>

        <div id="member_info">
<?php
        if(isset($_GET['error'])){
          echo "<p class = 'error'>{$_GET['error']}</p>";
        }
?>
        <ul class = "member_info_input">
          <li class = "regist_title"><label for="">ID</label></li>       
          <li><input type= "text" value=<?=$userid?> name = "id" readonly ></li>       
        </ul>

        <ul class = "member_info_input">
          <li class = "regist_title"><label for="">PASSWORD</label></li>
          <li><input type= "password" placeholder = "PASSWORD" name = "pass" >   </li>
        </ul>

        <ul class = "member_info_input">
          <li class = "regist_title"><label for="">PASSWORD CHECK</label></li>
          <li><input type="password" name="pass2" placeholder = "PASSWORD CHECK"></li>
        </ul>

        <ul class = "member_info_input">
          <li class = "regist_title"><label for="">NAME</label></li>
          <li><input type="text" name="name" value = "<?=$name?>" ></li>
        </ul>

        <ul class = "member_info_input">
          <li class = "regist_title"><label for="">EMAIL</label></li>
          <li><input type="text" name="eamil" value ="<?=$email?>" ></li>
        </ul>
        </div>

        <div id = "member_button">
          <input type="button" class = "bts" onclick = "reset_form()"value="RESET">
          <input type="submit" class = "bts" value="SAVE">
        </div>
      </div>
    </form>
  </main>
  <footer>
    <?php include "../footer.php";?>
  </footer>
</body>
</html>