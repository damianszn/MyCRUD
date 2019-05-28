<?php 
include '../partials/mini-header.php';
if(isset($_GET['subject'])){
    $subject = ucfirst($_GET['subject']);
}
header( "refresh:3;url=../index.php" );
?>
<?php if(!empty($subject)): ?>
<div class="alert alert-primary" role="alert">
    <h4 class="alert-heading"><?php echo($subject);?> réussie !</h4>
    <hr>
    <p class="mb-0">Redirection dans quelques secondes...</p>
    <br>
    <div class="spinner-grow text-primary" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<?php else:?>
<div class="alert alert-danger" role="alert">
<p>Vous ne devriez pas être ici, redirection...</p><div class="spinner-grow text-danger" role="status">
  <span class="sr-only">Loading...</span>
</div>
</div>
<?php endif;?>
<?php include '../partials/footer.php';?>