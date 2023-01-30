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
      <h3>BUY NOW</h3>
    </div>
    <table id="item">
      <tr>
        <td>일반상품</td>
      </tr>
      <tr>
        <td></td>
        <th>이미지</th>
        <th>상품정보</th>
        <th>판매가</th>
        <th>수량</th>
        <th>적립금</th>
        <th>배송구분</th>
        <th>합계</th>
      </tr>
      <form action="./buy_server.php?mode=delete" method = "post">
  <?php
      if(empty($_SESSION['id'])){
        echo "
        <script>
          alert('로그인 후 이용가능합니다');
          history.go(-1)
        </script>
        ";
        exit();
      }
      
      include  $_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/db/db_connecter.php";
        // session_start();
        $id = $_SESSION['id'];

        if(isset($_GET['page'])){
          $page = $_GET['page'];
        }else{
          $page = 1;
        }
       
        $sql_select = "select * from buy where id = '$id'";
        $result_set = mysqli_query($con, $sql_select);
        if(mysqli_num_rows($result_set) == 0){
          echo "
          <tr>
            <td colspan='9'>선택하신 상품이 없습니다</td>
          </tr>
          ";
        }else{
          // $row = mysqli_fetch_array($result_set);
          $count = mysqli_num_rows($result_set);

          while($row1 = mysqli_fetch_array($result_set)){
            $num = $row1['num'];
            $buy_num = $row1['buy_num'];

            
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
          <td><input type="checkbox" name="delete[]" value="<?=$buy_num?>"></td>
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
          <td><select id = "option" name="option" onchange ="change_price()">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select></td>
          <td>100</td>
          <td>택배</td>
          <td id ="total"><?=$price?></td>
          <input type="number" id="price" value= "<?=$price?>"hidden> 
        </tr>
<?php     
          }
      }
       mysqli_close($con);
?>    
        <tr id="buy_delete_button">
          <td><button type="submit">삭제하기</button></td>
        </tr>
      </form>
   </table>
    <form  action="./buy_server.php" mothod = "post" name ="insert3"> 
      <input type="hidden" name="mode" value="insert3" >
      <div id ="input_info">
        <h4 class = "info_title" >주문 정보</h4>
        <ul > 
          <li class ="input_title">주문자 명 : </li>
          <li><input type="text" name = "name" class="input_values"></li>
        </ul>
        <ul>
          <li class ="input_title">주소 : </li>
          <li><input type="text" name= "address" class="input_values"></li>
        </ul>
        <ul>
          <li class ="input_title">휴대전화 : </li>
          <li><input type="number" name="phone" class="input_values"></li>
        </ul>
        <ul>
          <li class ="input_title">이메일 : </li>
          <li><input type="text" name="email" class="input_values"></li>
        </ul>
    </div>
    <h4 class =  "info_title">이용약관 동의</h4>
    <div id = "conditions" >
      <ul id = "top">
        <li class ="conditions_title">이용약관 동의</li>
        <li><textarea name="" id="" cols="140" rows="6" style = "overflow-y:scroll"readonly>제1조(목적)이 약관은 제이와이(전자상거래 사업자)가 운영하는 룩넌 사이버 몰(이하 “몰”이라 한다)에서 제공하는 인터넷 관련 서비스(이하 “서비스”라 한다)를 이용함에 있어 사이버 몰과 이용자의 권리․의무 및 책임사항을 규정함을 목적으로 합니다.※「PC통신, 무선 등을 이용하는 전자상거래에 대해서도 그 성질에 반하지 않는 한 이 약관을 준용합니다.」제2조(정의)① “몰”이란 제이와이 회사가 재화 또는 용역(이하 “재화 등”이라 함)을 이용자에게 제공하기 위하여 컴퓨터 등 정보통신설비를 이용하여 재화 등을 거래할 수 있도록 설정한 가상의 영업장을 말하며, 아울러 사이버몰을 운영하는 사업자의 의미로도 사용합니다.</textarea></li>
        <li class="check1"><input type="checkbox"  >동의</li>
      </ul>
      <ul>
        <li class ="conditions_title">개인정보 수집 </li>
        <li><textarea   cols="140" rows="6" style = "overflow-y:scroll"readonly>** 본 양식은 쇼핑몰 운영에 도움을 드리고자 샘플로 제공되는 서식으로 쇼핑몰 운영형태에 따른 수정이 필요합니다. 쇼핑몰에 적용하시기 전, 쇼핑몰 운영 사항 등을 확인하시고 적절한 내용을 반영하여 사용하시기 바랍니다. **1. 개인정보 수집목적 및 이용목적 : 비회원 구매 서비스 제공2. 수집하는 개인정보 항목 : 성명, 주소, 전화번호, 이메일, 결제 정보, 비회원 결제 비밀번호3. 개인정보의 보유기간 및 이용기간원칙적으로, 개인정보 수집 및 이용목적이 달성된 후에는 해당 정보를 지체 없이 파기합니다. 단, 다음의 정보에 대해서는 아래의 이유로 명시한 기간 동안 보존합니다.가. 회사 내부 방침에 의한 정보 보유 사유· 부정거래 방지 및 쇼핑몰 운영방침에 따른 보관 : OO년나. 관련 법령에 의한 정보보유 사유o 계약 또는 청약철회 등에 관한 기록-보존이유 : 전자상거래등에서의소비자보호에관한법률-보존기간 : 5년o 대금 결제 및 재화 등의 공급에 관한 기록-보존이유: 전자상거래등에서의소비자보호에관한법률-보존기간 : 5년 o 소비자 불만 또는 분쟁처리에 관한 기록-보존이유 : 전자상거래등에서의소비자보호에관한법률-보존기간 : 3년 o 로그 기록 -보존이유: 통신비밀보호법-보존기간 : 3개월#개인정보의 위탁 처리\"룩넌 쇼핑몰\" 은 서비스 향상을 위해 관계법령에 따라 회원의 동의를 얻거나 관련 사항을 공개 또는 고지 후 회원의 개인정보를 외부에 위탁하여 처리하고 있습니다.\"룩넌 쇼핑몰\" 의 개인정보처리 수탁자와 그 업무의 내용은 다음과 같습니다.-수탁자 : (주) 루나소프트-위탁업무내용 : 카카오톡 알림톡 발송 업무※ 동의를 거부할 수 있으나 거부시 비회원 구매 서비스 이용이 불가능합니다.</textarea></li>
        <li class="check1"><input type="checkbox">동의</li>
      </ul>
    </div>
    <h4 class = "info_title">결제방법</h4>   
    <div id = "price">
      <ul id = "checkbox">
        <li class = "check2">무통장입금
        <span><select name="bank" id="">
          <option value="sin">신한은행 111-222-333333</option>
          <option value="woo">우리은행 123-456-333333</option>
          <option value="sin">농협은행 44-12-222-333123</option>
        </select></span>
      </li>
        
      </ul>
      <ul class ="buttons">
        <li><button type="submit" class ="button">결제하기</button></li>
      </ul>
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
    let option = document.getElementById("option");
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