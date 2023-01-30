<?php
  include_once  $_SERVER['DOCUMENT_ROOT']."/ALREADY_AWESOME/db/db_connecter.php";

  $id = $_POST["id"];
  $pass = $pass2 = $name = "";

  if(isset($_POST['pass']) && isset($_POST['pass2']) && isset($_POST['name'])){
    $pass = mysqli_real_escape_string($con, $_POST['pass']);
    $pass2 = mysqli_real_escape_string($con, $_POST['pass2']);
    $naem = mysqli_real_escape_string($con, $_POST['name']);

    $user_info = "pass = {$pass} & pass2 = {$pass} & name = {$name}";

    if(empty($pass)){
      header("location: member_modify_form.php?error=비밀번호를 입력 부탁드립니다&$user_info");
      exit();
    }else if(empty($pass2)){
      header("location: member_modify_form.php?error=비밀번호 확인 입력 부탁드립니다&$user_info");
      exit();
    }else if(empty($name)){
      header("location: member_modify_form.php?error=이름을 입력 부탁드립니다&$user_info");
      exit();
    }else if( $pass !== $pass2){
      header("location: member_modify_form.php?error=비밀번호가 틀립니다&$user_info");
      exit();
    }else{
      $pass = password_hash($pass, PASSWORD_DEFAULT);
      $sql_same = "select * from members where id = '$id'";
      $record_set = mysqli_query($con, $sql_same);

      if(!mysqli_num_rows($record_set) == 1){
        header("location: member_modify_form.php?error=존재하지 않는 아이디입니다&$user_info");
        exit();
      }else{
        if(!empty($_POST['email'])){
          $sql_update = "update members set pass = '$pass', name ='$name', email = '{$_POST['email']}'";
          $sql_update .= "where id ='$id'";
          $result = mysqli_query($con, $sql_update);
        }else{
          $sql_update = "update members set pass = '$pass', name ='$name' where id ='$id'";
          $result = mysqli_query($con, $sql_update);
        }

        if($result){
          header("location: member_modify_form.php?error=성공 적으로 수정되었습니다&$user_info");
          exit();
        }else{
          header("location: member_modify_form.php?error=수정을 실패 하였습니다&$user_info");
          exit();
        }
      }
    }
  }else{
    header("location: member_modify_form.php?error=알수 없는 오류입니다&$user_info");
    exit();
  }
  mysqli_close($con);

?>