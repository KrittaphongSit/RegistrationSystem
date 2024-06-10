<?php
    session_start();
    require_once 'config/db.php';
    if (!isset($_SESSION['admin_login'])) {
        header('location: index.php');
        exit(); // ออกจากการทำงานในทันทีหลังจาก header() เพื่อป้องกันการทำงานเพิ่มเติม
    }

    if (!isset($_GET['id'])) {
        header('location: admin.php');
        exit(); // ออกจากการทำงานในทันทีหลังจาก header() เพื่อป้องกันการทำงานเพิ่มเติม
    }

    $user_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();
    $user_info = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user_info) {
        header('location: admin.php');
        exit(); // ออกจากการทำงานในทันทีหลังจาก header() เพื่อป้องกันการทำงานเพิ่มเติม
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Edit User</h2>
        <form action="update_user.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $user_info['id']; ?>">
            <div class="mb-3">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" class="form-control" name="firstname" value="<?php echo $user_info['firstname']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lastname" value="<?php echo $user_info['lastname']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo $user_info['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password">
                <small class="form-text text-muted">Leave blank if you don't want to change the password</small>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
<?php include_once('item/footer.php'); ?>
</html>