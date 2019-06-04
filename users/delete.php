<?php 
include '../partials/mini-header.php';

$pdo = new PDO('sqlite:../data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);
$data = $pdo->query("SELECT * FROM posts WHERE id=$postId");
$fetchedPost = $data->fetchAll();
$post = $fetchedPost[0];

$logged = $_SESSION['logged'] ?? false;
$username = $_SESSION['username'] ?? '';
$confirmation = $_GET['confirmation'];

$postId = $_GET['id'];

if($confirmation == "yes" && $logged == true){
    $query = $pdo->prepare("DELETE FROM posts WHERE id=$postId");
    $query->execute();
    header('Location: success.php?subject=suppression');
    exit();
}
?>
<?php if($confirmation == "no" && $logged == true): ?>
<div class="alert alert-danger" role="alert">
  <h4 class="alert-heading">Es-tu sûr de vouloir supprimer ce post?</h4>
  <hr>
  <p><?= $post['title'] ?></p>
  <pre><?= $post['article'] ?></pre>
  <a href="/users/delete.php?id=<?=$postId?>&confirmation=yes"><button type="button" class="btn btn-outline-danger">Supprimer</button></a>
</div>
<?php 
else :
    header('Location: ../index.php');
endif; 
include '../partials/footer.php';?>