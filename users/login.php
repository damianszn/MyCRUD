<?php
include '../partials/mini-header.php';
//Database initiation
$pdo = new PDO('sqlite:../data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$data = $pdo->query("SELECT username, password FROM users");
$existingInputs = $data->fetchAll();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$isValid = false;
$firstAccess = false;

$errors = [
    'username' => "",
    'password' => "",
];

if(empty($_POST)){
    $firstAccess = true;
} else { 
    $isValid = true;
    $results = verifyLogin($existingInputs, $username, $password);

    var_dump($results);

    if(!$username){
        $isValid = false;
        $errors['username'] = "Veuillez entrer votre nom d'utilisateur.";
    } elseif($results[0] == false && $results[1] == 'username'){
        $isValid = false;
        $errors['username'] = "Pseudo introuvable.";
    }

    if(!$password){
        $isValid = false;
        $errors['password'] = "Veuillez entrer un mot de passe.";
    } elseif($results[0] == false && $results[1] == 'password'){
        $isValid = false;
        $errors['password'] = "Mauvais mot de passe.";
    }

    if($isValid){
        $_SESSION = [
            'logged' => true,
            'username' => $username
        ];
        header('Location: ../users/success.php?subject=connexion');
    } 
}
//var_dump($existingInputs);
?>

<div class="container">
    <br>
    <a href="../index.php">
        <button type="button" class="btn btn-primary btn-lg btn-block">Retour</button>
    </a>
    <br>
    <div class="card">
        <div class="card-header">
            <h4>Connexion</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="form-group">
                    <input name="username" value="<?php echo htmlentities($username)?>" placeholder="Pseudo"
                        class="form-control <?php echo($errors['username']) && !$firstAccess ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?php echo $errors['username']; ?>
                    </div>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Mot de passe"
                        class="form-control <?php echo($errors['password']) && !$firstAccess ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?php echo $errors['password']; ?>
                    </div>
                </div>

                <button class="btn btn-primary">Confirmer</button>
            </form>
        </div>
        <div class="card-footer">
            <p>Vous avez oublié votre mot de passe? <a href="#">Cliquez ici</a></p>
        </div>
    </div>
</div>
