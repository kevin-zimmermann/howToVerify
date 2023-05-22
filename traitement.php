<?php
$bdd = new PDO('mysql:dbname=test;host=localhost', 'root', '');

$message = [];
$message[] = 'OK';

$content = file_get_contents('php://input');

$_POST = json_decode($content, true);


if (isset($_POST)) {

    if (isset($_POST['login'])) {
        if (strlen($_POST['login']) <= 3) {
            $message[] = 'login trop court';
        } else {
            $login = htmlspecialchars($_POST['login']);
            $stmt = $bdd->prepare('SELECT * FROM user WHERE login = ?');
            $stmt->execute([$login]);
            if ($stmt->rowCount() > 0) {
                $message[] = $login . ' existe déjà';

            } else {
                $message[] = $login . ' n existe pas';
                if (isset($_GET['valider'])) {
                    if ($_POST['email'] && $_POST['password']) {

                        $email = htmlspecialchars($_POST['email']);
                        $password = $_POST['password'];

                        $password = password_hash($password, PASSWORD_BCRYPT);

                        $stmtInsert = $bdd->prepare('INSERT INTO user (login,password,email) VALUES(?,?,?)');
                        $stmtInsert->execute([$login, $password, $email]);

                    }
                }
            }
        }

    }
}

echo json_encode($message);
