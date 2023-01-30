<?php
  include $_SERVER['DOCUMENT_ROOT']."/ALREADY_AWESOME/db/db_connecter.php";
  include $_SERVER['DOCUMENT_ROOT']."/ALREADY_AWESOME/db/create_table.php";

  create_table($con, "members");
  create_table($con, "imgboard");
  create_table($con, "imgboard_info");
  create_table($con, "qnaboard");
  create_table($con, "qnaboard_ripple");
  // create_table($con, "board_ripple");
  create_table($con, "message");
  create_table($con, "review");
  create_table($con, "review_repple");
  create_table($con, "cart");
  create_table($con, "buy");
?>