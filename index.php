<?php
$bdd = mysqli_connect("localhost","root","","test");

session_start();
$query = mysqli_query($bdd ,'SELECT * FROM user');
$users = mysqli_fetch_all($query,MYSQLI_ASSOC);
if(isset($_POST['valider'])){
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_BCRYPT);
    var_dump(htmlspecialchars($login));
    var_dump(htmlentities($login));
//    <script>window.location.href=`https://github.com/`</script>
    $query = mysqli_query($bdd, "INSERT INTO user (prenom,nom,email) VALUES('$login', '$password','$email');");

header('location:index.php');
} ?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Title</title>
</head>
<body>
<form method="GET">
    <input type='text' name='login'>
    <input type='text' name='password'>
    <input type='text' name='email'>
    <button type='submit' name='valider' value="valider"> Envoyer </button>
</form>
<?php var_dump($users); ?>
<?php foreach ($users as $user){ ?>
    <p><?= $user['prenom'] ?></p>
    <p><?= $user['nom'] ?></p>
    <p><?= $user['email'] ?></p>

<?php } ?>

</body>
</html>
