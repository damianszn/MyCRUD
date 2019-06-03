<?php 
include 'partials/header.php';
$loggedStatus = $_SESSION['logged'] ?? '';
$disconnecting = $_GET['disconnect'] ?? '';
$username = $_SESSION['username'] ?? '';

if($disconnecting == true){
  $_SESSION = array();
  unset($_GET['disconnect']);
  unset($disconnecting);
  header("Location: index.php");
} 

$pdo = new PDO('sqlite:data.db', null, null, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$data = $pdo->query("SELECT * FROM posts ORDER BY date ASC LIMIT 3");
$lastPosts = $data->fetchAll();
?>

<?php if($loggedStatus === true): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    Re <strong><?php echo($username); ?></strong>, merci d'être actif !
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php else: ?>
<div class="jumbotron">
    <h1 class="display-5">Le média de la Rime.</h1>
    <p class="lead" >Cette platforme est là pour valoriser et partager les artistes qui en ont dans la plume. <br>Phases, rimes et belles phrases au menu.</p>
    <hr class="my-4">
    <p>Explore ou présente-toi.</p>
    <a class="btn btn-primary btn" href="users/register.php" role="button">Inscription</a>
    <a class="btn btn-primary btn" href="users/login.php" role="button">Connexion</a>
</div>
<?php endif;?>
<br>
<div class="container">
  <div class="bd-example" style="width: 100%; margin: auto;">
    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <a href="view.php?id=<?= $lastPosts[0]['id']; ?>">
              <div class="card" style="width: 60vw; margin: auto;">
                <img src="/users/images/<?= $lastPosts[0]['id'].$lastPosts[0]['imageExt'] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                  <pre class="card-text"><?= $lastPosts[0]['article'] ?></pre>
                </div>
              </div>
            </a>
          </div>
          <div class="carousel-item">
            <a href="view.php?id=<?= $lastPosts[1]['id']; ?>">
              <div class="card" style="width: 60vw; margin: auto;">
                <img src="/users/images/<?= $lastPosts[1]['id'].$lastPosts[1]['imageExt'] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                  <pre class="card-text"><?= $lastPosts[1]['article'] ?></pre>
                </div>
              </div>
            </a>
          </div>
          <div class="carousel-item">
            <a href="view.php?id=<?= $lastPosts[2]['id']; ?>">
              <div class="card" style="width: 60vw; margin: auto;">
                <img src="/users/images/<?= $lastPosts[2]['id'].$lastPosts[2]['imageExt'] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                  <pre class="card-text"><?= $lastPosts[2]['article'] ?></pre>
                </div>
              </div>
            </a>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev" style="filter: invert(100%);">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next" style="filter: invert(100%);">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
    </div>
  </div>
</div>
<br>
<?php include 'partials/footer.php';?>
