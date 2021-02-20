<?php 
require "./layout/header.php";
session_start();
if(!$_SESSION["user_id"] && !$_SESSION["logged_in"]){
header("location:login.php");
}
?>
<?php require "./config/config.php"; ?>

            <h1 class="text-center mb-5">Blog Website</h1>
            <div class="text-center">
            <a href="logout.php" class="btn btn-primary mb-5">Logout</a>
            </div>
            <div class="container">
            <div class="row ">
            <?php 
                // pagination
                // check pageno exist or not
                if(isset($_GET['pageno'])) 
                {
                $pageno=$_GET['pageno'];
                }
                else{
                $pageno=1;
                }
                $recordsPerPage=4;
                $offset=($pageno-1)*$recordsPerPage;
                $stmt=$pdo->prepare("select * from posts order by id desc limit $offset,$recordsPerPage");
                $stmt->execute();
                $posts=$stmt->fetchAll(PDO::FETCH_OBJ);
                // total pages
                $statement=$pdo->prepare('select count(*) from posts');
                $statement->execute();
                $result=$statement->fetch();
                $totalposts=$result[0];
                $totalPages=ceil($totalposts/$recordsPerPage);
                        
                    

                    
            if($posts)
            {
                foreach($posts as $post): 
            ?>
                <div class="col-sm-6">
                    <div class="card">
                    <div class="card-body">
                        <h2 class="text-center"><?=$post->title;?></h2>
                        <img src="./admin/images/<?=$post->image;?>" width="300px">
                        <p class="card-text"><?=substr($post->content,0,100)?></p>
                        <a href="show.php?id=<?=$post->id;?>" class="btn btn-primary">Read More...</a>
                    </div>
                    </div>
                </div>
            
            <?php 
                endforeach;
                }
            ?>
            </div>
             <!-- pagination -->
             <nav aria-label="Page navigation example">
                <ul class="pagination">
                <li class="page-item <?php echo $pageno<=1 ? 'disabled' :'' ;?>">
                    <a class="page-link" href='<?=$pageno<=1? "#":"?pageno=".$pageno-1;  ?>'>Prev</a>
                </li>
                <?php  foreach(range(1,$totalPages) as $page):?>
                    <li class="page-item  <?php echo $page==$pageno ? 'disabled' : '';?>"><a class="page-link" href="?pageno=<?=$page;?>"><?=$page;?></a></li>
                <?php endforeach; ?>
                <li class="page-item <?php echo $pageno>=$totalPages ? 'disabled' :'' ;?>">
                    <a class="page-link" href='<?=$pageno>=$totalPages? "#":"?pageno=".$pageno+1;  ?>'>Next</a>
                </li>
                </ul>
            </nav>
<?php require "./layout/footer.php"; ?>