<?php
  include_once  $_SERVER['DOCUMENT_ROOT']."/ALREADY_AWESOME/db/db_connecter.php";

  include_once $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/db/function.php";
  
  session_start();
  $userid = (isset($_SESSION['id'])) ? $_SESSION['id'] : "";

  if(!isset($userid) || empty($userid)){
    echo ("
      <script>
      alert ('로그인 후 이용해 주세요');
      history.go(-1)
      </script>
    ");
    exit();
  }

  if(isset($_POST['mode']) && $_POST['mode'] == "insert"){
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    $title = htmlspecialchars($title, ENT_QUOTES);
    $content = htmlspecialchars($content, ENT_QUOTES);
    
    date_default_timezone_set('Asia/Seoul');
    $regist_day = date("Y-m-d (H:i)");

    if(empty($title)){
      header("location: qnaboard_form.php?error = 제목을 입력 부탁드립니다");
      exit();
    }else if(empty($content)){
      header("location: qnaboard_form.php?error = 제목을 입력 부탁드립니다");
      exit();
    }else{
      $sql_insert = "insert into qnaboard (id, title, content, regist_day, hit) ";
      $sql_insert .= "values ('$userid','$title','$content','$regist_day', 0)";
      $result = mysqli_query($con, $sql_insert);
      
      if(!$result){
        echo "
         <script>
            alert ('게시물 업로드를 실패 했습니다');
            history.go(-1)
          </script>   
        ";
        exit();
      }else{
        $point_up = 100;
  
        $sql_select = "select point from members where id = '$userid'";
        $result_set = mysqli_query($con, $sql_select);
        $row = mysqli_fetch_array($result_set);
        $new_point = $row['point'] + $point_up; 
    
        $sql_update ="update members set point = $new_point where id = '$userid'";
        mysqli_query($con, $sql_update);
  
        if(!$result){
          echo "
          <script>
            alert('포인트 점수가 적립 되지 않았습니다')
            location.href = 'qnaboard_form.php';
          </script>
        ";
        }else{
         
          echo "
          <script>
            alert('게시물이 성공적으로 작성되었습니다')
            location.href = 'qnaboard_list.php';
          </script>
        ";
        mysqli_close($con);
        }
      }
    }
  }else if(isset($_POST["mode"]) && $_POST["mode"] == "insert_repple"){
    if(empty($_POST["ripple_content"])){
      echo "
      <script>
        alert('내용 입력해주세요');
        history.go(-1);
      </script>
      ";
      exit();
    }

    $q_userid = mysqli_real_escape_string($con,$userid);
    $sql = "select * from members where id ='$q_userid'";
    $result = mysqli_query($con,$sql);
    if(!$result){
      die('Error:'.mysqli_error($con));
    }
    $rowcount = mysqli_num_rows($result);
    if(!$rowcount){
      echo "
      <script>
        alert('없는 아이디입니다');
        history.go(-1);
      </script>
      ";
      exit();
    }else{
      $content = input_set($_POST["ripple_content"]);
      $page = input_set($_POST["page"]);
      $parent = input_set($_POST["parent"]);
      $hit = input_set($_POST["hit"]);
      $q_usernick = isset($_SESSION['usernick']) ? mysqli_real_escape_string($con, $_SESSION['usernick']) : null;
      $q_username = mysqli_real_escape_string($con, $_SESSION['name']);
      $q_content = mysqli_real_escape_string($con, $content);
      $q_parent = mysqli_real_escape_string($con, $parent);
      $regist_day = date("Y-m-d (H:i)");

      $sql = "INSERT INTO `qnaboard_ripple` VALUES (null,'$q_parent','$q_userid','$q_username','$q_content','$regist_day')";
      $result = mysqli_query($con, $sql);
      if (!$result) {
          die('Error: ' . mysqli_error($con));
      }
      mysqli_close($con);
      echo "
      <script>
        location.href='./qnaboard_view.php?num=$parent&page=$page&hit=$hit';
      </script>
      ";
    }
  }else if (isset($_POST["mode"]) && $_POST["mode"] == "delete_ripple"){
    echo "들어왔니?";
    $page = input_set($_POST["page"]);
    $num = input_set($_POST["num"]);
    $parent = input_set($_POST["parent"]);
    $q_num = mysqli_real_escape_string($con, $num);

    $sql_delete = "DELETE FROM `qnaboard_ripple` WHERE num =$q_num";
    $result = mysqli_query($con, $sql_delete);
    if(!$result){
      die('Error: ' . myslqi_error($con));
    }
    mysqli_close($con);
    echo "
      <script>
        location.href= './qnaboard_view.php?num=$parent&page=$page';
      </script>
    ";
  }else{
    header("location: qnaboard_form.php?error= 알수 없는 오류 입니다&$user_info");
    exit();
  }
?>