<?php
 include_once  $_SERVER['DOCUMENT_ROOT']."/ALREADY_AWESOME/db/db_connecter.php";

  session_start();
  $userid = (isset($_SESSION['id'])) ? $_SESSION['id'] : "";

  if(isset($_GET['mode']) && $_GET['mode'] == "insert1" ){
    $num = $_GET['num'];

    $sql_insert = "insert into buy (num, id) values ('$num','$userid')";
    $result = mysqli_query($con, $sql_insert);

    if(!$result){
      echo"
      <script>
        alert ('구매하기에에 넣을 수가 없습니다');
        history.go(-1)
      </script>   
      ";
      exit();
    }else{
      echo"
      <script>
        alert('구매하기 페이지로 넘어갑니다')
        location.href = 'buy_list.php?num=$num';
      </script>
    ";
    }
  }else if (isset($_GET['mode']) && $_GET['mode'] == "insert2"){
    $num_item = 0;

    if(isset($_POST['delete'])){
      $num_item = count($_POST['delete']);
    } else{
      echo"
      <script>
        alert ('구매하실 상품을 선택해 주세요');
        history.go(-1)
      </script>   
      ";
    }
    
    $result = null;

    for($i = 0; $i < $num_item; $i++){
      $cart_num = $_POST['delete'][$i];

      $sql_select = "select * from cart where cart_num = $cart_num";
      $result = mysqli_query($con, $sql_select);
      $row = mysqli_fetch_array($result);

      $num = $row['num'];
      $sql_insert = "insert into buy (num, id) values ($num, '$userid')";
      $result2 = mysqli_query($con, $sql_insert);
    }

    if(!$result2){  
      echo"
      <script>
        alert('구매하기로 넘어가기 실패');
      </script>
      ";
    }

    header("location: http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/buy/buy_list.php");
    exit();

  }else if(isset($_GET['mode']) && $_GET['mode'] == "insert3"){
    $name = $_GET['name'];
    $address = $_GET['address'];
    $phone = $_GET['phone'];
    $num = $_GET['num'];

    $name = htmlspecialchars($name, ENT_QUOTES);
    $address = htmlspecialchars($address, ENT_QUOTES);
    $phone = htmlspecialchars($phone, ENT_QUOTES);

    if(empty($name)){
      echo"
      <script>
        alert('이름을 입력하세요')
        location.href = 'buy_list.php?num=$num';
        
      </script>
    ";
    exit();
    }else if(empty($address)){
      echo"
      <script>
        alert('주소를 입력하세요')
        location.href = 'buy_list.php?num=$num';
      </script>
    ";
    }else if(empty($phone)){
      echo"
      <script>
        alert('핸드폰 번호를 입력하세요')
        location.href = 'buy_list.php?num=$num';
      </script>
    ";
    }else{
      $sql_update = "update buy set name = '$name', address = '$address', phone ='$phone' where num = '$num'";
      $result = mysqli_query($con, $sql_update);

      if(!$result){
        echo "
        <script>
           alert ('정보 입력을 실패 했습니다');
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
             location.href = 'http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/board/index.php';
          </script>
        ";
        }else{
          echo "
          <script>
            alert('구매가 완료되었습니다')
            location.href = 'http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/index.php';
          </script>
        ";
        mysqli_close($con);
        }
      }
    }
  }else if(isset($_GET['mode']) && $_GET['mode'] == "delete"){ 
    $num_item = 0;
  
    if (!empty($_POST['delete'])){
      $num_item = count($_POST['delete']);
    }else{
      echo"
      <script>
        alert('삭제 할 게시물을 선택해주세요');
      </script>
      ";
    }

    $result = null;

    for ($i = 0; $i < $num_item; $i++) {
      $buy_num = $_POST['delete'][$i];

      $sql_select = "select * from buy where buy_num = $buy_num";
      $result_set = mysqli_query($con, $sql_select);
      $row = mysqli_fetch_array($result_set);
    
      $sql_delete = "delete from buy where buy_num = $buy_num";
      $result = mysqli_query($con, $sql_delete);
    }

    if(!$result){
      echo"
      <script>
        alert('삭제 실패');
      </script>
      ";
    }
    header("location: http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/buy/buy_list.php");
    exit();
  }


?>