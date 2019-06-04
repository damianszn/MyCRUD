<?php
include '../partials/mini-header.php';

$pdo = new PDO('sqlite:../data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);
$data = $pdo->query("SELECT * FROM users");
$existingInputs = $data->fetchAll();

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$isValid = false;
$firstAccess = false;

$errors = [
    'username' => "",
    'password' => "",
    'email' => ""
];

if(empty($_POST)){
    $firstAccess = true;
} else { 
    $isValid = true;
    //Regex
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    //Username
    if (!$username || !$lowercase && !$uppercase) {
        $isValid = false;
        $errors['username'] = 'Le pseudo doit contenir au moins une minuscule et une majuscule.';
    } elseif (!isUnique($existingInputs, 'username', $username)){
        $isValid = false;
        $errors['username'] = 'Le pseudo est déjà pris';
    } 
    //Password
    if (!$password || !$uppercase || !$lowercase || !$number || strlen($password) < 8) {
        $isValid = false;
        $errors['password'] = 'Le mot de passe doit contenir au moins 8 caractères, contenir au moins une majuscule, une minuscule et un nombre.';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        unset($_POST['password']);
        $password = $hashed_password;
    }
    //Mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $isValid = false;
        $errors['email'] = 'Veuillez entrer une adresse mail valide.';
    } elseif (!isUnique($existingInputs, 'email', $email)){
        $isValid = false;
        $errors['email'] = "L'adresse est déjà prise.";
    } 

    if($isValid){
        $query = $pdo->prepare('INSERT INTO users (username, password, email) VALUES (:username, :password, :email)');
        $query->execute([
            'username' => $username,
            'password' => $password,
            'email' => $email
        ]);
        $_SESSION = [
            'logged' => true,
            'username' => $username,
            'email' => $email
        ];
        header('Location: /users/success.php?subject=inscription');
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
    <?php if(!$isValid): ?>
    <div class="card">
        <div class="card-header">
            <h4>Inscription</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="form-group">
                    <input name="username" value="<?php echo htmlentities($username)?>" placeholder="Pseudo *"
                        class="form-control <?php echo($errors['username']) && !$firstAccess ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?php echo $errors['username']; ?>
                    </div>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Mot de passe *"
                        class="form-control <?php echo($errors['password']) && !$firstAccess ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?php echo $errors['password']; ?>
                    </div>
                </div>
                <div class="form-group">
                    <input name="email" value="<?php echo htmlentities($email) ?>" placeholder="Email *"
                        class="form-control <?php echo($errors['email']) && !$firstAccess ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?php echo $errors['email']; ?>
                    </div>
                </div>

                <button class="btn btn-primary">Confirmer</button>
            </form>
        </div>
        <div class="card-footer">
            <p>Un problème pour s'inscrire? <a href="#">Cliquez ici</a></p>
        </div>
    </div>
    <?php endif;?>
</div>
<?php include '../partials/footer.php';?>

