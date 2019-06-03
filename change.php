<?php 
include 'partials/header.php';
$user = $_SESSION['username'];
$thisPost = $_GET['id'] ?? '';

$pdo = new PDO('sqlite:data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$data = $pdo->query("SELECT * FROM posts WHERE author='$user' ORDER BY date ASC");
$userPosts = $data->fetchAll();
?>

<?php if($thisPost == ''): ?>
<div class="container-fluid">
    <div class="card-body">
        <div class="list-group">
            <?php foreach($userPosts as $userPost): ?>
            <a href="view.php?id=<?= $userPost['id'] ?>" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"><?= $userPost['title'] ?></h5>
                <small><?= $userPost['date'] ?></small>
            </div>
            <p class="mb-1"><?= $userPost['article'] ?></p>
            <small><?= $userPost['artistName'] ?></small>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif;?>


<?php include 'partials/footer.php';?>