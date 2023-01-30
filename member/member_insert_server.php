<?php
  include_once  $_SERVER['DOCUMENT_ROOT']."/ALREADY_AWESOME/db/db_connecter.php";

  $id = $pass = $pass2 = $name = $email = "";
  
  if(isset($_POST['id']) && isset($_POST['pass']) && isset($_POST['pass2']) && isset($_POST['name'])){
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $pass = mysqli_real_escape_string($con, $_POST['pass']);
  $pass2 = mysqli_real_escape_string($con, $_POST['pass2']);
  $name = mysqli_real_escape_string($con, $_POST['name']);

  $user_info = "id = {$id} & pass = {$pass} & pass2 = {$pass2} & name = {$name}";

  if(empty($id)){
    header("location: member_form.php?error=아이디를 입력 부탁드립니다&$user_info");
    exit();
  }else if(empty($pass)){
    header("location: member_form.php?error=비밀번호를 입력 부탁드립니다&$user_info");
    exit();
  }else if(empty($pass2)){
    header("location: member_form.php?error=비밀번호를 확인 부탁드립니다&$user_info");
    exit();
  }else if(empty($name)){
    header("location: member_form.php?error=이름을 입력 부탁드립니다&$user_info");
    exit();
  }else if($pass !== $pass2){
    header("location: member_form.php?error=비밀번호가 일치하지 않습니다&$user_info");
    exit();
  }else{
    $pass = password_hash($pass, PASSWORD_DEFAULT);
    $regist_day = date("Y-m-d(H:i)");
    $sql_same = "select * from members where id = '$id'";
    $record_set = mysqli_query($con, $sql_same);
    if(mysqli_num_rows($record_set) == 1){
      header("location: member_form.php?error=아이디가 이미 존재합니다&$user_info");
      exit();
    }else{
      if(!empty($_POST['email'])){
        $sql_insert = "insert into members (id, pass, name, email, regist_day, level, point) "; 
        $sql_insert .= "values ('$id','$pass','$name','{$_POST['email']}', '$regist_day', 9 , 0)";
        $result = mysqli_query($con, $sql_insert);
      }else{
        $sql_insert = "insert into members (id,pass,name, regist_day, level, point)"; $sql_insert .= "values ('$id','$pass','$name','$regist_day',9,0)";
        $result = mysqli_query($con, $sql_insert);
      }
      
    }
    if($result){
      header("location: http://".$_SERVER['HTTP_HOST']."/ALREADY_AWESOME/index.php");
      exit();
    }else{
      header("location: member_form.php?error=회원 가입을 실패했습니다&$user_info");
      exit();
    }
    }
  }else{
    header("location: member_form.php?error=알수 없는 오류입니다&$user_info");
    exit();
  }
mysqli_close($con);
?>