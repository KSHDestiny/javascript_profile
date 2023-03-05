<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kaung Sat Hein's Resume Registry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <style>
        table, tr, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="container mt-2">
        <h1>Kaung Sat Hein's Resume Registry</h1>
        <?php 
            session_start(); 
            require_once("pdo.php");
            if ( ! isset($_SESSION['name']) ) {
                echo "<div><a href='login.php'>Please log in</a></div><br>";
                include_once("read.php");
                echo "<p><b>Note: </b>Your implementation should retain data across multiple logout/login sessions. This sample implementation clears all its data on logout - which you should not do in your implementation.</p>";
                die();
            }

            $stmt = $pdo->query("SELECT * FROM profile ORDER BY profile_id");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($rows == true){
                if ( isset($_SESSION["error"]) ) {
                    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
                    unset($_SESSION['error']);
                }
                if ( isset($_SESSION["success"]) ) {
                    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
                    unset($_SESSION['success']);
                }
            
        ?>
        <p>
            <a href="logout.php">Logout</a>
        </p>
        <table>
            <tr>
                <th><b>Name</b></th>
                <th><b>Headline</b></th>
                <th><b>Action</b></th>
            </tr>
                <?php 
                    foreach($rows as $row) {
                        $id = htmlentities($row['profile_id']);
                        echo "<tr><td>";
                        echo (htmlentities($row['first_name']) ." ". htmlentities($row['last_name']) . "</td><td>");
                        echo (htmlentities($row['headline']) . "</td><td>");
                        if($row["user_id"] === $_SESSION["user_id"] ){
                            echo "<a href='edit.php?profile_id=$id";
                            echo "'>Edit</a> / <a href='delete.php?profile_id=$id";
                            echo "'>Delete</a></td></tr>";
                        }
                    }
                }
                ?>
        </table>
        <p>
            <a href="add.php">Add New Entry</a>
        </p>
        <p>
            <b>Note: </b>Your implementation should retain data across multiple logout/login sessions. This sample implementation clears all its data periodically - which you should not do in your implementation.
        </p>
    </div>
</body>
</html>