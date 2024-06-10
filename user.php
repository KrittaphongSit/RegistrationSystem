<?php
    session_start();
    require_once 'config/db.php';
    if (!isset($_SESSION['user_login'])) {
        header('location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></head>
    <link rel="stylesheet" href="css/footer.css">
    <body>

        <div class="container">
            <?php 
            
                if (isset($_SESSION['user_login'])) {
                    $user_id = $_SESSION['user_login'];
                    $stmt = $conn->query("SELECT * FROM users WHERE id = $user_id");
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                }
            
            ?>
            <h4 class="mt-4">User : <?php echo $row['firstname'] . ' ' . $row['lastname'] ?></h4>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <div class="d-flex flex-column align-items-center center-content">
            <h4 class="mt-4">Welcome</h4>
            <h2 class="mt-4"><?php echo $row['firstname'] . ' ' . $row['lastname'] ?></h2>
            <h4 class="mt-4">This is a website testing the registration and login system.</h4>
        </div>

        
    </body>

    <?php include_once('item/footer.php'); ?>

</html>