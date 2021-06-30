<?php

  //Get database and session.
  include_once("inc/database.php");

  if (isset($_SESSION["account_type"]) && $_SESSION["account_type"] === "admin") {
    header("location: viewUsers.php");
    exit();
  }

  //Verify if post ID exists.
  $p_id = $_GET["id"];
  $p_id = $hashId->decode($p_id);
  $p_id = $p_id[0];

  $checkPostID = $pdo->prepare("SELECT verify_post_id_exists(:post_id)");
  $checkPostID->execute(["post_id" => $p_id]);
  $checkPostID = $checkPostID->fetch(PDO::FETCH_COLUMN);
  //Redirect if post does not exist.
  if (!$checkPostID) {
    header("location: ../");
  }

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Sociality | View Post</title>

     <!-- Import Material Design Lite CSS -->
     <link rel="stylesheet" href="../mdl/material.min.css">

     <!-- Import Material Design Lite Javascript -->
     <script src="../mdl/material.min.js" charset="utf-8"></script>
     <!-- Import Material Design Icons from Google -->
     <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

     <!-- Shortcut Icon -->
     <link rel="shortcut icon" href="images/assets/sample2.png">

     <!-- Custom CSS File -->
     <?php include_once("../css/customStyles.php"); ?>
     <link rel="stylesheet" type="text/css" href="../css/viewPostStyles.css">
     <link rel="stylesheet" href="../css/scrollbar.css">

     <!-- Import jQuery v3.6.0 -->
     <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

     <!-- Like Post in JS, work in progress -->
     <script src="ajax/xmlhttp.js" charset="utf-8"></script>
   </head>
   <body>
     <?php include_once("inc/_js_mdl_formAlert.php"); ?>

      <style>
      @import url('https://fonts.googleapis.com/css2?family=Staatliches&display=swap');
        .demo-layout-transparent {

          background: #ad5389;  /* fallback for old browsers */
          background: -webkit-linear-gradient(#21094e, #6148bf);  /* Chrome 10-25, Safari 5.1-6 */
          background: linear-gradient(#21094e, #6148bf); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }
        .demo-layout-transparent .mdl-layout__header,
        .demo-layout-transparent .mdl-layout__drawer-button {

          color: #cca8e6;
        }
      </style>

      <div class="demo-layout-transparent mdl-layout mdl-js-layout">

        <?php include_once("inc/navbar.php"); ?>

        <?php
          //Dialog for deleting posts.
          include_once("inc/_js_mdl_deletePostDialog.php");
        ?>

       <main class="mdl-layout__content">

         <div class="page-content">

           <?php

             // PDO direct dump data into an array.
             $db_existingPosts = $pdo->query("SELECT post_id FROM tbl_feed")->fetchAll(PDO::FETCH_COLUMN);

             $decodedIDArr = (isset($_GET["id"])) ? $hashId->decode($_GET["id"]) : "" ;
             $decodedID = $decodedIDArr[0];

             //Redirect if there is no data, or if there is and it is not valid.
             if (empty($decodedID) || !in_array($decodedID, $db_existingPosts)):
               header("location: ../");
               exit();
             endif;

             $pdoq_getPostData = $pdo->prepare("SELECT * FROM view_posts_full WHERE post_id = :post_id");
             $pdoq_getPostData->execute(['post_id' => $decodedID]);
             $row = $pdoq_getPostData->fetch(PDO::FETCH_ASSOC);

             // Handling Like data.
             // Copied from Index. very inefficient, to be rewritten.
             if (isset($_SESSION["account_id"])):

               // PDO: Prepare the user's like data so the posts can be marked.
               $pdoq_getUserLikedPosts = $pdo->prepare("SELECT post_id FROM tbl_feed_likes WHERE user_id = :user_id");
               $pdoq_getUserLikedPosts->execute(['user_id' => $_SESSION["account_id"]]);
               $user_liked_post_id = $pdoq_getUserLikedPosts->fetchAll(PDO::FETCH_COLUMN);

             endif;

             // Like Data setup.
             $isLiked = (isset($user_liked_post_id) && in_array($row["post_id"], $user_liked_post_id));

             // NOTE: First string is the color/text when the post IS LIKED, the other is when it is NOT liked.
             $post_likeButton_color = ($isLiked) ? "#000099" : "#262626";
             $post_likeButton_text = ($isLiked) ? "Unlike" : "Like";

             //"Encrypted" POST ID because style.
             $post_fancyID = $_GET["id"];

             //Prepare link for ViewPost.
             $post_viewPost_href = "viewPost.php?id=$post_fancyID";

             //Prepare like and comment count for each post.
             $post_likeCount = (isset($row['count_likes'])) ? $row['count_likes'] : 0;
             $post_commentCount = (isset($row['count_comments'])) ? $row['count_comments'] : 0;

             $profileIDHolder = $hashId->encode($row["user_id"]);
             $profileLink = "viewProfile.php?id=$profileIDHolder";

             //For JS XMLHttpRequest
             $js_likePostLink = "ajax/xmlhttp_likePost.php?id=".$post_fancyID;

             //Post control (edit,delete, etc)
             $postControlButtonId = "post_control_$post_fancyID";

              //Toggle to show the post control links.
              $postControlToggleMenu = ($row["user_id"] === $_SESSION["account_id"]);
              //Post control links
              $postControl_editPost = "createPost.php?e=$post_fancyID";
              $postControl_deletePost = "ajax/xmlhttp_deletePost.php?id=$post_fancyID";
            ?>

            <?php // Post holder. ?>
            <div class="feed_post" id="<?php echo 'p_'.$post_fancyID; ?>">

              <!-- This is the post control menu button -->

              <!-- For frontend: fix the size of the button, it's hard to activate it. -->
              <?php if ($postControlToggleMenu): ?>

                <div class="more-horiz">
                  <button id="<?php echo $postControlButtonId; ?>"
                    class="mdl-button mdl-js-button mdl-button--icon"
                  >
                    <i class="material-icons">more_vert</i>
                  </button>

                  <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                      for="<?php echo $postControlButtonId; ?>">
                      <!-- Edit Post -->
                    <a href="<?php echo $postControl_editPost; ?>">
                      <li class="mdl-menu__item">Edit Post</li>
                    </a>
                    <!-- Delete Post -->
                    <a href="Javascript:void(0)" onClick="xml_deletePost('dialog_deletePost',
                      '<?php echo $postControl_deletePost; ?>')">
                      <li class="mdl-menu__item">Delete Post</li>
                    </a>
                  </ul>
                </div>

              <?php endif; ?>

              <div class="feed_userpic">
                <a href="<?php echo $profileLink?>">
                  <img src="<?php echo $row['profile_pic']; ?>">
                </a>
              </div>

              <div class="feed_post_author">
                <a href="<?php echo $profileLink?>">
                  <?php echo $row["username"]; ?>
                </a>
              </div>

              <div class="feed_post_time">
                <a href="<?php echo $post_viewPost_href; ?>">
                  <?php echo $row["date_time"]; ?>
                </a>
                <span class="material-icons icon">public</span>
              </div><br>

              <div class="feed_title">
                <?php echo $row["post_title"]; ?>
              </div><br>

              <div class="feed_content">
                <?php echo nl2br($row["post_content"]); ?>
              </div>
              <br>
              <!-- Only display image div if there is image. -->
              <?php if (isset($row["post_img"]) && file_exists($row["post_img"])): ?>
                <div class="feed_image">
                    <img src="<?php echo $row['post_img']; ?>" alt="<?php echo $row['post_img']; ?>">
                </div>
              <?php endif; ?><hr>

              <div class="feed_actions"><br>
                <!-- href="<?php echo $post_likeButton_href; ?>" -->
                  <a
                    href="Javascript:void(0)"
                    style="color:<?php echo $post_likeButton_color; ?>"
                    onclick="xml_likePost('<?php echo $post_fancyID; ?>', '<?php echo $js_likePostLink; ?>')"
                  >
                    <i class="material-icons">thumb_up</i><span><?php echo $post_likeCount; ?></span>
                  </a>
                  <a href="<?php echo $post_viewPost_href; ?>">
                    <span class="material-icons" style="color: #262626;">mode_comment</span>
                    <span style="color:black;"><?php echo $post_commentCount; ?></span>
                  </a>
                  <a href="#">
                    <span class="material-icons" style="color: #262626;">share</span>
                  </a>
              </div><br><br><br><hr>
                <!-- COMMENT BOX HOLDER -->
              <div class="create_comment_wrapper" style="margin:auto;text-align: center;">
                <form class="form_addComment" action="handleAddComment.php" method="POST">
                  <!-- <div class="addComment_title"> <h2>Add Comment</h2> </div> -->
                  <textarea name="post_comment" rows="5" cols="68" placeholder=" Write a comment..."></textarea><br>
                  <input type="submit" name="subm_addComment" class="btn-primary" value="Comment">
                  <input type="hidden" name="post_id" value="<?php echo $_GET["id"]; ?>">
                </form>
              </div>
              <br><br><hr>
              <!-- COMMENT HOLDER -->
              <?php
                $pdo_getComments = $pdo->prepare("SELECT view_comments.*,
                    DATE_FORMAT(comment_time, '%M %d %Y, %H:%i:%s') AS formatted_comment_time
                  FROM view_comments
                  WHERE post_id = :post_id
                  ORDER BY comment_time DESC");
                $pdo_getComments->execute(['post_id' => $decodedID]);
                $arr_comments = $pdo_getComments->fetchAll(PDO::FETCH_ASSOC);
              ?>
              <div class="comment-wrapper">

                <?php if (empty($arr_comments)):?>

                  <div class="comment-wrapper_noComments">
                    <h7>Be the first one to comment</h7>
                  </div>

                <?php else: ?>

                  <?php foreach ($arr_comments as $row): ?>
                    <?php
                      $profileIDHolder = $hashId->encode($row["user_id"]);
                      $profileLink = "viewProfile.php?id=$profileIDHolder";
                     ?>

                    <div class="comment-dp">
                      <a href="<?php echo $profileLink?>">
                        <img  src="<?php echo $row['profile_pic']; ?>" alt="userPic">
                      </a>
                    </div>
                    <div class="dialogbox">
                      <div class="body-box">
                        <div class="user-comment"><br style="content: ""; margin: 0em; display: block;">
                          <span>
                            <strong>
                              <a href="<?php echo $profileLink?>"><?php echo $row["username"]; ?></a>
                            </strong>
                            <i style="font-size: 10px;"> <?php echo " ".$row["formatted_comment_time"]; ?> </i>
                          </span>
                        </div><br>
                        <div class="content-comment">
                          <span><?php echo $row['comment_content']; ?> </span>
                        </div>
                      </div>
                    </div>

                  <?php endforeach; ?>

                <?php endif; ?>

              </div>

            </div>

          </div>

        </main>

       <?php include_once("inc/footer.php"); ?>

      </div>

   </body>

 </html>
