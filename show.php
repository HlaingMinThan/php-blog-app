<?php 
    require "./config/common.php";
    require "./config/config.php"; 
    if(!$_SESSION["user_id"] && !$_SESSION["logged_in"]){
        header("location:login.php");
    }
    require "./layout/header.php"; 

    $post_id=$_GET['id'];
    $statement=$pdo->prepare("select * from posts where id=?");
    $statement->execute([$post_id]);
    $post=$statement->fetch(PDO::FETCH_OBJ);

    $post_id=$_GET['id'];
    $statement=$pdo->prepare("select * from comments where post_id=?");
    $statement->execute([$post_id]);
    $comments=$statement->fetchAll(PDO::FETCH_OBJ);

    if($_POST){
        $comment=$_POST['content'];
        if(empty($comment))$commentError="comment is required";
        else{
            $sql="insert into comments (post_id,content,author_id) values (?,?,?)";
            $statement=$pdo->prepare($sql);
            $comment=[
            $post_id,
            $comment,
            $_SESSION['user_id']
            ];
            $statement->execute($comment);
            header("location:show.php?id=$post_id");
        }
    }

?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <div class="card">
                <h3 class="text-center text-primary mt-3"><?=escape($post->title);?></h3>
                <img class=" img-fluid mx-auto my-5" src="./admin/images/<?=$post->image;?>" alt="Card image cap" width="500px">
                <div class="card-body">
                    <p class="card-text"><?=escape($post->content);?></p>
                </div>
                </div>
            </div>
        </div>
        <div class="comment">
            <h3 class="ml-3">Blog Comments</h3>
            <ul class="list-group list-group-flush">
                <?php foreach($comments as $comment): ?>
                <?php
                    $stmt=$pdo->prepare("select name from users where id=?");
                    $stmt->execute([$comment->author_id]);
                    $result=$stmt->fetch();
                    $username=$result['name'];
                ?>
                <li class="list-group-item">
                    <h4 class="d-inline"><?=escape($username);?></h4><span class="text-md text-secondary ml-3"><?=escape($comment->created_at);?></span>
                    <p class="mt-3"><?=escape($comment->content);?></p>
                </li>
                <?php endforeach; ?>
                <form action="" class="mb-5" method="post">
                    <input type="hidden" name="_token" value="<?=empty($_SESSION['_token'])?'':$_SESSION['_token'];?>">
                    <div>
                    <p class="text-danger"><?=empty($commentError)?'':$commentError;?></p>
                    <input type="text" class="form-control" name="content" placeholder="comment here">
                    <a href="index.php" class="mt-4 btn btn-default">back</a>
                    </div>
                </form>
            </ul>
        </div>
    </div>
<?php require "./layout/footer.php"; ?>