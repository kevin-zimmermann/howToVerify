<?php
session_start();

//Pas obligatoire

//header('Access-Control-Allow-Origin: http://localhost:3000');
//header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
//header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');


//Connexion à la BDD
$bdd = new PDO('mysql:dbname=test;host=localhost', 'root', '');

//Cette variable va contenir tout ce qui sera contenu dans le data (
$message = [];

//Pour la connexion -> utilisation de la superglobale $_SESSION
$_SESSION['user'] = "UserTest";
//session_destroy();


// Sera appellé quand l'URL dans le fetch(JS) sera égale à "traitement.php?users=1"
if (isset($_GET['users'])) {
    $stmt = $bdd->prepare('SELECT * FROM users');
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //On renvoit le résultat de notre requête dans notre variable $message qui contiendra toutes les informations que l'on veut exploiter dans le Fetch(JS)
    $message['data'] = $results;
}

// Lorsque notre Fetch(JS) utilisera la method POST, on passera par ici
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//Va nous permettre de récupérer ce que l'on a envoyé dans le body du Fetch(JS)
    $contentJson = file_get_contents('php://input');
    //Passer du JSON à un array que l'on va stocker dans la superglobale $_POST qui sera le contenu de notre form dans le cas présent
    $_POST = json_decode($contentJson, true);

    //Supprimer un utilisateur en fonction de son ID
    if (isset($_POST['deleteUser'])) {
        $idUserToDelete = intval($_POST['deleteUser']);
        $stmt = $bdd->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$idUserToDelete]);

        $message['status'] = "Utilisateur supprimé";

    }

    //REGISTER
    if (isset($_POST['login'])) {
        if (strlen($_POST['login']) <= 3) {
            $message['err'] = 'login trop court';
        } else {
            $login = htmlspecialchars($_POST['login']);
            $stmt = $bdd->prepare('SELECT * FROM users WHERE login = ?');
            $stmt->execute([$login]);
            if ($stmt->rowCount() > 0) {
                $message['err'] = $login . ' existe déjà';

            } else {
                $message['err'] = $login . ' n\'existe pas';
                if ($_POST['email'] && $_POST['password']) {

                    $email = htmlspecialchars($_POST['email']);
                    $password = $_POST['password'];

                    if (isset($_GET['valider'])) {

                        $password = password_hash($password, PASSWORD_BCRYPT);

                        $stmtInsert = $bdd->prepare('INSERT INTO users (login,password,email) VALUES(?,?,?)');
                        $stmtInsert->execute([$login, $password, $email]);
                        $message['err'] = 'utilisateur bien enregistré !';


                    }
                }

            }

        }
    }

}
// On renvoie le contenu de notre array ($message) sous format JSON pour être interprétable par la réponse et pouvoir exploiter les informations qui y sont contenues
echo json_encode($message);
