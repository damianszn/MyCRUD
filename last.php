<?php 
include 'partials/header.php';

$pdo = connectDatabase();
$data = $pdo->query("SELECT * FROM posts ORDER BY date DESC");
$existingPosts = $data->fetchAll();

$postsIndexesMin = 0;
$postsIndexesMax = 2;

?>
<div class="container" style="background-color:#e9ecef"><br>
    <?php echo(listOfPosts($existingPosts, $postsIndexesMin, $postsIndexesMax)); ?>
</div>

<?php include 'partials/footer.php';?>
