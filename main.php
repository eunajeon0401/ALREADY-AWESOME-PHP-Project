<div id="main_container">
  <div class = "main_slideshow">
    <div class = "main_slideshow_poto">
      <a href="#" class="active"><img src="./img/main_slideshow.jpg" alt="slides"></a>
      <a href="#" class="active"><img src="./img/main_slideshow2.jpg" alt="slides"></a>
      <a href="#" class="active"><img src="./img/main_slideshow3.jpg" alt="slides"></a>
    </div>
    <div class="slideshow_nav">
      <a href="#" class="prev">
        <i class="fa-solid fa-circle-left"></i>
      </a>
      <a href="#" class="next">
        <i class="fa-solid fa-circle-right"></i>
      </a>
    </div>
    <div class="indicator">
      <a href="#" class="active">
        <i class="fa-solid fa-circle"></i>
      </a>
      <a href="#" >
        <i class="fa-solid fa-circle"></i>
      </a>
      <a href="#" >
        <i i class="fa-solid fa-circle"></i>
      </a>
    </div><br>
  </div>
  <div id="main_content">
    <h3 id = "text_main">NEW</h3>
    <div id="img_container">
      <ul id = "img_item">
<?php
       include  $_SERVER['DOCUMENT_ROOT']."/ALREADY_AWESOME/db/db_connecter.php";
       
       if(isset($_GET['page'])){
        $page = $_GET['page'];
      }else{
        $page = 1;
      }

       $scale = 9;

       $sql_select = "select * from imgboard order by num desc limit 0, $scale";
       $result_set = mysqli_query($con, $sql_select);

       while($row = mysqli_fetch_array($result_set)){
        $num = $row["num"];
        $price = $row["price"];
        $title = $row["name"];
        $file_name = $row["file_name"];
        $file_type = $row["file_type"];
        $file_copied = $row["file_copied"];
        

       $image_max_width = 350;
       $image_max_height = 350;



         if(!empty($file_name)){
           $image_info = getimagesize($_SERVER['DOCUMENT_ROOT'] . "/ALREADY_AWESOME/data/" .$file_copied);
           $image_width = $image_info[0];
           $image_height = $image_info[1];
           $image_type = $image_info[2];

           if($image_width > $image_max_width){
             $image_width = $image_max_width;
           }
           if($image_height > $image_max_height){
             $image_height = $image_max_height;
           }
         }
?>
         <li id ="board_item">
           <table>
             <tr>
             <a href="http://<?=$_SERVER['HTTP_HOST'];?>/ALREADY_AWESOME/board/imgboard_view.php?num=<?= $num?>">
<?php
               if(strpos($file_type, "image") !== false){
                 echo "<img id = 'board_img' src='http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/data/$file_copied' width='$image_width' height='$image_height'><br>";
               }else{
                 echo "<img id = 'board_img' src='http://{$_SERVER['HTTP_HOST']}/ALREADY_AWESOME/img/user.jpg'' width='$image_max_width' height='$image_max_height'><br>";
               }

               $best = $row['best'] == "1" ? "BEST" : "";
               $new = $row['new'] == "1" ? "NEW" : "";
               $delivery = $row['delivery'] == "1" ? "당일배송" : "";
?>         
             </a>
             </tr>
             <tr>
             <td><?=$title?></td>
             </tr>
             <tr>
             <td><?= $price ?></td>
             </tr>
             <tr>
             <td>
              <span  id = "type_new"><?=$new?></span>
              <span id = "type_best"><?=$best?></span>
              <span id = "type_delivery"><?=$delivery?></span>
             </td>
             </tr>
           </table>
         </li>
<?php
         // mysqli_close($con);
       }
?>      
      </ul>     
    </div>
  </div>
</div>
</div>