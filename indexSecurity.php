<?php
$bdd = new PDO('mysql:dbname=test;host=localhost', 'root', '');

session_start();
//$stmt = $bdd->prepare('SELECT * FROM user');
//$stmt->execute();
//$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Title</title>
</head>
<body>
<form method="post" id="form">
    <input type='text' name='login'>
    <input type='text' name='password'>
    <input type='text' name='email'>
    <input type='button' value="valider" name='valider'>
</form>
<?php //= $_SESSION ?>
<?php //var_dump($users); ?>
<?php //foreach ($users as $user){ ?>
<!--    <p>Prenom:--><?php //= $user['prenom'] ?><!--</p>-->
<!--    <p>Nom:--><?php //= $user['nom'] ?><!--</p>-->
<!--    <p>Email:--><?php //= $user['email'] ?><!--</p>-->
<!---->
<?php //} ?>

</body>
</html>
<script src="script.js"></script>
