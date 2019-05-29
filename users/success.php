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
<?php include '../partials/footer.php';?>