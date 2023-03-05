<?php 
session_start();
require_once("pdo.php");

if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
}

if ( isset($_POST['cancel']) ) {
    unset($_SESSION['error']);
    header("Location: index.php");
    return;
}

if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])) {

    $first_name = htmlentities($_POST['first_name']);
    $last_name = htmlentities($_POST['last_name']);
    $email = htmlentities($_POST['email']);
    $headline = htmlentities($_POST['headline']);
    $summary = htmlentities($_POST['summary']);

    if (strlen($first_name) < 1 || strlen($last_name) < 1 || strlen($email) < 1 || strlen($headline) < 1 || strlen($summary) < 1) {
        $_SESSION['error'] = "All fields are required";
        header("Location: add.php");
        return;
    }
    elseif ( strpos($email, "@") === false){
        $_SESSION['error'] = "Email address must contain @";
        header("Location: add.php");
        return;
    }
    else {
        $sql = 'INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary) VALUES ( :uid, :fn, :ln, :em, :he, :su)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':uid' => $_SESSION['user_id'],
            ':fn' => $first_name,
            ':ln' => $last_name,
            ':em' => $email,
            ':he' => $headline,
            ':su' => $summary)
        );
        $_SESSION['success'] = "Profile added";
        header("Location: index.php");
        return;
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Kaung Sat Hein's Add Page</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    </head>

    <body>
        <div class="container">
            <h1 class="my-3">Adding Profile for Kaung Sat Hein</h1>

            <?php
            // Flash pattern
            if ( isset($_SESSION["error"]) ) {
                echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
                unset($_SESSION['error']);
            }
            ?>
            
            <form method="post">
                <p>
                    <label for="first_name">First Name: </label>
                    <input type="text" id="first_name" name="first_name" size="60"/>
                </p>
                <p>
                    <label for="last_name">Last Name: </label>
                    <input type="text" id="last_name" name="last_name" size="60"/>
                </p>
                <p>
                    <label for="email">Email: </label>
                    <input type="text" id="email" name="email" size="40"/>
                </p>
                <p>
                    <label for="headline">Headline: </label><br>
                    <input type="text" id="headline" name="headline" size="80"/>
                </p>
                <p>
                    Summary: <br>
                    <textarea name="summary" cols="80" rows="8"></textarea>
                </p>
                <input type="submit" value="Add">
                <input type="submit" name="cancel" value="Cancel">
            </form>
        </div>
    </body>
</html>