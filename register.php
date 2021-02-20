<?php
session_start();
require "./config/config.php";
if($_POST){
  $name=$_POST["name"];
  $email=$_POST["email"];
  $password=$_POST["password"];
  $statement=$pdo->prepare("select * from users where email=?");
  $statement->execute([$email]);
  $user=$statement->fetch(PDO::FETCH_ASSOC);
  if($user){
   
      echo "<script>alert('User email already exist')</script>";
    
  }else
  {
    $sql="insert into users (name,email,password) values (?,?,?)";
    $statement=$pdo->prepare($sql);
    $statement->execute([
        $_POST['name'],
        $_POST['email'],
        $_POST['password']
      ]);
    header('location:index.php');
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
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
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
