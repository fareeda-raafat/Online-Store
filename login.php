<?php

if (isset($_SESSION['User'])) {
    header('Locaton:index.php');
}

$pageTitle = 'Login';

include 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['login'])) {

        $name = $_POST['username'];
        $pass = $_POST['password'];
        $hashedPass = sha1($pass);

        $stmt = $conn->prepare("SELECT 
                              UserID ,Username , Password 
                          FROM 
                               users 
                          WHERE 
                               Username= ? 
                          AND 
                              Password = ? ");
        $stmt->execute(array($name, $hashedPass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();


        if ($count > 0) {
            $_SESSION['User'] = $name;
            $_SESSION['ID']=$row['UserID'];
            header('Location:index.php');
            exit();
        }
    } else {


        $name = $_POST['username'];
        $pass1 = $_POST['password1'];
        $pass2 = $_POST['password2'];
        $email = $_POST['email'];

        $hashPass1 = sha1($pass1);
        $hashPass2 = sha1($pass2);


        $FormErrors  = array();

        if (empty($name)) {
            $FormErrors[] = 'Username Cant Be Empty';
        }

        if (strlen($name) < 4) {
            $FormErrors[] = 'Username Cant Be Smaller Than 4 Character';
        }

        if (strlen($name) > 20) {
            $FormErrors[] = 'Username Cant Be Larger Than 20 Character';
        }

        if (empty($pass1) && empty($pass2)) {
            $FormErrors[] = 'Password Cant Be Empty';
        }

        if ($hashPass1 != $hashPass2) {
            $FormErrors[] = 'Passwords Is Not Match';
        }

        if (empty($email)) {
            $FormErrors[] = 'Email Cant Be Empty';
        }

        foreach ($FormErrors as $error) {
            $MSG =  '<div class="alert alert-danger">' . $error . '</div>';
        }

        if (empty($FormErrors)) {

            $check = checkItem('Username', 'users', $username);

            if ($check > 0) {
                $MSG = '<div class= "alert alert-danger">This User Already Exist </div>';
            } else {

                $stmt = $conn->prepare(" INSERT INTO users
                                                (Username , Password  , Email ,RegStatus, Date )
                                      VALUES(?,?,?,0,now())");

                $stmt->execute(array($name, $hashPass1, $email));
                $MSG = '<div class= "alert alert-success">' . $stmt->rowCount() . ' ' . 'Memeber Added Successfully </div>';
            }
        }
    }
}

?>

<div class="container">
    <h1 class="text-center"> Login | Signup</h1>

    <!-- Start Login Form -->
    <form class="login" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

        <!--start of username feild -->
        <div class="form-group">
            <div class="col-sm-10 input-container">
                <input class="form-control" type="text" name="username" required="required" autocomplete="off" placeholder="Type Your Username">
            </div>
        </div>
        <!-- end of username feild -->

        <!--start of password feild -->
        <div class="form-group">
            <div class="col-sm-10 input-container">
                <input class="form-control" type="password" name="password" autocomplete="new-password" required="required" placeholder="Type Your Password">
            </div>
        </div>
        <!-- end of password feild -->

        <!--start of submit feild -->
        <div class="form-group">
            <input class="btn form-control" type="submit" name="login" value="Login">
        </div>
        <!-- end of submit feild -->

    </form>

    <!-- End login Form -->

    <!-- Start Signup Form -->
    <form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

        <!--start of username feild -->
        <div class="form-group">
            <div class="col-sm-10 input-container">
                <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type A Username">
            </div>
        </div>
        <!-- end of username feild -->

        <!--start of password feild -->
        <div class="form-group">
            <div class="col-sm-10 input-container">
                <input class="form-control" type="password" name="password1" autocomplete="new-password" placeholder="Type Complex Password">
            </div>
        </div>
        <!-- end of password feild -->

        <!--start of password feild -->
        <div class="form-group">
            <div class="col-sm-10 input-container">
                <input class="form-control" type="password" name="password2" autocomplete="new-password" placeholder="Type Password Again">
            </div>
        </div>
        <!-- end of password feild -->

        <!--start of Email feild -->
        <div class="form-group">
            <div class="col-sm-10 input-container">
                <input class="form-control" type="email" name="email" placeholder="Type Valid Email">
            </div>
        </div>
        <!-- end of Email feild -->


        <!--start of submit feild -->
        <div class="form-group">
            <input class="btn form-control " type="submit" name="signup" value="Signup" class="form-control">
        </div>
        <!-- end of submit feild -->


    </form>

    <!-- End Signup Form -->
</div>

<div class="the-errors text-center">
    <?php
    if (isset($MSG)) {
        echo '<div class="container">' . $MSG . '</div>';
    }
    ?>
</div>

<?php
include $tplt . 'footer.php';
?>