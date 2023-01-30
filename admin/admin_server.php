<?php
// start session
session_start();

// ternary operator
$id = isset($_SESSION['id']) ? $_SESSION['id'] : "";

if ($id != "admin") {
  alert_back('관리자가 아닙니다. 회원정보 수정 및 삭제는 관리자만 가능합니다.');
  exit();
}

// connect database
include_once $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/db/db_connecter.php";

// set mode
$mode = $_GET['mode'];

switch ($mode) {
  case "update":
    $num = $_POST['num'];
    $level = $_POST['level'];
    $point = $_POST['point'];

    $sql_update = "update members set level = $level, point = $point where num = $num";
    $result = mysqli_query($con, $sql_update);
    mysqli_close($con);

    if ($result){
      echo"
      <script>
        alert('업데이트 성공');
      </script>
      ";
    }else{
      echo"
      <script>
        alert('업데이트 실패');
      </script>
      ";
    }

    header("location: http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/admin/admin_form.php");
    break;

  case "delete":
    $num = $_GET['num'];
    $sql_delete = "delete from members where num = $num";
    $result = mysqli_query($con, $sql_delete);
    mysqli_close($con);


    if (!$result){
      echo"
      <script>
        alert('삭제 실패');
      </script>
      ";
    }
    header("location: http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/admin/admin_form.php");
    break;

  case "review_delete":
    $num_item = 0;

    if (isset($_POST['item'])){
      $num_item = count($_POST['item']);
    }else{
      echo"
      <script>
        alert('삭제 할 게시물을 선택해주세요');
      </script>
      ";
    }

    $result = null;

    for ($i = 0; $i < $num_item; $i++) {
      $num = $_POST['item'][$i];

      $sql_select = "select * from review where num = $num";
      $result_set = mysqli_query($con, $sql_select);
      $row = mysqli_fetch_array($result_set);
      $copied_name = $row['file_copied'];

      if ($copied_name) {
        $file_path = $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/review_data/" . $copied_name;
        unlink($file_path);
      }
      $sql_delete = "delete from review where num = $num";
      $result = mysqli_query($con, $sql_delete);
    }

    if(!$result){
      echo"
      <script>
        alert('삭제 실패');
      </script>
      ";
    }
    header("location: http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/admin/admin_form.php");
    break;
  case "buy_delete":
      $num_item = 0;
  
      if (isset($_POST['item'])){
        $num_item = count($_POST['item']);
      }else{
        echo"
        <script>
          alert('삭제 할 게시물을 선택해주세요');
        </script>
        ";
      }
  
      $result = null;
  
      for ($i = 0; $i < $num_item; $i++) {
        $num = $_POST['item'][$i];
  
        $sql_select = "select * from buy where buy_num = '$num'";
        $result_set = mysqli_query($con, $sql_select);
        $row = mysqli_fetch_array($result_set);
      
        $sql_delete = "delete from buy where buy_num = '$num'";
        $result = mysqli_query($con, $sql_delete);
      }
  
      if(!$result){
        echo"
        <script>
          alert('삭제 실패');
        </script>
        ";
      }
      header("location: http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/admin/admin_form.php");
      break;
    default :  break;
  } 

mysqli_close($connect);
?>