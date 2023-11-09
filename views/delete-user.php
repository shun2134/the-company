<?php
session_start();
if(!isset($_SESSION['id'])) {  /* ! = reverse */
  header("location: index.php");
}

require "../classes/User.php";

$user_obj = new User;
$user = $user_obj->getUser($_SESSION['id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Delete User</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- start navigation  -->
    <nav class="navbar navbar-expand navbar-dark bg-dark" style="margin-bottom: 80px">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">
                <h1 class="h3">The Company</h1>
            </a>
            <div class="navbar-nav">
                <span class="navbar-text"><?= $_SESSION['full_name'] ?></span>
                <form action="../actions/logout.php" class="d-flex ms-2" method="post">
                    <button type="submit" class="text-danger bg-transparent border-0">Log out</button>
                </form>
            </div>
        </div>
    </nav>
    <main class="row justify-content-center gx-0">
        <div class="col-4 text-center">
            <i class="fa-solid fa-triangle-exclamation text-warning display-4 d-block mb-2"></i>
            <h2 class="text-danger mb-5">DELETE ACCOUNT</h2>
            <p class="fw-bold">Are you sure you want to delete your account?</p>
            <div class="card shadow-1 rounded mb-4">
                <?php if($user['photo']) { ?>
                <img src="../assets/images/<?= $user['photo'] ?>" alt="card-image-top">
                <?php } ?>
                <div class="card-header">
                    <h3 class="text-center card-title"><?= $user['username'] ?></h3>
                    <p class="card-text"><?= $user['first_name'] . " " . $user['last_name'] ?> </p>
                </div>
                <div class="card-footer pt-3">
                    <form action="../actions/delete-user.php" method="post">
                        <div class="text-center">
                            <a href="dashboard.php" class="btn btn-secondary d-inline">Cancel</a>
                            <button type="submit" class="btn btn-danger py-2">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>