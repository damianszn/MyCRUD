<?php 
include 'partials/header.php';
$pdo = new PDO('sqlite:data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$data = $pdo->query("SELECT * FROM posts");
$existingInputs = $data->fetchAll();
var_dump($existingInputs);
?>

<?php /* if (isset($image)):  */?>
    <!-- <img style="width:60px" src="<?php echo "users/images/${user['id']}.${user['extension']}"?>" alt=""> -->
<?php /* endif;  */?>

<?php include 'partials/footer.php';?>
