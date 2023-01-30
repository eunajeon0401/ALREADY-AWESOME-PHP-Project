<?php
 include_once  $_SERVER['DOCUMENT_ROOT']."/ALREADY_AWESOME/db/db_connecter.php";

  session_start();
  $userid = (isset($_SESSION['id'])) ? $_SESSION['id'] : "";

  if(isset($_GET['mode']) && $_GET['mode'] == "insert"){
    $num = $_GET['num'];
    
    if(empty($num)){
      echo"
      <script>
        alert('게시물이 없습니다.');
      </script>
      ";
    }else{
      $sql_insert = "insert into cart (num, id) values ('$num','$userid')";
      $result = mysqli_query($con, $sql_insert);

      if(!$result){
        echo"
        <script>
          alert ('장바구니에 넣을 수가 없습니다');
          history.go(-1)
        </script>   
        ";
      }else{
        echo"
        <script>
          alert('장바구니에 게시물을 넣었습니다')
          location.href = 'cart_list.php';
        </script>
      ";
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
      $cart_num = $_POST['delete'][$i];
    
      $sql_select = "select * from cart where cart_num = $cart_num";
      $result_set = mysqli_query($con, $sql_select);
      $row = mysqli_fetch_array($result_set);
    
      $sql_delete = "delete from cart where cart_num = $cart_num";
      $result = mysqli_query($con, $sql_delete);
    }

    if(!$result){  
      echo"
      <script>
        alert('삭제 실패');
      </script>
      ";
    }

    header("location: http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/cart/cart_list.php");
    exit();
  }


?>