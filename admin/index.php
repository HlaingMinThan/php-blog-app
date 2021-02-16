<?php
session_start();
if(!$_SESSION["user_id"] && !$_SESSION["logged_in"]){
  header("location:login.php");
}
require "../config/config.php";
?>

<?php require "layout/header.php"; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Blogs</h1>
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
            <a href="add.php" class="btn btn-success mb-3">Add Blog</a>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Bordered Table</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>title</th>
                      <th>content</th>
                      <th colspan="2">actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        $statement=$pdo->prepare("select * from posts order by id desc");
                        $statement->execute();
                        $posts=$statement->fetchAll(PDO::FETCH_OBJ);
                    ?>
                    <?php 
                      if($posts)
                      {
                        foreach($posts as $post): 
                    ?>
                      <tr>
                        <td><?=$post->id;?></td>
                        <td><?=$post->title;?></td>
                        <td><?=substr($post->content,0,100)."...";?></td>
                        <td>
                          <a href="edit.php?id=<?=$post->id; ?>" class="btn btn-warning">Edit</a>
                        </td>
                        <td>
                          <a href="destroy.php?id=<?=$post->id; ?>" class="btn btn-danger" onclick="return confirm('are u sure want to delete');">Delete</a>
                        </td>
                      </tr>
                    <?php 
                        endforeach;
                      }
                    ?>
                    
                  </tbody>
                </table>
              </div>
            </div> 
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
 
    <?php require "layout/footer.php"; ?>