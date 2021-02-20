<?php
session_start();
if(!$_SESSION["user_id"] && !$_SESSION["logged_in"]){
  header("location:login.php");
}
require "../config/config.php";
if($_POST){
 
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
    echo "<script>alert('Wrong Image format alert')</script>";
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
                <div class="card-body">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title">
                  </div>
                  <div class="form-group">
                    <label for="content">Content</label>
                   <textarea  class="form-control" id="" cols="30" rows="10" name="content"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="image">Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image">Choose file</label>
                      </div>
                    </div>
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