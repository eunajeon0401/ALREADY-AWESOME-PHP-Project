<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ALREADY AWESOME</title>
  <link rel="stylesheet" href="../css/main.css?after" >
  <link rel="stylesheet" href="../css/buy_list.css" >
  <script src="https://kit.fontawesome.com/175029ae6b.js" defer crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Genos&display=swap" rel="stylesheet">
</head>
<body onload = 'callJs()'>
  <header>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/header.php";?>
  </header>
  <section>
    <div id = "title">
      <h3>CART</h3>
    </div>
    <table>
    <tr>
        <th>일반상품</th>
      </tr>
      <tr>
        <th></th>
        <th>이미지</th>
        <th>상품정보</th>
        <th>판매가</th>
        <th>수량</th>
        <th>적립금</th>
        <th>배송구분</th>
        <th>합계</th>
      </tr>
      <form method = "post" >
<?php
      if(empty($_SESSION['id']) && empty($_SESSION['id']) == "admin"){
        echo "
        <script>
          alert('회원이 아닙니다 회원 로그인 후 이용해주세요');
          history.go(-1)
        </script>
        ";
        exit();
      }
      include  $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/db/db_connecter.php";
        // session_start();
        $id = $_SESSION['id'];

        $sql_select = "select * from cart where id = '$id'";
        $result_set = mysqli_query($con, $sql_select);
        if(mysqli_num_rows($result_set) == 0){
          echo "
          <tr>
            <td colspan='9'>장바구니가 비어 있습니다</td>
          </tr>
          ";
        }else{
          $row = mysqli_fetch_array($result_set);

          $sql_select2 = "select count(*) from cart where id = $id";
          $result_set2 = mysqli_query($con, $sql_select);
          $count = mysqli_num_rows($result_set2);

          while($row1 = mysqli_fetch_array($result_set2)){
            $num = $row1['num'];
            $cart_num = $row1['cart_num'];

            $sql_select = "select * from imgboard where num = $num";
            $result = mysqli_query($con, $sql_select);
            $row = mysqli_fetch_array($result);

            $id = $row['id'];
            $title = $row['name'];
            $price = $row['price'];
            $file_name = $row['file_name'];
            $file_type = $row['file_type'];
            $file_copied = $row['file_copied'];

      
            $image_max_width = 70;
            $image_max_height = 100;
            
            if(!empty($file_name)){
              $image_info = getimagesize($_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/data/" . $file_copied);
              $image_width = $image_info[0];
              $image_height = $image_info[1];
              $image_type = $image_info[2];
            
              if ($image_width > $image_max_width){
                $image_width = $image_max_width;
              }
      
              if ($image_height > $image_max_height){
                $image_height = $image_max_height;
              }
            }
?>
        <tr>
          <td><input type="checkbox" name="delete[]" value="<?=$cart_num?>">
          </td>
        <td>
<?php
          if(strpos($file_type, "image") !== false){
            echo "<img src='http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/data/$file_copied' width='$image_width'><br>";
          }else{
            echo "
            <script>
              alert('이미지를 찾을 수 가없습니다');
            </script>
            ";
          }
?>      
        </td>
          <td><?=$title?></td>
          <td><?=$price?></td>
          <td><select id = "option" name="option">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select></td>
          <td>100</td>
          <td>택배</td>
          <td id ="total"><?=$price?></td>
          <input type="number" id="price" value= "<?=$price?>"hidden>
          <input type="number" id="delivery" value= "3000"hidden>
        </tr>
<?php         
          }
        }
        mysqli_close($con);
?>
    </table>
      <div>
        <td><button type="submit" formaction = "cart_server.php?mode=delete"  class = "button">삭제하기</button></td>
        <button type ="submit" formaction="../buy/buy_server.php?mode=insert2"  name = "buy" class = "button">구매하기</button>
      </div>
    </form>
  </section>
  <footer>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/footer.php";?>
  </footer>
</body>
  
</html>

<!-- <script>
  function change_price(){
    let option = document.querySelector("#option");
    let price = document.querySelector("#price");
    let delivery = document.querySelector("#delivery")
    let value = (option.options[option.selectedIndex].value);
    let total = document.querySelector("#total");
    
    

    let num1 = Number(price.value);
    let num2 = Number(value);
    let num3 = Number(delivery.value);

    total.textContent = num1 * num2 + num3;
  }
</script> -->

<script>
function callJs(){
    let option = document.querySelectorAll("#option");
    let price = document.querySelectorAll("#price");
    let delivery = document.querySelectorAll("#delivery");
    let total = document.querySelectorAll("#total");

    for (let i = 0; i < option.length; i++) {
        cartEvent(i);
    }

    function cartEvent(selectNumber) {
      console.log(selectNumber);
      option[selectNumber].addEventListener('change', ()=>{
        let value = (option[selectNumber].options[option[selectNumber].selectedIndex].value);
          total[selectNumber].textContent = Number(price[selectNumber].value) * Number(value);
      })
    }
  }
</script>