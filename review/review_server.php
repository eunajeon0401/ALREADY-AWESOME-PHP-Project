<?php
  include_once  $_SERVER['DOCUMENT_ROOT']."/ALREADY_AWESOME/db/db_connecter.php";

  include_once $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/db/function.php";
  
  session_start();
  $userid = (isset($_SESSION['id'])) ? $_SESSION['id'] : "";
  $username = (isset($_SESSION['name'])) ? $_SESSION['name'] : "";

  if(isset($_POST['mode']) && $_POST['mode'] == "insert"){
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    $title = htmlspecialchars($title, ENT_QUOTES);
    $content = htmlspecialchars($content, ENT_QUOTES);

    date_default_timezone_set('Asia/Seoul');
    $regist_day = date("Y-m-d (H:i)");
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/review_data/";

    $upfile_name = $_FILES['upfile']['name'];
    $upfile_tmp_name = $_FILES['upfile']['tmp_name'];
    $upfile_type = $_FILES['upfile']['type'];
    $upfile_size = $_FILES['upfile']['size'];
    $upfile_error = $_FILES['upfile']['error'];

    if($upfile_name  && !$upfile_error){
      $file = explode(".", $upfile_name);
      $file_name = $file[0];
      $file_ext = $file[1];

      $new_file_name = date("Y_m_d_H_i_s");
      $new_file_name = $new_file_name . "_" . $file_name;

      $copied_file_name = $new_file_name . "." . $file_ext;
      $uploaded_file = $upload_dir . $copied_file_name;

      if($upfile_size > 1000000){
        echo "
        <script>
          alert('업로드 파일크기가 지정된 용량(1MB)을 초과합니다 파일 크기를 체크부탁드립니다');
        </script>
        ";
      }

      if(!move_uploaded_file($upfile_tmp_name, $uploaded_file)){
        echo "
        <script>
          alert('파일을 지정한 디렉토리에 복하는데 실패했습니다');
        </script>
        ";
      }
    }else{
      $upfile_name = "";
      $upfile_type ="";
      $copied_file_name = "";
    }

    if(empty($upfile_name)){
      $sql_insert = "insert into review (id, name, title, content, regist_day, hit) ";
      $sql_insert .= "values ('$userid','$username','$title','$content','$regist_day', 0)";
      mysqli_query($con, $sql_insert);
    }else{
      $sql_insert = "insert into review (id, name, title, content, regist_day, hit, file_name, file_type, file_copied) ";
      $sql_insert .= "values ('$userid','$username','$title','$content','$regist_day', 0,'$upfile_name','$upfile_type','$copied_file_name')";
      mysqli_query($con, $sql_insert);
    }
    $point_up = 100;

    $sql_select = "select point from members where id = '$userid'";
    $result_set = mysqli_query($con, $sql_select);
    $row = mysqli_fetch_array($result_set);
    $new_point = $row['point'] + $point_up; 

    $sql_update ="update members set point = $new_point where id = '$userid'";
    mysqli_query($con, $sql_update);
    mysqli_close($con);

    header("location: http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/review/review_list.php");
    exit();
  }else if(isset($_POST['mode']) && $_POST['mode'] == "insert_repple"){
    if(empty($_POST["ripple_content"])){
      echo "
      <script>
        alert('내용 입력 바랍니다');
      </script>";
      exit();
    }
    
    $q_userid = mysqli_real_escape_string($con, $userid);
    $sql_select = "select * from members where id = '$q_userid'";
    $result = mysqli_query($con, $sql_select);
    if(!$result){
      die('Error: ' .mysqli_error($con));
    }
    $rowcount = mysqli_num_rows($result);

    if(!$rowcount){
      echo "
        <script>
          alert('없는 아이디 입니다');
          history.go(-1);
        </script>
      ";
    }else{
      $content = input_set($_POST["ripple_content"]);
      $page = input_set($_POST["page"]);
      $parent = input_set($_POST["parent"]);
      $q_username = mysqli_real_escape_string($con, $_SESSION['name']);
      $q_content = mysqli_real_escape_string($con, $content);
      $q_parent = mysqli_real_escape_string($con, $parent);
      $regist_day = date("Y-m-d (H:i)");

      $sql_insert = "INSERT INTO `review_repple` VALUES (null, '$q_parent','$q_userid','$q_username','$q_content','$regist_day')";
      $result = mysqli_query($con, $sql_insert);
      if(!$result){
        die('Error: ' . mysqli_error($con));
      }
      mysqli_close($con);
      echo "
        <script>
          location.href='./review_view.php?num=$parent&page=&page';
        </script>
      ";
    }
  }else if (isset($_POST["mode"]) && $_POST["mode"] == "delete_ripple"){
    $page = input_set($_POST["page"]);
    $num = input_set($_POST["num"]);
    $parent = input_set($_POST["parent"]);
    $q_num = mysqli_real_escape_string($con, $num);

    $sql_delete = "DELETE FROM `review_repple` WHERE num =$q_num";
    $result = mysqli_query($con, $sql_delete);
    if(!$result){
      die('Error: ' . myslqi_error($con));
    }
    mysqli_close($con);
    echo "
      <script>
        location.href= './review_view.php?num=$parent&page=$page';
      </script>
    ";
  }else if (isset($_GET["mode"]) && $_GET["mode"] == "delete"){
    $page = $_GET["page"];
    $num = $_GET['num'];

    $sql = "select * from review where num = $num";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    $copied_name = $row["file_copied"];

    if($copied_name){
      $file_path = $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/review_data/" . $copied_name;
      unlink($file_path);
    }
    
    $sql_delete = "delete from review where num = $num";
    mysqli_query($con, $sql);

    $sql = "delete from review_repple where parent = $num";
    mysqli_query($con, $sql_delete);
    mysqli_close($con);
    
    header("location: http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/review/review_list.php?page=$page");
  }
?>