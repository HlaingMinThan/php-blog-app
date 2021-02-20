<?php
require "../../config/config.php";
$stmt=$pdo->prepare("delete from users where id=?");
$stmt->execute([$_GET['id']]);

header("location:index.php");