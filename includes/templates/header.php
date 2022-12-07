<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title><?php echo getTitle(); ?></title>
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>frontend.css">

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Online Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="app-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="app-nav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-link"  class="nav-item"> <a href="categories.php">Categories</a> </li>

                    <?php

                    $categories = getCats();
                    foreach ($categories as $cat) {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="categories.php?pageid=<?php echo $cat['ID'] ?>&pagename=<?php echo $cat['Name'] ?>">
                                <?php echo $cat['Name'];
                                ?></a>
                        </li>
                    <?php
                    }
                    ?>


                    <?php
                    if (isset($_SESSION['User'])) {
                    ?>

                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $_SESSION['User'] ?>
                            </a>
                            <ul class="dropdown-menu ">
                                <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                                <li><a class="dropdown-item" href="new_ads.php">New Item</a></li>
                                <li><a class="dropdown-item" href="profile.php#my_item">My Items</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </li>

                    <?php
                    } else {
                    ?>
                        <li class="nav-item"><a class="nav-link" href="login.php"> Login|Signup </a></li>
                    <?php } ?>
                </ul>
            </div>



        </div>
    </nav>