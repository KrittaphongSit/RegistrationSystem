<?php
session_start();
require_once 'config/db.php';
if (!isset($_SESSION['admin_login'])) {
    header('location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>

    <div class="container">
        <?php
        if (isset($_SESSION['admin_login'])) {
            $admin_id = $_SESSION['admin_login'];
            $stmt = $conn->prepare("SELECT * FROM users WHERE id = :admin_id");
            $stmt->bindParam(":admin_id", $admin_id);
            $stmt->execute();
            $admin_info = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($admin_info) {
        ?>
            <h4 class="mt-4">Admin Management: <?php echo $admin_info['firstname'] . ' ' . $admin_info['lastname']; ?></h4>
            
            <h2 class="mt-4">User List</h2>
            <a href="add_user.php" class="btn btn-success mb-3">Add New User</a>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $conn->query("SELECT * FROM users");
                    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td>" . $user['id'] . "</td>";
                        echo "<td>" . $user['firstname'] . "</td>";
                        echo "<td>" . $user['lastname'] . "</td>";
                        echo "<td>" . $user['email'] . "</td>";
                        echo "<td>";
                        echo "<a href='edit_user.php?id=" . $user['id'] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                        echo "<a href='delete_user.php?id=" . $user['id'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

            <a href="logout.php" class="btn btn-danger">Logout</a>

        <?php
            } else {
                echo "<p>Admin information not found.</p>";
            }
        }
        ?>
    </div>
</body>

<?php include_once('item/footer.php'); ?>

</html>