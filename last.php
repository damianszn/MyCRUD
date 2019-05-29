<?php 
include 'partials/header.php';
$pdo = new PDO('sqlite:data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$data = $pdo->query("SELECT * FROM posts ORDER BY date DESC");
$existingInputs = $data->fetchAll();

$numberOfPosts = count($existingInputs);
$numberOfPages = ($numberOfPosts>5) ? ($numberOfPosts/5) : 1;

// 5 posts per page
$page = $_GET['page'] ?? '';
$postsIndexesMax = ($page*5)-1;
if($page == 1){
    $postsIndexesMin = 0;
} else {
    $postsIndexesMin = $postsIndexesMax - 4;
}

?>
<div class="container-fluid" style="background-color:lightgray"><br>
  <?php echo(listOfPosts($existingInputs, $postsIndexesMin, $postsIndexesMax)); ?>
</div><br>


<nav>
  <ul class="pagination pagination justify-content-center">
    <li class="page-item <?= ($page == '1') ? 'disabled' : '' ;?>">
      <a class="page-link" href="/last.php?page=<?php echo($page-1);?>" aria-disabled="true">Précédents</a>
    </li>
    <?php for($i = 1;$i <= $numberOfPages; $i++): ?>
        <li class="page-item"><a class="page-link" href="/last.php?page=<?= $i ?>"><?= $i ?></a></li>
    <?php endfor;?>
    <li class="page-item <?= ($page == $numberOfPages) ? 'disabled' : '' ;?>">
      <a class="page-link" href="/last.php?page=<?php echo($page+1);?>">Suivants</a>
    </li>
  </ul>
</nav>

<?php include 'partials/footer.php';?>
