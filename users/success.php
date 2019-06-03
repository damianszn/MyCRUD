<?php 
include '../partials/mini-header.php';
$subject = $_GET['subject'] ?? null;
$subject = ucfirst($subject);
?>
<?php if(isset($subject)): ?>
<div class="alert alert-primary" role="alert">
    <h4 class="alert-heading"><?=$subject;?> réussie !</h4>
    <hr>
    <button class="btn btn-primary" type="button" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Redirection dans quelques secondes...
    </button>
</div>
<?php else:?>
<div class="alert alert-danger" role="alert">
<button class="btn btn-danger" type="button" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Vous ne devriez pas être ici, redirection...
    </button>
</div>
</div>
<?php endif;?>
<?php 
header( "refresh:3;url=../index.php" );
include '../partials/footer.php';?>