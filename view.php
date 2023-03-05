<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaung Sat Hein's View Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>
<body>
    <?php
        session_start(); 
        require_once("pdo.php");

        if ( ! isset($_GET['profile_id']) ) {
            $_SESSION['error'] = "Missing profile_id";
            header('Location: index.php');
            return;
        }

        $profile_id = htmlentities($_GET['profile_id']);
        $stmt = $pdo->prepare("SELECT * FROM profile WHERE profile_id = :id");
        $stmt->execute(array(":id" => $profile_id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ( $row === false ) {
            $_SESSION['error'] = 'Bad value for profile_id';
            header( 'Location: index.php' ) ;
            return;
        }

        $fn = htmlentities($row['first_name']);
        $ln = htmlentities($row['last_name']);
        $em = htmlentities($row['email']);
        $he = htmlentities($row['headline']);
        $su = htmlentities($row['summary']);
    ?>

    <div class="container">
        <h1>Profile information</h1>
        <b><small>First Name: </b><?= $fn ?></small><br>
        <b><small>Last Name: </b><?= $ln ?></small><br>
        <b><small>Email: </b><?= $em ?></small><br>
        <b><small>Headline: </b><br><?= $he ?></small><br>
        <b><small>Summary: </b><br><?= $su ?></small><br>
        <a href="index.php">Done</a>
    </div>
</body>
</html>