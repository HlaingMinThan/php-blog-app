<?php
require "./config/common.php";
require "./config/config.php";
if($_POST){
  $name=$_POST["name"];
  $email=$_POST["email"];
  $password=$_POST["password"];
  $statement=$pdo->prepare("select * from users where email=?");
  $statement->execute([$email]);
  $user=$statement->fetch(PDO::FETCH_ASSOC);
  if($user){
   
    $emailError='User email already exist';
    
  }else
  {
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
          password_hash($_POST['password'],PASSWORD_DEFAULT),
          0
        ];
        $statement->execute($post);
        header('location:index.php');
      }
    }
  }
}
?>
<?php require "./layout/header.php"; ?>

<div class="login-box mx-auto my-5">
  <div class="login-logo">
    <a href="../../index2.html">Blog Register</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">

      <form action="register.php" method="post">
        <input type="hidden" name="_token" value="<?=empty($_SESSION['_token'])?'':$_SESSION['_token'];?>">
        <p class="text-danger"><?=empty($nameError)?'':$nameError;?></p>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <p class="text-danger"><?=empty($emailError)?'':$emailError;?></p>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <p class="text-danger"><?=empty($passwordError)?'':$passwordError;?></p>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
       
          <div class="">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<?php require "./layout/footer.php"; ?>
