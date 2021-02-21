<?php
session_start();
require "./config/config.php";
if($_POST){
  if(empty($_POST['email']))$emailError="email is required";
  if(empty($_POST['password']))$passwordError="password is required";
  $email=$_POST["email"];
  $password=$_POST["password"];
  $statement=$pdo->prepare("select * from users where email=?");
  $statement->execute([$email]);
  $user=$statement->fetch(PDO::FETCH_ASSOC);
  if($user){
    if($user["password"]===$password){
      $_SESSION["user_id"]=$user["id"];
      $_SESSION["username"]=$user["name"];
      $_SESSION["logged_in"]=time();
      $_SESSION["role"]=$user["role"];
      header("Location: index.php");
    }else{
      echo "<script>alert('Not match credentials')</script>";
    }
  }else
  {
    $emailError="email doesn't exits";
  }
}
?>
<?php require "./layout/header.php"; ?>

<div class="login-box mx-auto my-5">
  <div class="login-logo">
    <a href="../../index2.html">Blog Login</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="login.php" method="post">
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
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            <a href="./register.php" class="btn btn-block btn-success">
            Register
            </a>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<?php require "./layout/footer.php"; ?>
