<?php
  // 세션값 체크
  session_start();
  $userid = $username = $userlevel = $userpoint ="";
  if(isset($_SESSION["id"])) $userid = $_SESSION["id"];
  if(isset($_SESSION["name"])) $username = $_SESSION["name"];
  if(isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
  if(isset($_SESSION["userpoint"])) $userpoint = $_SESSION["userpoint"];
?>
<div id = "header_container">
  <!-- 로고 -->
  <div id = "header_main">
    <h1>
    <a href="http://<?=$_SERVER['HTTP_HOST'];?>/ALREADY_AWESOME/index.php"> ALREADY AWESOME</a> 
    </h1>
    <!-- 로그인 이전, 이후, 관리자 모드로 분리 -->
    <ul>
<?php
    if(!$userid){
?>
      <li><a href ="http://<?=$_SERVER['HTTP_HOST'];?>/ALREADY_AWESOME/login/login_form.php">LOGIN</a> </li>
      <li><a href ="http://<?=$_SERVER['HTTP_HOST'];?>/ALREADY_AWESOME/member/member_form.php">REGISTER</a></li>
      <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/ALREADY_AWESOME/cart/cart_list.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
<?php
    }else{
?>
      <li><?=$username ."(".$userid.")";?></li>
      <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/ALREADY_AWESOME/login/logout.php">LOGOUT</a></li>
      <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/ALREADY_AWESOME/member/member_modify_form.php">MODIFYING</a></li>
      <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/ALREADY_AWESOME/cart/cart_list.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
<?php
    }
?>
<?php
    if($userid == "admin"){
?>
      <li><a href="http://<?=$_SERVER['HTTP_HOST'];?>/ALREADY_AWESOME/admin/admin_form.php">MANAGER</a></li>
<?php 
    }
?>
    </ul>
  </div>
  <!-- 메뉴바 -->
  <div>
    <ul id ="header_menu_bar">
      <li class= "menu_itme"><a href="http://<?=$_SERVER['HTTP_HOST'];?>/ALREADY_AWESOME/index.php">HOME</a></li>
      <li class= "menu_itme"><a href="http://<?=$_SERVER['HTTP_HOST'];?>/ALREADY_AWESOME/board/imgboard_list.php?mode=outer">OUTER</a></li>
      <li class= "menu_itme"><a href="http://<?=$_SERVER['HTTP_HOST'];?>/ALREADY_AWESOME/board/imgboard_list.php?mode=top">TOP</a></li>
      <li class= "menu_itme"><a href="http://<?=$_SERVER['HTTP_HOST'];?>/ALREADY_AWESOME/board/imgboard_list.php?mode=bottom">BOTTOM</a></li>
      <li class= "menu_itme"><diV class="dropdown">
      <a href="#" class = "dropdown-button">COMMUNITY</a>
      <div class="dropdown-content">
        <a href="http://<?=$_SERVER['HTTP_HOST'];?>/ALREADY_AWESOME/review/review_list.php">REVIEW</a>
        <a href="http://<?=$_SERVER['HTTP_HOST'];?>/ALREADY_AWESOME/board/qnaboard_list.php">Q&A</a>
      </diV>
    </div></li>
  </ul>
</div>