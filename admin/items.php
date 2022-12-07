<?php

session_start();

if (isset($_SESSION['Username'])) {
    $pageTitle = 'Itmes';

    include('init.php');

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {


        $stmt = $conn->prepare("SELECT 
                                    items.*,
                                    categories.Name AS category_name,
                                    users.Username
                                FROM 
                                    items
                                INNER JOIN
                                    categories 
                                ON 
                                    categories.ID = items.Cat_ID
                                INNER JOIN
                                    users
                                ON
                                    users.UserID = items.Member_ID

                                 ");
        $stmt->execute();
        $rows = $stmt->fetchAll();

?>
        <h1 class="text-center"> Manage Items </h1>
        <div class="container">

            <div class="table-responsive">
                <table class="main-table table text-center table-bordered">

                    <tr class="first">
                        <td>#ID</td>
                        <td>Item Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Adding Date</td>
                        <td>Category</td>
                        <td>Member</td>
                        <td>Control</td>
                    </tr>

                    <?php

                    foreach ($rows as $row) {
                        echo '<tr>';
                        echo '<td>' . $row['Item_ID'] . '</td>';
                        echo '<td>' . $row['Name'] . '</td>';
                        echo '<td>' . $row['Description'] . '</td>';
                        echo '<td>' . $row['Price'] . '</td>';
                        echo '<td>' . $row['Add_Date'] . ' </td>';
                        echo '<td>' . $row['category_name'] . ' </td>';
                        echo '<td>' . $row['Username'] . ' </td>';
                        echo
                        '<td>
                        <a href="items.php?do=Edit&itemid=' . $row['Item_ID'] . '" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                        <a href="items.php?do=Delete&itemid=' . $row['Item_ID'] . '" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>';

                        if ($row['Approve'] == 0) {
                            echo '<a href="items.php?do=Approve&itemid=' . $row['Item_ID'] . '" class="btn btn-primary approve "><i class="fa fa-check"></i>Approve</a>';
                        }
                        echo '</td>';


                        echo '</tr>';
                    }
                    ?>

                </table>

            </div>
            <a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Item</a>
        </div>


    <?php

    } elseif ($do == 'Add') {

    ?>


        <h1 class="text-center"> Add New Item </h1>
        <div class="container">
            <form class="form-horizental" action="items.php?do=Insert" method="POST">

                <!--start of Name feild -->
                <div class="form-group" style="position: relative;">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="name" required="required">
                    </div>
                </div>
                <!-- end of Name feild -->

                <!--start of Description feild -->
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="description">
                    </div>
                </div>
                <!-- end of Description feild -->

                <!--start of price feild -->
                <div class="form-group">
                    <label for="price" class="col-sm-2 control-label">Price</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="price">
                    </div>
                </div>
                <!-- end of price feild -->


                <!--start of country feild -->
                <div class="form-group">
                    <label for="country" class="col-sm-2 control-label">Country</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="country">
                    </div>
                </div>
                <!-- end of country feild -->

                <!--start of status feild -->
                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">status</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="status">
                            <option value="0">...</option>
                            <option value="1">New</option>
                            <option value="2">Like New</option>
                            <option value="3">Old</option>
                            <option value="4">Very Old</option>
                        </select>
                    </div>
                </div>
                <!-- end of status feild -->

                <!--start of members feild -->
                <div class="form-group">
                    <label for="member" class="col-sm-2 control-label">Member</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="member">
                            <option value="0">...</option>

                            <?php

                            $stmt = $conn->prepare("SELECT * FROM users ");
                            $stmt->execute();
                            $users = $stmt->fetchAll();

                            foreach ($users as $user) {

                                echo '<option value="' . $user['UserID'] . '">' . $user['Username'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- end of members feild -->

                <!--start of category feild -->
                <div class="form-group">
                    <label for="category" class="col-sm-2 control-label">Category</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="category">
                            <option value="0">...</option>

                            <?php

                            $stmt = $conn->prepare("SELECT * FROM categories WHERE parent = 0");
                            $stmt->execute();
                            $cats = $stmt->fetchAll();

                            foreach ($cats as $cat) {

                                echo '<option value="' . $cat['ID'] . '">' . $cat['Name'] . '</option>';
                                $parentid = $cat['ID'];
                                $stmt = $conn->prepare("SELECT * FROM categories WHERE parent = $parentid");
                                $stmt->execute();
                                $childcats = $stmt->fetchAll();

                                foreach ($childcats as $child) {

                                    echo '<option value="' . $child['ID'] . '">--' . $child['Name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!--start of submit feild -->
                <div class="form-group">

                    <input class="btn btn-primary " type="submit" name="add" value="Add Item" class="form-control">
                </div>
                <!-- end of submit feild -->


            </form>
        </div>

        <?php
    } elseif ($do == 'Insert') {


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo '<h1 class="text-center"> Insert Members </h1>';
            echo '<div class="container">';

            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $member = $_POST['member'];
            $category = $_POST['category'];


            $check = checkItem('Name', 'items', $name);
            if ($check > 0) {
                $MSG = '<div class="alert alert-danger">This Item Is Already Exist.</div>';
                redirectFun($MSG, 'back');
            } else {
                $stmt = $conn->prepare("INSERT INTO items 
            (`Name`,`Description`,`Price`,`Country_Made`,`Status`,`Add_Date`,`Cat_ID`,`Member_ID`) 
            VALUES (?,?,?,?,?,now(),?,?)");
                $stmt->execute(array($name, $desc, $price, $country, $status, $category, $member));
                $MSG = '<div class= "alert alert-success">' . $stmt->rowCount() . ' ' . 'Item Added Successfully </div>';
                redirectFun($MSG, 'back');

                echo '</div>';
            }
        } else {
            $MSG = '<div class="alert alert-danger">You Cant Browse Insert Page Directly</div>';
            redirectFun($MSG);
        }
    } elseif ($do == 'Edit') {

        $id = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;


        $stmt = $conn->prepare("SELECT * FROM items WHERE Item_ID = ? ");
        $stmt->execute(array($id));
        $row = $stmt->fetch();
        $counter = $stmt->rowCount();

        if ($counter > 0) {

        ?>


            <h1 class="text-center"> Edit Item </h1>
            <div class="container" style="width: 900px ;">
                <form class="form-horizental" action="items.php?do=Update" method="POST">

                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <!--start of Name feild -->
                    <div class="form-group" style="position: relative;">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="name" required="required" value="<?php echo $row['Name']; ?>">
                        </div>
                    </div>
                    <!-- end of Name feild -->

                    <!--start of Description feild -->
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="description" value="<?php echo $row['Description']; ?>">
                        </div>
                    </div>
                    <!-- end of Description feild -->

                    <!--start of price feild -->
                    <div class="form-group">
                        <label for="price" class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="price" value="<?php echo $row['Price']; ?>">
                        </div>
                    </div>
                    <!-- end of price feild -->


                    <!--start of country feild -->
                    <div class="form-group">
                        <label for="country" class="col-sm-2 control-label">Country</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="country" value="<?php echo $row['Country_Made']; ?>">
                        </div>
                    </div>
                    <!-- end of country feild -->

                    <!--start of status feild -->
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">status</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="status">
                                <option value="0" <?php if ($row['Status'] == 0) {
                                                        echo 'selected';
                                                    } ?>>...</option>
                                <option value="1" <?php if ($row['Status'] == 1) {
                                                        echo 'selected';
                                                    } ?>>New</option>
                                <option value="2" <?php if ($row['Status'] == 2) {
                                                        echo 'selected';
                                                    } ?>>Like New</option>
                                <option value="3" <?php if ($row['Status'] == 3) {
                                                        echo 'selected';
                                                    } ?>>Old</option>
                                <option value="4" <?php if ($row['Status'] == 4) {
                                                        echo 'selected';
                                                    } ?>>Very Old</option>
                            </select>
                        </div>
                    </div>
                    <!-- end of status feild -->

                    <!--start of members feild -->
                    <div class="form-group">
                        <label for="member" class="col-sm-2 control-label">Member</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="member">
                                <option value="0">...</option>

                                <?php

                                $stmt = $conn->prepare("SELECT * FROM users ");
                                $stmt->execute();
                                $users = $stmt->fetchAll();

                                foreach ($users as $user) {

                                    echo '<option value="' . $user['UserID'] . '"';
                                    if ($row['Item_ID'] == $user['UserID']) {
                                        echo 'selected';
                                    }
                                    echo '>' . $user['Username'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- end of members feild -->

                    <!--start of category feild -->
                    <div class="form-group">
                        <label for="category" class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="category">
                                <option value="0">...</option>

                                <?php

                                $stmt = $conn->prepare("SELECT * FROM categories ");
                                $stmt->execute();
                                $cats = $stmt->fetchAll();

                                foreach ($cats as $cat) {

                                    echo '<option value="' . $cat['ID'] . '"';
                                    if ($row['Cat_ID'] == $cat['ID']) {
                                        echo 'selected';
                                    }
                                    echo '>' . $cat['Name'] . '</option>';
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                    <!--start of submit feild -->
                    <div class="form-group">

                        <input class="btn btn-primary " type="submit" name="edit" value="Edit Item" class="form-control">
                    </div>
                    <!-- end of submit feild -->


                </form>

                <!-- start View Item Comments -->
                <?php

                $stmt = $conn->prepare(

                    "SELECT 
                                    comments.*,
                                    users.Username
                                FROM 
                                    comments
                                INNER JOIN
                                    users
                                ON
                                    users.UserID = comments.user_id
                                WHERE
                                    item_id = ?

                                 "
                );

                $stmt->execute(array($id));
                $coms = $stmt->fetchAll();


                if (!empty($coms)) {
                ?>
                    <h1 class="text-center"> Manage [ <?php echo $row['Name']; ?> ] Comments </h1>
                    <div class="container">

                        <div class="table-responsive">
                            <table class="main-table table text-center table-bordered">

                                <tr class="first">
                                    <td>#ID</td>
                                    <td>Comment</td>
                                    <td>Comment Date</td>
                                    <td>Member</td>
                                    <td>Control</td>
                                </tr>

                                <?php

                                foreach ($coms as $com) {
                                    echo '<tr>';
                                    echo '<td>' . $com['ComID'] . '</td>';
                                    echo '<td>' . $com['Comment'] . '</td>';
                                    echo '<td>' . $com['Comment_Date'] . '</td>';
                                    echo '<td>' . $com['Username'] . ' </td>';
                                    echo
                                    '<td>
                        <a href="comments.php?do=Edit&comid=' . $com['ComID'] . '" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                        <a href="comments.php?do=Delete&comid=' . $com['ComID'] . '" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>';

                                    if ($row['Status'] == 0) {
                                        echo '<a href="comments.php?do=Approve&comid=' . $com['ComID'] . '" class="btn btn-primary approve "><i class="fa fa-check"></i>Approve</a>';
                                    }
                                    echo '</td>';


                                    echo '</tr>';
                                }
                                ?>

                            </table>

                        </div>

                    </div>
                <?php

                }
                ?>
                <!-- end View Item Comments -->
            </div>

<?php

        } else {
            $MSG = '<div class="alert alert-danger">There Is No Such ID</div>';
            redirectFun($MSG);
        }
    } elseif ($do == 'Update') {


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo '<h1 class="text-center"> Update Item </h1>';
            echo '<div class="container">';

            $id = $_POST['id'];
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $member = $_POST['member'];
            $category = $_POST['category'];

            $stmt = $conn->prepare(" UPDATE 
                                        items 
                                    SET 
                                        `Name` = ?, `Description` = ? ,
                                        `Price` = ?, `Country_Made` = ? ,
                                        `Status`=?,`Cat_ID`=? ,`Member_ID`=? 
                                    WHERE 
                                         Item_iD=?");

            $stmt->execute(array($name, $desc, $price, $country, $status, $category, $member, $id));
            $MSG = '<div class= "alert alert-success">' . $stmt->rowCount() . ' ' . 'Recordes updated </div>';
            redirectFun($MSG, 'back');
        } else {
            $MSG = '<div class="alert alert-danger">You Cant Browse Update Page Directly</div>';
            redirectFun($MSG);
        }

        echo '</div>';
    } elseif ($do == 'Delete') {

        echo '<h1 class="text-center"> Delete Item </h1>';
        echo '<div class="container">';

        $id = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

        $check = checkItem('Item_ID', 'items', $id);

        if ($check > 0) {
            $stmt = $conn->prepare("DELETE FROM items WHERE Item_ID = ? ");
            $stmt->execute(array($id));
            $MSG =  '<div class= "alert alert-success">  ' . $check . '  Record Deleted Successfully </div>';
            redirectFun($MSG, 'back');
        } else {
            $MSG = '<div class= "alert alert-danger"> There is No Such ID </div>';
            redirectFun($MSG);
        }

        echo '</div>';
    } elseif ($do == 'Approve') {

        echo '<h1 class="text-center"> Update Item </h1>';
        echo '<div class="container">';


        $id = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

        $check = checkItem('Item_ID', 'items', $id);

        if ($check > 0) {

            $stmt = $conn->prepare(" UPDATE 
        items 
    SET 
        Approve = 1
    WHERE 
         Item_iD=?");

            $stmt->execute(array($id));
            $MSG = '<div class= "alert alert-success">' . $stmt->rowCount() . ' ' . 'Recordes updated </div>';
            redirectFun($MSG, 'back');
        } else {
            $MSG = '<div class= "alert alert-danger"> There is No Such ID </div>';
            redirectFun($MSG);
        }
    }


    include($tplt . 'footer.php');
} else {

    $MSG = '<div class="alert alert-danger">Please Sign in First</div>';
    redirectFun($MSG);
}
