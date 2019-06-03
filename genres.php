<?php
include 'partials/header.php';

$pdo = new PDO('sqlite:data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$showGenres = false;

if($genre != ''){ //created in header

    $data = $pdo->query("SELECT * FROM posts WHERE genre='$genre' ORDER BY date ASC");
    $postsByGenre = $data->fetchAll();
    $numberOfPosts = count($postsByGenre);
    $numberOfPages = pagesByPosts($numberOfPosts);

    $page = $_GET['page'] ?? '';
    $postsIndexesMax = ($page*5)-1;
    if($page == 1){
        $postsIndexesMin = 0;
    } else {
        $postsIndexesMin = $postsIndexesMax - 4;
    }

} else {
    $showGenres = true;
}
?>

<?php if($showGenres): ?>
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Genres</h1>
    <p class="lead">Pour les passionés aux goûts précis.</p>
  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Découpeurs</h5>
        <p class="card-text">Rythmes précis et maîtrise des temps, le genre qu'on redécouvre à chaque écoute.</p>
        <a href="genres.php?genre=decoupeur&page=1" class="btn btn-primary">Afficher</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Mélodieux</h5>
        <p class="card-text">Equilibre entre la poésie et la musique, le genre qu'on a en tête pendant des semaines.</p>
        <a href="genres.php?genre=melodieux&page=1" class="btn btn-primary">Afficher</a>
      </div>
    </div>
  </div>
</div><br>
<?php else: ?>
<div class="container-fluid" style="background-color:#e9ecef"><br>
  <?php echo(listOfPosts($postsByGenre, $postsIndexesMin, $postsIndexesMax)); ?>
</div><br>
<nav>
  <ul class="pagination pagination justify-content-center">
    <li class="page-item <?= ($page == '1') ? 'disabled' : '' ;?>">
      <a class="page-link" href="/genres.php?genre=<?= $genre ?>&page=<?= $page-1;?>" aria-disabled="true">Précédents</a>
    </li>
    <?php for($i = 1;$i <= $numberOfPages; $i++): ?>
        <li class="page-item <?= $i == $page ? 'active' : ''?>"><a class="page-link" href="/last.php?page=<?= $i ?>"><?= $i ?></a></li>
    <?php endfor;?>
    <li class="page-item <?= ($page == $numberOfPages) ? 'disabled' : '' ;?>">
      <a class="page-link" href="/genres.php?genre=<?= $genre ?>&page=<?= $page+1;?>">Suivants</a>
    </li>
  </ul>
</nav>
<?php endif; ?>

<?php include 'partials/footer.php';?>
