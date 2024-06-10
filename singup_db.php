<?php 

    session_start();
    require_once 'config/db.php';

    if (isset($_POST['signup'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $urole = 'user';

        if (empty($firstname)) {
            $_SESSION['error'] = 'Please enter your firstname';
            header("location: signup.php");
        } else if (empty($lastname)) {
            $_SESSION['error'] = 'Please enter your lastname';
            header("location: signup.php");
        } else if (empty($email)) {
            $_SESSION['error'] = 'Please enter your email';
            header("location: signup.php");
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Invalid email format';
            header("location: signup.php");
        } else if (empty($password)) {
            $_SESSION['error'] = 'Please enter your password';
            header("location: signup.php");
        } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            $_SESSION['error'] = 'Your password should be between 5 and 20 characters long';
            header("location: signup.php");
        } else if (empty($c_password)) {
            $_SESSION['error'] = 'Please confirm your password';
            header("location: signup.php");
        } else if ($password != $c_password) {
            $_SESSION['error'] = 'Your passwords do not match';
            header("location: signup.php");
        } else {
            try {

                $check_email = $conn->prepare("SELECT email FROM users WHERE email = :email");
                $check_email->bindParam(":email", $email);
                $check_email->execute();
                $row = $check_email->fetch(PDO::FETCH_ASSOC);

                if ($row['email'] == $email) {
                    $_SESSION['warning'] = "There is already an email in the system <a href='index.php'>Click here</a> to enter the system";
                    header("location: signup.php");
                } else if (!isset($_SESSION['error'])) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO users(firstname, lastname, email, password, urole)
                                            VALUES(:firstname, :lastname, :email, :password, :urole)");
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":urole", $urole);
                    $stmt->execute();
                    $_SESSION['success'] = "You have successfully registered <a href='index.php' class='alert-link'>Click here</a> to enter the system";
                    header("location: signup.php");
                } else {
                    $_SESSION['error'] = "Something went wrong";
                    header("location: signup.php");
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

?>