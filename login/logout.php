<?php
  session_start();
  if(!isset($_SESSION["id"]) || empty($_SESSION["id"])){
    echo("
    <script>
      alert('로그인시 적용됩니다');
      'http://".$_SERVER['HTTP_HOST']."/ALREADY_AWESOME/index.php';
    </script>
    ");
    exit();
  }else{
    
    unset($_SESSION["id"]);
    unset($_SESSION["name"]);
    unset($_SESSION["userlevel"]);
    unset($_SESSION["userpoint"]);
    echo("
      <script>
        location.href = 'http://".$_SERVER['HTTP_HOST']."/ALREADY_AWESOME/index.php';
      </script>
    ");
  }
?>