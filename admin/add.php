<?php

require "../config/common.php";
require "../config/config.php";
if($_SESSION["user_id"] && $_SESSION["logged_in"]&& $_SESSION["role"]!=1){
  header("location:login.php");
}

if($_POST){
  
  if(empty($_POST['title']) || empty($_POST['content']) ||empty($_FILES['image']['name'])){
    if(empty($_POST['title'])){
      $titleError="title is required";
      // die($titleError);
    }
    if(empty($_POST['content'])){
      $contentError="content is required";
      // die($contentError);
    }
    if(empty($_FILES['image']['name'])){
      $imgError="img is required";
      // die($imgError);
    }else{
      $imageType=pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
      if($imageType!=="png" ||  $imageType!=="jpg"|| $imageType!=="jpeg"){
        // die($imageType);
        $imgError="img should be png ,jpg or jpeg";
      }
    }
  }else{
    $imgName=$_FILES['image']['name'];
    $to="images/$imgName";
    $imageType=pathinfo($to,PATHINFO_EXTENSION);//pathinfo fun is getting info of the file from whole path
    if($imageType==="png" ||  $imageType==="jpg"|| $imageType==="jpeg"){
      $from=$_FILES['image']['tmp_name'];
      move_uploaded_file($from,$to);
      $sql="insert into posts (title,content,image,author_id) values (?,?,?,?)";
      $statement=$pdo->prepare($sql);
      $post=[
        $_POST['title'],
        $_POST['content'],
        $imgName,
        $_SESSION['user_id']
      ];
      $statement->execute($post);
      header('location:index.php');
    }else{
      $imgError="img should be png ,jpg or jpeg";
    }
  }
  
}
?>

<?php require "layout/header.php"; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Create Blog</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
            <form  action="add.php" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="_token" value="<?=empty($_SESSION['_token'])?'':$_SESSION['_token'];?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title">
                    <p class="text-danger"><?=empty($titleError)?'':$titleError;?></p>
                  </div>
                  <div class="form-group">
                    <label for="content">Content</label>
                   <textarea  class="form-control" id="" cols="30" rows="10" name="content"></textarea>
                   <p class="text-danger"><?=empty($contentError)?'':$contentError;?></p>
                  </div>
                  <div class="form-group">
                    <label for="image">Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image">Choose file</label>
                      </div>
                    </div>
                    <p class="text-danger"><?=empty($imgError)?'':$imgError;?></p>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" class="btn btn-primary" value="add post">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</div>
<?php require "layout/footer.php"; ?>