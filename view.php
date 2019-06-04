<?php
include 'partials/header.php';

$pdo = connectDatabase();
$data = $pdo->query("SELECT * FROM posts WHERE id=$postId");
$fetchedPost = $data->fetchAll();
$post = $fetchedPost[0];

$username = $_SESSION['username'] ?? '';

$postId = $_GET['id'];

$src = $postId.$post['imageExt'];
?>

<div class="card text-center">
    <div class="card-header">
        <h4 class="card-title"><?= $post['title']; ?></h4>
    </div>
    <div class="card-body">
        <?php if($post['link'] != ''): ?>
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="<?= $post['link'] ?>" allowfullscreen></iframe>
        </div>
        <?php else: ?>
        <img style='width:30vw' src='/users/images/<?= $src ?>' class="card-img-top rounded mx-auto d-block"><br>
        <?php endif; ?>
        <br>
        <pre class="card-text"><?= $post['article']; ?></pre>
        <?php if($post['link'] != ''): ?>
            <?php if(postDetails($post) != null): ?>
            <div class="card mb-3" style="width:60vw;margin:auto;">
            <div class="row no-gutters">
                <div class="col-md-4">
                <img src="/users/images/<?= $src ?>" class="card-img" alt="<?= $post['imageSource'] ?>" style='height:100%;'>
                </div>
                <?= postDetails($post); ?>
            </div>
            </div>
            <?php endif;?>
        <?php else: ?>    
            <?php if(postDetails($post) != null): ?>
            <div class="card" style="width:60vw;margin:auto;">
            <div>
                <?= postDetailsNoPic($post); ?>
            </div>
            </div>
            <?php endif;?>
        <?php endif;?>    
    </div>
    <a href="genres.php?genre=<?= $post['genre'] ?>&page=1" class="btn btn-primary" style="width:15vw;margin:auto;">Voir posts similaires</a>
    <br><br>

    <?php if($username == $post['author']): ?>
    <div class="card-footer text-muted">
        <p>Vous l'avez créé le <?= $post['date'] ?>.<a href="users/delete.php?id=<?= $post['id'] ?>&confirmation=no" style="color:red;"> Supprimer ?</a></p> 
    </div>
    <?php else: ?>
    <div class="card-footer text-muted">
        <p>Créé le <?= $post['date'] ?> par <?= $post['author'] ?></p> 
    </div>
    <?php endif; ?>
</div>

<?php include 'partials/footer.php';?>