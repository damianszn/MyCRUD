<?php 
include 'partials/header.php';
$pdo = new PDO('sqlite:data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$data = $pdo->query("SELECT * FROM posts ORDER BY date DESC");
$existingPosts = $data->fetchAll();

$postsIndexesMin = 0;
$postsIndexesMax = 2;

?>
<div class="container" style="background-color:#e9ecef"><br>
    <?php echo(listOfPosts($existingPosts, $postsIndexesMin, $postsIndexesMax)); ?>
</div>

<?php include 'partials/footer.php';?>
