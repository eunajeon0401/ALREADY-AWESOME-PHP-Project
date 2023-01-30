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
  <main>
    <form action="./login_server.php" name ="login_form" method = "post">  
      <div id = "member_container"> 
        <h2>LOGIN</h2>

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
        </div>
        <div id = "member_button">
        <input type="submit" class = "bts" value="LOGIN">
        </div>
      </div>
    </form>
  </main>
  <footer>
    <?php include "../footer.php";?>
  </footer>
</body>
</html>