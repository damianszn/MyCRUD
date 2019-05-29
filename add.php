<?php
include 'partials/header.php';
//Database initiation
$pdo = new PDO('sqlite:data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$data = $pdo->query("SELECT * FROM posts");
$existingInputs = $data->fetchAll();

$isValid = false;
$firstAccess = false;

$title = $_POST['title'] ?? '';
$article = $_POST['article'] ?? '';
$artistName = $_POST['artistName'] ?? '';
$albumName = $_POST['albumName'] ?? '';
$songName = $_POST['songName'] ?? '';
$link = $_POST['link'] ?? '';
$genre = $_POST['genre'] ?? '';
$image = $_FILES ?? '';
var_dump($_FILES);
$imageSource = $_POST['imageSource'] ?? '';

$errors = [
    'title' => '',
    'article' => '',
    'artistName' => '',
    'albumName' => '',
    'songName' => '',
    'link' => '',
    'genre' => '',
    'image' => '',
    'imageSource' => ''
];

if(empty($_POST)){
    $firstAccess = true;
} else { 
    $isValid = true;
    
    if (!$title) {
        $isValid = false;
        $errors['title'] = "Le titre est obligatoire.";
    } 
    if (!$songName) {
        $isValid = false;
        $errors['songName'] = "Le titre du morceau est obligatoire.";
    } 
    if (!$image) {
        $isValid = false;
        $errors['image'] = "Il faut une image. Un screenshot, une cover; en lien avec le morceau.";
    } 
    if (!$imageSource) {
        $isValid = false;
        $errors['imageSource'] = "Il faut la source de l'image en question. Soit un lien externe, soit une source écrite.";
    } 
    if($isValid){
        $filename = $_FILES['image']['type'];
        $ext = ".".substr($filename, -3, 3);
        $query = $pdo->prepare('INSERT INTO posts (author, title, article, artistName, albumName, songName, link, date, genre, imageSource, imageExt) 
        VALUES (:author, :title, :article, :artistName, :albumName, :songName, :link, :date, :genre, :imageSource, :imageExt)');
        $query->execute([
            'author' => $_SESSION['username'],
            'title' => $title,
            'article' => "\"".$article."\"",
            'artistName' => $artistName,
            'albumName' => $albumName,
            'songName' => $songName,
            'link' => $link,
            'date' => date("d.m.y h:i"),
            'genre' => $genre,
            'imageSource' => $imageSource,
            'imageExt' => $ext
        ]); 
        $id = $pdo->lastInsertId();
        uploadImage($image, $id);
        header('Location: ../users/success.php?subject=publication');
    } 
}

?>

<div class="container">
    <br>
    <div class="card">
        <div class="card-header">
            <h4>Nouveau Post</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <input name="title" value="<?php echo htmlentities($title)?>" placeholder="Titre du post*"
                        class="form-control <?php echo($errors['title']) && !$firstAccess ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?php echo $errors['title']; ?>
                    </div>
                </div>
                <!-- Details -->
                <div class="form-group">
                    <textarea name="article" placeholder="Une rime, une description"
                        class="form-control <?php echo($errors['article']) && !$firstAccess ? 'is-invalid' : '' ?>"><?php echo htmlentities($article)?></textarea>
                    <div class="invalid-feedback">
                        <?php echo $errors['article']; ?>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <input name="artistName" value="<?php echo htmlentities($artistName)?>" placeholder="Nom de l'artiste"
                        class="form-control <?php echo($errors['artistName']) && !$firstAccess ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?php echo $errors['artistName']; ?>
                    </div>
                </div>
                <div class="form-group">
                    <input name="albumName" value="<?php echo htmlentities($albumName)?>" placeholder="Nom de l'album"
                        class="form-control <?php echo($errors['albumName']) && !$firstAccess ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?php echo $errors['albumName']; ?>
                    </div>
                </div>
                <div class="form-group">
                    <input name="songName" value="<?php echo htmlentities($songName)?>" placeholder="Titre du morceau*"
                        class="form-control <?php echo($errors['songName']) && !$firstAccess ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?php echo $errors['songName']; ?>
                    </div>
                </div>
                <div class="form-group">
                    <input name="link" value="<?php echo htmlentities($link)?>" placeholder="Lien YouTube (ou similaire)"
                        class="form-control <?php echo($errors['link']) && !$firstAccess ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?php echo $errors['link']; ?>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label for="genreSelect">Genre : *</label>
                    <select name="genre" class="form-control" id="genreSelect">
                        <option value="melodieux" <?php $genre==='melodieux' ? 'validated' : '';?> >Mélodieux</option>
                        <option value="decoupeur" <?php $genre==='decoupeur' ? 'validated' : '';?> >Découpeur</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="imageSelect">Image : *</label>
                    <input name="image" type="file" 
                        class="form-control-file <?php echo($errors['image']) && !$firstAccess ? 'is-invalid' : '' ?>" id="imageSelect">
                    <div class="invalid-feedback">
                        <?php echo $errors['image']; ?>
                    </div>
                </div>
                <div class="form-group">
                    <input name="imageSource" value="<?php echo htmlentities($imageSource)?>" placeholder="Source de l'image * (lien ou source écrite)"
                        class="form-control <?php echo($errors['imageSource']) && !$firstAccess ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?php echo $errors['imageSource']; ?>
                    </div>
                </div>

                <button class="btn btn-primary">Ajouter</button>
            </form>
        </div>
    </div>
</div>
<br>