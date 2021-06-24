<?php

  //Get database and session.
  include_once("inc/database.php");

  //Prevent random access.
  if (!isset($_SESSION["account_id"])) {
    header("location: ../");
    exit();
  }

  //This form also works as a post editor.
  //When using this page to *add posts*, this will stay false.
  $editMode = false;
  $containerTitle = "Create Post";

  //Session ID.
  $s_id = $_SESSION["account_id"];

  //If "e" is in the URL, this page will read that.
  if (isset($_GET["e"])) {
    $editMode = true;
    $containerTitle = "Edit Post";
    $p_id = $_GET["e"];
    $p_id = $hashId->decode($p_id);
    $p_id = $p_id[0];

    //A bit redundant, but verify the post id.
    $checkID = $pdo->prepare("SELECT verify_post_id_exists(:post_id)");
    $checkID->execute(["post_id" => $p_id]);
    $checkID = $checkID->fetch(PDO::FETCH_COLUMN);

    if ($checkID === 0) {
      header("location: ../");
      exit();
    }

    //Verify if the user editing is the owner of the post.
    //Forgot to make this part of the verify_post_id_exists function.
    $checkUser = $pdo->prepare("SELECT count(user_id) AS confirmvalid
      FROM view_posts_full
      WHERE post_id = :post_id
      AND user_id = :user_id");
    $checkUser->execute([
      "post_id" => $p_id,
      "user_id" => $s_id
    ]);
    $checkUser = $checkUser->fetch(PDO::FETCH_COLUMN);

    if($checkUser === 0){
      header("location: ../");
      exit();
    }
  }
  //Prefetch User data.
  $pdoq_getUserData = $pdo->prepare("SELECT * FROM view_user_stats WHERE user_id = :user_id");
  $pdoq_getUserData->execute(['user_id' => $_SESSION["account_id"]]);
  $user_dataArray = $pdoq_getUserData->fetch(PDO::FETCH_ASSOC);
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title> <?php echo $user_dataArray['username']; ?> | Create Post</title>

     <!-- Import Material Design Lite CSS -->
     <link rel="stylesheet" href="../mdl/material.min.css">
     <!-- Import Material Design Lite Javascript -->
     <script src="../mdl/material.min.js" charset="utf-8"></script>
     <!-- Import Material Design Icons from Google -->
     <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
     <!-- Backup for <dialog> not being supported by browser -->
     <script src="../vendor/dialog-polyfill/dist/dialog-polyfill.js" charset="utf-8"></script>

     <!-- Shortcut Icon -->
     <link rel="shortcut icon" href="images/assets/sample2.png">

     <!-- Custom CSS File -->
     <!-- <link rel="stylesheet" type="text/css" href="../css/profileStyles.css"> -->
     <link rel="stylesheet" type="text/css" href="../css/tmp.css">
     <link rel="stylesheet" href="../css/scrollbar.css">

     <!-- Custom Create Post Javascript -->
     <script type="text/javascript">
      let loadFile = function(event) {
        let image = document.getElementById('js_previewImage');
        image.src = URL.createObjectURL(event.target.files[0]);
      };

      let updateUploadButton = function(divId){
        let txtfield = document.getElementById(divId);
        txtfield.innerText = "1 Photo Uploaded";
      }
     </script>

     <!-- Other Javascript stuff -->
     <script src="ajax/xmlhttp.js" charset="utf-8"></script>
   </head>

   <!-- MDL Error Dialog support. -->
   <body>

     <?php //Error Handler. ?>
     <?php include_once("inc/_js_mdl_formAlert.php"); ?>

      <style>
      @import url('https://fonts.googleapis.com/css2?family=Staatliches&display=swap');
        .demo-layout-transparent {
          /* REPLACE THIS IMAGE WITH A BETTER BACKGROUND */
          /*background: url('php/images/assets/test (1).jpg') center / cover;*/
          background: #ad5389;  /* fallback for old browsers */
          background: -webkit-linear-gradient(#21094e, #6148bf);  /* Chrome 10-25, Safari 5.1-6 */
          background: linear-gradient(#21094e, #6148bf); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }
        .demo-layout-transparent .mdl-layout__header,
        .demo-layout-transparent .mdl-layout__drawer-button {
          /* This background is dark, so we set text to white. Use 87% black instead if
             your background is light. */
          color: #fff;
        }
      </style>

      <div class="demo-layout-transparent mdl-layout mdl-js-layout">
        <!-- Navbar is too long, and is repeated in all pages so it is moved to a dedicated file. -->
        <?php include_once("inc/navbar.php"); ?>

       <main class="mdl-layout__content">

         <div class="page-content">

            <div class="create-post">

              <div id="text-area">

                <div>
                  <a href="../"><span class="material-icons left">close</span></a>
                  <h4 class="centered"><strong><?php echo $containerTitle; ?></strong></h4><hr>
                </div>


                <div class="feed_userpic">
                  <img src="<?php echo $user_dataArray['profile_pic']; ?>">
                </div><br>

                <div class="feed_post_author">
                  <a href="profile.php">
                    <?php echo $user_dataArray['username']; ?>
                  </a>
                </div>
                <?php if(!$editMode): ?>
                  <!--
                    ADD POST.
                  -->
                  <form action="handleCreatePost.php" method="POST" enctype="multipart/form-data">

                    <input type="text" name="inputTitle" id="title-bar" placeholder="Title" required>
                      <br>
                    <textarea name="inputText" rows="5" cols="50" placeholder="What's on your mind, <?php echo $user_dataArray['username']; ?>?"></textarea>


                    <!-- IMAGE PREVIEW -->
                    <div id="post_uploadImagePreview">
                      <img id="js_previewImage">
                    </div><br>

                    <input type="file" id="actual-btn" name="inputPic" onchange="updateUploadButton('js_pic_count');loadFile(event)" hidden/>
                    <label for="actual-btn">
                      <span class="material-icons icon">photo</span>
                      <span id="js_pic_count">Upload Photo (Optional)</span>
                    </label>
                    <input type="submit" name="btnSubmit" class="btn-primary" value="Post">

                  </form>
                <?php else: ?>
                  <!--
                    EDIT POST
                  -->
                  <?php
                    //Prepare data.
                    $postData = $pdo->prepare("SELECT * FROM view_posts_full WHERE post_id = :post_id AND user_id = :user_id");
                    $postData->execute(["post_id" => $p_id, "user_id" => $s_id]);
                    $postData = $postData->fetch(PDO::FETCH_ASSOC);
                    $hasImage = (isset($postData["post_img"]) && file_exists($postData["post_img"]));
                   ?>
                   <form action="Javascript:void(0)" method="POST" enctype="multipart/form-data" id="formEditPost">

                     <input type="text" name="inputTitle" id="title-bar" value="<?php echo $postData['post_title']; ?>" required>
                       <br>
                     <textarea name="inputText" rows="5" cols="50"><?php echo $postData['post_content']; ?></textarea>


                     <!-- IMAGE PREVIEW -->
                     <div id="post_uploadImagePreview">
                       <img id="js_previewImage"
                       <?php if($hasImage): ?>
                         src="<?php echo $postData['post_img']; ?>"
                       <?php endif; ?>
                       >
                     </div><br>

                     <input type="file" id="actual-btn" name="inputPic" onchange="updateUploadButton('js_pic_count');loadFile(event)" hidden/>
                     <label for="actual-btn">
                       <span class="material-icons icon">photo</span>
                       <span id="js_pic_count">
                         <?php if ($hasImage): ?>
                           Replace Picture (Optional)
                         <?php else: ?>
                           Upload Picture (Optional)
                         <?php endif; ?>
                       </span>
                     </label>
                     <input type="submit" name="btnSubmit" class="btn-primary" value="Post">
                     <input type="hidden" name="encodedPostID" value="<?php echo $_GET["e"]; ?>">
                   </form>

                   <script type="text/javascript">
                     xml_submitEditPost('formEditPost', 'ajax/xmlhttp_editPost.php');
                   </script>

                <?php endif; ?>

              </div>

            </div>

           </div>

         </div>

       </main>

       <?php include_once("inc/footer.php"); ?>

      </div>

   </body>

 </html>
