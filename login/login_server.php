<?php
  include_once  $_SERVER['DOCUMENT_ROOT']."/ALREADY_AWESOME/db/db_connecter.php";

  $id = $pass = "";

  
  if(isset($_POST['id']) && isset($_POST['pass'])){
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $pass = mysqli_real_escape_string($con, $_POST['pass']);

    $user_info = "id = {$id} ";
  
    if(empty($id)){
      header("location: http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/login/login_form.php?error=아이디를 입력 부탁드립니다&$user_info");
      exit();
    }else if(empty($pass)){
      header("location: http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/login/login_form.php?error=비밀번호를 입력 부탁드립니다&$user_info");
      exit();
    }else{
      $sql_same = "select * from members where id ='$id'";
      $record_set = mysqli_query($con, $sql_same);

      if(mysqli_num_rows($record_set) == 1){
        $row = mysqli_fetch_array($record_set);
        $hash_value = $row["pass"];

        if(password_verify($pass, $hash_value)){
          session_start();
          $_SESSION["id"] = $row["id"];
          $_SESSION["name"] = $row["name"];
          $_SESSION["level"] = $row["level"];
  
          header("location: http://".$_SERVER['HTTP_HOST']."/ALREADY_AWESOME/index.php");
        }else{
          header("location: http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/login/login_form.php?error=비밀번호가 틀렸습니다&$user_info");
          exit();
        }
      }else{
        header("location: http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/login/login_form.php?error=아이디를 잘못 입력하셨습니다&$user_info");
        exit();
      }
    }
  }else{
    header("location: http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/login/login_form.php?error=알수 없는 오류입니다&$user_info");
    exit();
  }
mysqli_close($con);
?>