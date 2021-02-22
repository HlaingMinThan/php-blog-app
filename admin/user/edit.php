<?php
require "../../config/common.php";
require "../../config/config.php";
if(!$_SESSION["user_id"] && !$_SESSION["logged_in"]){
  header("location:login.php");
}

$user_id=$_GET['id'];
$statement=$pdo->prepare("select * from users where id=?");
$statement->execute([$user_id]);
$editUser=$statement->fetch(PDO::FETCH_OBJ);
if($_POST){
  $statement=$pdo->prepare("select * from users where email=? and id!=$editUser->id");
  $statement->execute([$_POST['email']]);
  $user=$statement->fetch(PDO::FETCH_ASSOC);
  if($user){
   
      $emailError="User email already exist";
    
  }else{
    if(empty($_POST['name']) || empty($_POST['email'])){
      if(empty($_POST['name'])){
        $nameError="name is required";
      }
      if(empty($_POST['email'])){
        $emailError="email is required";
      }
    }else{

      if($_POST['password']){
        if(strlen($_POST['password'])<6){
          $passwordError="password must me at least 6 character";
        }else{

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
        }
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
              <input type="hidden" name="_token" value="<?=empty($_SESSION['_token'])?'':$_SESSION['_token'];?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?=$editUser->name;?>">
                    <p class="text-danger"><?=empty($nameError)?'':$nameError;?></p>
                  </div>
                  <div class="form-group">
                    <label for="email">email</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?=$editUser->email;?>">
                    <p class="text-danger"><?=empty($emailError)?'':$emailError;?></p>
                  </div>
                  <div class="form-group">
                    <label for="password">new password</label>
                    <input type="text" class="form-control" id="password" name="password">
                    <p class="text-danger"><?=empty($passwordError)?'':$passwordError;?></p>
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