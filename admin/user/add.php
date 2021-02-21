<?php
session_start();
if(!$_SESSION["user_id"] && !$_SESSION["logged_in"]){
  header("location:login.php");
}
require "../../config/config.php";
if($_POST){
  $statement=$pdo->prepare("select * from users where email=?");
  $statement->execute([$_POST['email']]);
  $user=$statement->fetch(PDO::FETCH_ASSOC);
  if($user){
   
      $emailError="user email already exists";
    
  }else{
    if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])){
      if(empty($_POST['name'])){
        $nameError="name is required";
      }
      if(empty($_POST['email'])){
        $emailError="email is required";
      }
      if(empty($_POST['password'])){
        $passwordError="password is required";
      }
      
    }else{
      if(strlen($_POST['password'])<6){
        $passwordError="password must me at least 6 character";
      }else{

        $sql="insert into users (name,email,password,role) values (?,?,?,?)";
        $statement=$pdo->prepare($sql);
        $post=[
          $_POST['name'],
          $_POST['email'],
          $_POST['password'],
          $_POST['role']
        ];
        $statement->execute($post);
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
            <h1 class="m-0 text-dark">Create User</h1>
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
            <form  action="add.php" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">name</label>
                    <input type="text" class="form-control" id="name" name="name">
                    <p class="text-danger"><?=empty($nameError)?'':$nameError;?></p>
                  </div>
                  <div class="form-group">
                    <label for="email">email</label>
                    <input type="text" class="form-control" id="email" name="email">
                    <p class="text-danger"><?=empty($emailError)?'':$emailError;?></p>
                  </div>
                  <div class="form-group">
                    <label for="password">password</label>
                    <input type="text" class="form-control" id="password" name="password">
                    <p class="text-danger"><?=empty($passwordError)?'':$passwordError;?></p>
                  </div>
                  <div class="form-group">
                    <label for="password">role</label>
                    <select name="role" id="" class="form-control">
                      <option value="0">normal user</option>
                      <option value="1">admin</option>
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" class="btn btn-primary" value="add">
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