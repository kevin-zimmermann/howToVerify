<?php
session_start();
var_dump($_SESSION);


?>
<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <title>Title</title>
</head>
<body>
<form method="post" id="form">
    <label for="login">Login:</label>
    <input type='text' name='login'>
    <label for="login">MDP:</label>
    <input type='text' name='password'>
    <label for="login">Email:</label>
    <input type='text' name='email'>
    <input type='button' value="valider" name='valider'>
</form>

</body>
</html>
<script src="script.js"></script>
