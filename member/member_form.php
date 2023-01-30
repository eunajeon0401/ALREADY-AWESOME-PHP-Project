<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ALREADY AWESOME</title>
  <link rel="stylesheet" href="../css/main.css?after" >
  <link rel="stylesheet" href="../css/member.css" >
  <script src="https://kit.fontawesome.com/175029ae6b.js" defer crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Genos&display=swap" rel="stylesheet">
  <script src ="../js/main.js"></script>
</head>
<body>
  <header>
    <?php include "../header.php";?>
  </header>
  <main>
    <form action="./member_insert_server.php" name ="member_form" method = "post">  
      <div id = "member_container"> 
        <h2>REGISTER</h2>

        <div id="member_info">
<?php
        if(isset($_GET['error'])){
          echo "<p class = 'error'>{$_GET['error']}</p>";
        }
?>
        <ul class = "member_info_input">
          <li class = "regist_title"><label for="">ID</label></li>
<?php
          if(isset($_GET['id'])){
            $id = $_GET['id'];
            echo "<li><input type= 'text' placeholder = 'ID' name = 'id' value = '$id'></li>";
          }else{
            echo "<li><input type= 'text' placeholder = 'ID' name = 'id' ></li>";
          }
?>
          <li >
        </li>
        </ul>
        <ul class = "member_info_input">
        <li class = "regist_title"><label for="">PASSWORD</label></li>
<?php
          if(isset($_GET['pass'])){
            $id = $_GET['pass'];
            echo "<li><input type='password' placeholder = 'PASSWORD' name = 'pass' value = '$pass'></li>";
          }else{
            echo "<li><input type= 'password' placeholder = 'PASSWORD' name = 'pass' ></li>";
          }
?>
        </ul>
        <ul class = "member_info_input">
          <li class = "regist_title"><label for="">PASSWORD CHECK</label></li>
          <li><input type="password" name="pass2" placeholder = "PASSWORD CHECK"></li>
        </ul>
        <ul class = "member_info_input">
        <li class = "regist_title"><label for="">NAME</label></li>
        <li><input type="text" name="name" placeholder = "NAME"></li>
        </ul>
        <ul class = "member_info_input">
        <li class = "regist_title"><label for="">EMAIL</label></li>
        <li><input type="text" name="eamil" placeholder = "EMAIL"></li>
        </ul>
        </div>
        <div id = "member_button">
        <input type="reset" class = "bts" value="RESET">
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