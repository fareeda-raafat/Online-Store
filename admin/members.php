<?php

//-------------------------
/*
    Member Manage Page [ Edit | Add | Delete ]
*/
//-------------------------
session_start();
$pageTitle = 'Members';
if (isset($_SESSION['Username'])) {
    include('init.php');

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {

        $query = '';

        if (isset($_GET['page']) && $_GET['page'] == 'Pending') {
            $query = " AND RegStatus = 0";
        }

        $stmt = $conn->prepare("SELECT *  FROM users WHERE GroupID != 1 " . $query . "");
        $stmt->execute();
        $rows = $stmt->fetchAll();

?>


        <h1 class="text-center"> Manage Members </h1>
        <div class="container">

            <div class="table-responsive">
                <table class="main-table table text-center table-bordered avatar-size">

                    <tr class="first">
                        <td>#ID</td>
                        <td>Avatar</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Register Date</td>
                        <td>Control</td>
                    </tr>

                    <?php

                    foreach ($rows as $row) {
                        echo '<tr>';
                        echo '<td>' . $row['UserID'] . '</td>';
                        echo '<td>';
                        if (empty($row['avatar'])) {
                            echo 'No Image';
                        } else {
                            echo '<img src="upload/avatars/' . $row['avatar'] . '" alt="member avatar"/>';
                        }
                        echo '</td>';
                        echo '<td>' . $row['Username'] . '</td>';
                        echo '<td>' . $row['Email'] . '</td>';
                        echo '<td>' . $row['FullName'] . '</td>';
                        echo '<td>' . $row['Date'] . ' </td>';
                        echo
                        '<td>
                        <a href="members.php?do=Edit&userid=' . $row['UserID'] . '" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                        <a href="members.php?do=Delete&userid=' . $row['UserID'] . '" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>';
                        if ($row['RegStatus'] == 0) {
                            echo  '<a href="members.php?do=Activate&userid=' . $row['UserID'] . '" class="btn btn-info activate "><i class="fa fa-info"></i>Activate</a>';
                        }

                        echo '</td>';


                        echo '</tr>';
                    }
                    ?>

                </table>

            </div>
            <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
        </div>
    <?php
    } elseif ($do == 'Add') { // Add page


    ?>


        <h1 class="text-center"> Add New Member</h1>
        <div class="container">
            <form class="form-horizental" action="members.php?do=Insert" method="POST" enctype="multipart/form-data">

                <!--start of username feild -->
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 input-container">
                        <input class="form-control" type="text" name="username" required="required" autocomplete="off">
                    </div>
                </div>
                <!-- end of username feild -->

                <!--start of password feild -->
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 input-container">
                        <input class="form-control" type="password" name="password" autocomplete="new-password" required="required">
                    </div>
                </div>
                <!-- end of password feild -->

                <!--start of Email feild -->
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 input-container">
                        <input class="form-control" type="email" name="email" required="required">
                    </div>
                </div>
                <!-- end of Email feild -->

                <!--start of fullname feild -->
                <div class="form-group">
                    <label for="fullname" class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10 input-container">
                        <input class="form-control" type="text" name="fullname" required="required">
                    </div>
                </div>
                <!-- end of fullname feild -->


                <!--start of Avatar feild -->
                <div class="form-group">
                    <label for="avatar" class="col-sm-2 control-label">Avatar</label>
                    <div class="col-sm-10 input-container">
                        <input type="file" name="avatar" class="form-control" >
                    </div>
                </div>
                <!-- end of Avatar feild -->

                <!--start of submit feild -->
                <div class="form-group">

                    <input class="btn btn-primary " type="submit" name="add" value="Add" class="form-control">
                </div>
                <!-- end of submit feild -->


            </form>
        </div>

        <?php

    } elseif ($do == 'Insert') { // Insert page



        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo '<h1 class="text-center"> Insert Members </h1>';
            echo '<div class="container">';



            print_r($_FILES['avatar']);

            //-----------------------------
            // to upload photo 
            //-------------------------------------
            $filename = $_FILES["avatar"]["name"];
            $tmpfile = $_FILES["avatar"]["tmp_name"];
            $folder = "upload/avatars/";
            $filesize = $_FILES["avatar"]["size"];
            $filetype = $_FILES["avatar"]["type"];
            $filename  = date("jnYGis") . "_" . $filename;

            $_SESSION["avatar"] = $filename;
            move_uploaded_file($tmpfile, $folder . $filename);

            $maxsize    = 7340032;     //max image size 7 Mega Byte

            $acceptable = array('jpeg', 'jpg', 'gif', 'png');     //upload types
            $fileExtension = strtolower(end(explode(".", $filename)));

            //---------------------------------------------

            $pass = $_POST['password'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $fullname = $_POST['fullname'];



            $hashPass = sha1($pass);

            // validate form feilds to check empty

            $FormErrors = array();

            if (empty($username)) {
                $FormErrors[] = 'Username Cant Be Empty';
            }

            if (strlen($username) < 4) {
                $FormErrors[] = 'Username Cant Be Smaller Than 4 Character';
            }

            if (strlen($username) > 20) {
                $FormErrors[] = 'Username Cant Be Larger Than 20 Character';
            }

            if (empty($pass)) {
                $FormErrors[] = 'Password Cant Be Empty';
            }

            if (empty($email)) {
                $FormErrors[] = 'Email Cant Be Empty';
            }

            if (empty($fullname)) {
                $FormErrors[] = 'Full Name Cant Be Empty';
            }

            if (($filesize >= $maxsize)) {
                $FormErrors[] = 'Main image too large. File must be less than 7 megabytes.';
            }


            if (($filesize == 0)) {
                $FormErrors[] = 'Main image has no size.';
            }

            if (!in_array($fileExtension, $acceptable)) {
                $FormErrors[] = 'Invalid main image type. Only JPG, JPEG, GIF and PNG types are accepted.';
            }


            foreach ($FormErrors as $error) {
                echo  '<div class="alert alert-danger">' . $error . '</div>';
            }

            if (empty($FormErrors)) {

                $check = checkItem('Username', 'users', $username);

                if ($check > 0) {
                    $MSG = '<div class= "alert alert-danger">This User Already Exist </div>';
                    redirectFun($MSG, 'back');
                } else {

                    $stmt = $conn->prepare(" INSERT INTO users
                                                    (Username , Password  , Email , FullName ,RegStatus, Date , avatar)
                                          VALUES(?,?,?,?,1,now(),?)");

                    $stmt->execute(array($username, $hashPass, $email, $fullname, $filename));
                    $MSG = '<div class= "alert alert-success">' . $stmt->rowCount() . ' ' . 'Memeber Added Successfully </div>';
                    redirectFun($MSG, 'back');
                }
            }
        } else {
            $MSG = '<div class="alert alert-danger">You Cant Browse Insert Page Directly</div>';
            redirectFun($MSG);
        }
        echo '</div>';
    } elseif ($do == 'Edit') {

        // get the value of userid from get request
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

        $stmt = $conn->prepare('SELECT * FROM users WHERE UserID = ? ');

        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        // show user data in form to edit it

        if ($count > 0) { ?>

            <h1 class="text-center"> Edit Members</h1>
            <div class="container">
                <form class="form-horizental" action="members.php?do=Update" method="POST">

                    <input type="hidden" value="<?php echo $userid; ?>" name="id">
                    <!--start of username feild -->
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="username" value="<?php echo $row['Username']; ?>" required="required" autocomplete="off">
                        </div>
                    </div>
                    <!-- end of username feild -->

                    <!--start of password feild -->
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="hidden" name="oldPass" value="<?php echo $row['Password']; ?>">
                            <input class="form-control" type="password" name="newPass" autocomplete="new-password">
                        </div>
                    </div>
                    <!-- end of password feild -->

                    <!--start of Email feild -->
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="email" name="email" value="<?php echo $row['Email']; ?>" required="required">
                        </div>
                    </div>
                    <!-- end of Email feild -->

                    <!--start of fullname feild -->
                    <div class="form-group">
                        <label for="fullname" class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="fullname" value="<?php echo $row['FullName']; ?>" required="required">
                        </div>
                    </div>
                    <!-- end of fullname feild -->

                    <!--start of submit feild -->
                    <div class="form-group">

                        <input class="btn btn-primary " type="submit" name="update" value="update" class="form-control">
                    </div>
                    <!-- end of submit feild -->


                </form>
            </div>
<?php
        } else {
            $MSG = '<div class="alert alert-danger">There Is No Such ID</div>';
            redirectFun($MSG);
        }
    } elseif ($do == 'Update') { // update page


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo '<h1 class="text-center"> Update Members </h1>';
            echo '<div class="container">';

            $id = $_POST['id'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $fullname = $_POST['fullname'];


            $pass = empty($_POST['newPass']) ? $_POST['oldPass'] : sha1($_POST['newPass']);

            // validate form feilds to check empty

            $FormErrors = array();

            if (empty($username)) {
                $FormErrors[] = 'Username Cant Be Empty';
            }

            if (strlen($username) < 4) {
                $FormErrors[] = 'Username Cant Be Smaller Than 4 Character';
            }

            if (strlen($username) > 20) {
                $FormErrors[] = 'Username Cant Be Larger Than 20 Character';
            }

            if (empty($email)) {
                $FormErrors[] = 'Email Cant Be Empty';
            }

            if (empty($fullname)) {
                $FormErrors[] = 'Full Name Cant Be Empty';
            }

            foreach ($FormErrors as $error) {
                echo  '<div class="alert alert-danger">' . $error . '</div>';
            }


            if (empty($FormErrors)) {
                $stmt = $conn->prepare(" UPDATE users SET Username = ?, Password = ? , Email = ?, FullName = ? WHERE UserID=?");

                $stmt->execute(array($username, $pass, $email, $fullname, $id));
                $MSG = '<div class= "alert alert-success">' . $stmt->rowCount() . ' ' . 'Recordes updated </div>';
                redirectFun($MSG, 'back');
            }
        } else {
            $MSG = '<div class="alert alert-danger">You Cant Browse Update Page Directly</div>';
            redirectFun($MSG);
        }

        echo '</div>';
    } elseif ($do == 'Delete') { // Delete Page

        echo '<h1 class="text-center"> Delete Members </h1>';
        echo '<div class="container">';

        // get id from get link

        $id = isset($_GET['userid']) && is_numeric($_GET['userid']) ? $_GET['userid'] : 0;

        // check if id in get link is in DB or not

        $check = checkItem('UserID', 'users', $id);
        if ($check > 0) {

            $stmt = $conn->prepare("DELETE FROM users WHERE UserID = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $MSG =  '<div class= "alert alert-success">  ' . $check . '  Record Deleted Successfully </div>';
            redirectFun($MSG, 'back');
        } else {
            $MSG = '<div class= "alert alert-danger"> There is No Such ID </div>';
            redirectFun($MSG);
        }

        echo '</div>';
    } elseif ($do == 'Activate') { // Activate Pending Members Page

        echo '<h1 class="text-center"> Activate Members </h1>';
        echo '<div class="container">';

        // get id from get link

        $id = isset($_GET['userid']) && is_numeric($_GET['userid']) ? $_GET['userid'] : 0;

        // check if id in get link is in DB or not

        $check = checkItem('UserID', 'users', $id);
        if ($check > 0) {

            $stmt = $conn->prepare("UPDATE users SET RegStatus = 1 WHERE UserID =?");
            $stmt->execute(array($id));

            $MSG =  '<div class= "alert alert-success">  ' . $check . '  Record Activated Successfully </div>';
            redirectFun($MSG, 'back');
        } else {
            $MSG = '<div class= "alert alert-danger"> There is No Such ID </div>';
            redirectFun($MSG);
        }

        echo '</div>';
    }
    include($tplt . 'footer.php');
} else {

    $MSG = '<div class="alert alert-danger">Please Sign in First</div>';
    redirectFun($MSG);
}
