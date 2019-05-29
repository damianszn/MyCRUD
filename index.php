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
?>

<?php if($loggedStatus === true): ?>
  <div class="jumbotron">
  <h1 class="display-5">Re <?php echo($username); ?>!</h1>
  <p class="lead">Tu as raté ... nouveaux partages.</p>
</div>
<?php else: ?>
<div class="jumbotron">
    <h1 class="display-5">Le média de la Rime.</h1>
    <p class="lead">Cette platforme est là pour valoriser et partager les artistes qui en ont dans la plume. <br>Phases, rimes et belles phrases au menu.</p>
    <hr class="my-4">
    <p>Explore ou présente-toi.</p>
    <a class="btn btn-primary btn" href="users/register.php" role="button">Inscription</a>
    <a class="btn btn-primary btn" href="users/login.php" role="button">Connexion</a>
</div>
<?php endif;?>

<?php include 'partials/footer.php';?>
