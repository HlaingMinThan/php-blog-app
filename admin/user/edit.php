<?php
session_start();
if(!$_SESSION["user_id"] && !$_SESSION["logged_in"]){
  header("location:login.php");
}
require "../../config/config.php";
$user_id=$_GET['id'];
$statement=$pdo->prepare("select * from users where id=?");
$statement->execute([$user_id]);
$editUser=$statement->fetch(PDO::FETCH_OBJ);
if($_POST){
  $statement=$pdo->prepare("select * from users where email=? and id!=$editUser->id");
  $statement->execute([$_POST['email']]);
  $user=$statement->fetch(PDO::FETCH_ASSOC);
  if($user){
   
      echo "<script>alert('User email already exist')</script>";
    
  }else{
    if($_POST['password']){
      $sql="update users set name=?,email=?,password=?,role=? where id=?";
      $statement=$pdo->prepare($sql);
      $user=[
        $_POST['name'],
        $_POST['email'],
        $_POST['password'],
        $_POST['role'],
        $user_id
      ];
      $statement->execute($user);
      header('location:index.php');
    }else{
      $sql="update users set name=?,email=?,role=? where id=?";
      $statement=$pdo->prepare($sql);
      $user=[
        $_POST['name'],
        $_POST['email'],
        $_POST['role'],
        $user_id
      ];
      $statement->execute($user);
      header('location:index.php');
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
            <h1 class="m-0 text-dark">update user</h1>
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
            <form  action=""  method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?=$editUser->name;?>">
                  </div>
                  <div class="form-group">
                    <label for="email">email</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?=$editUser->email;?>">
                  </div>
                  <div class="form-group">
                    <label for="password">new password</label>
                    <input type="text" class="form-control" id="password" name="password">
                  </div>
                  <div class="form-group">
                    <label for="password">role</label>
                    <select name="role" id="" class="form-control">
                      <option value="0" <?=$editUser->role==0? 'selected' :''?>>normal user</option>
                      <option value="1"<?=$editUser->role==1? 'selected' :''?>>admin</option>
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" class="btn btn-primary" value="update">
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