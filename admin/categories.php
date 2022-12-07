<?php

session_start();
if (isset($_SESSION['Username'])) {

    $pageTitle = 'Categories';

    include('init.php');

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {

        $sort = 'ASC';
        $sort_arr = array('ASC', 'DESC');

        if (isset($_GET['order']) && in_array($_GET['order'], $sort_arr)) {
            $sort = $_GET['order'];
        }

        $stmt = $conn->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY ordering $sort");
        $stmt->execute();
        $cats = $stmt->fetchAll();


?>

        <h1 class="text-center">Manage Categories</h1>

        <div class="container ">

            <div class="card categories">
                <div class="card-header cat-head">
                    Categories


                    <div class="ordering">
                        Ordering :
                        <a class="<?php if ($sort == 'ASC') {
                                        echo 'active';
                                    } ?>" href="?order=ASC">ASC</a> |
                        <a class="<?php if ($sort == 'DESC') {
                                        echo 'active';
                                    } ?>" href="?order=DESC">DESC</a>

                    </div>

                    <div class="view">
                        View :
                        <span data-view="full" class="active"> Full </span> |
                        <span> Classic </span>
                    </div>



                </div>
                <div class="card-body">
                    <?php

                    foreach ($cats as $cat) {
                        echo '<div class ="cat">';
                        echo '<h4>' . $cat['Name'] . '</h4>';

                        echo '<div class="full-view">';

                        echo '<p>';
                        if ($cat['Description'] == '') {
                            echo 'This Category With No Description';
                        } else {
                            echo  $cat['Description'];
                        }
                        echo '</p>';

                        if ($cat['Visibility'] == 1) {
                            echo '<span class="visible">Hidden</span>';
                        }
                        if ($cat['Allow_Comment'] == 1) {
                            echo '<span class="comment">Comment Disable</span>';
                        }
                        if ($cat['Allow_Ads'] == 1) {
                            echo '<span class="ads">Ads Disable</span>';
                        }
                        echo '</div>';

                        echo '<div class="hidden-btn">';
                        echo '<a href="categories.php?do=Edit&catid=' . $cat['ID'] . '" class="btn btn-success">Edit</a>';
                        echo '<a href="categories.php?do=Delete&catid=' . $cat['ID'] . '" class="btn  btn-danger confirm">Delete</a>';
                        echo '</div>';


                        $parent =  $cat['ID'];
                        $stmt = $conn->prepare("SELECT * FROM categories WHERE parent = $parent ORDER BY ordering $sort");
                        $stmt->execute();
                        $child_cats = $stmt->fetchAll();
                        if ($child_cats) {
                            foreach ($child_cats as $child) {
                                echo '<div class="child-cat" >';
                                echo '<h6>Child Category</h6>';
                                echo '<ul >';
                                echo '<li>';
                                echo '<a href="categories.php?do=Edit&catid=' . $child['ID'] . '"><h6>' . $child['Name'] . '</h6></a>';
                                echo '</li>';
                                echo '</ul>';
                                echo '</div>';
                            }
                        }
                        echo '</div>';
                    }
                    ?>

                </div>
            </div>
            <a class="btn btn-primary add-btn" href="categories.php?do=Add"> <i class="fa fa-plus"></i> New Category</a>
        </div>

    <?php
    } elseif ($do == 'Add') {

    ?>



        <div class="container">
            <h1 class="text-center"> Add New Category</h1>

            <form class="form-horizental" action="Categories.php?do=Insert" method="POST">

                <!--start of Name feild -->
                <div class="form-group">
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


                <!--start of Parent feild -->
                <div class="form-group">
                    <label for="parent" class="col-sm-2 control-label">Parent</label>
                    <div class="col-sm-10">
                        <select name="parent" class="form-control">
                            <option value="0">None</option>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM categories WHERE parent = 0 ");
                            $stmt->execute();
                            $cats = $stmt->fetchAll();

                            foreach ($cats as $cat) {
                                echo '<option value="' . $cat['ID'] . '">' . $cat['Name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- end of Parent feild -->

                <!--start of Ordering feild -->
                <div class="form-group">
                    <label for="ordering" class="col-sm-2 control-label">Ordering</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="ordering">
                    </div>
                </div>
                <!-- end of Ordering feild -->

                <!--start of Visibility feild -->
                <div class="form-group">
                    <label for="visibile" class="col-sm-2 control-label">Visibile</label>
                    <div class="col-sm-10">
                        <input id="vis_yes" type="radio" name="visibile" value="0" checked>
                        <label for="vis_yes">Yes</label>
                    </div>
                    <div class="col-sm-10">
                        <input id="vis_no" type="radio" name="visibile" value="1">
                        <label for="vis_no">No</label>
                    </div>
                </div>
                <!-- end of Visibility feild -->

                <!--start of Commenting feild -->
                <div class="form-group">
                    <label for="commenting" class="col-sm-2 control-label">Allow_Comment</label>
                    <div class="col-sm-10">
                        <input id="com_yes" type="radio" name="commenting" value="0" checked>
                        <label for="com_yes">Yes</label>
                    </div>
                    <div class="col-sm-10">
                        <input id="com_no" type="radio" name="commenting" value="1">
                        <label for="com_no">No</label>
                    </div>
                </div>
                <!-- end of Comments feild -->

                <!--start of Ads feild -->
                <div class="form-group">
                    <label for="ads" class="col-sm-2 control-label">Allow_Ads</label>
                    <div class="col-sm-10">
                        <input id="Ads_yes" type="radio" name="ads" value="0" checked>
                        <label for="Ads_yes">Yes</label>
                    </div>
                    <div class="col-sm-10">
                        <input id="Ads_no" type="radio" name="ads" value="1">
                        <label for="Ads_no">No</label>
                    </div>
                </div>
                <!-- end of Ads feild -->

                <!--start of submit feild -->
                <div class="form-group">

                    <input class="btn btn-primary " type="submit" name="add" value="Add Category" class="form-control">
                </div>
                <!-- end of submit feild -->


            </form>
        </div>

        <?php
    } elseif ($do == 'Insert') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $name =  $_POST['name'];
            $desc =  $_POST['description'];
            $parent =  $_POST['parent'];
            $order =  $_POST['ordering'];
            $visibile =  $_POST['visibile'];
            $comment =  $_POST['commenting'];
            $ads =  $_POST['ads'];


            $check = checkItem('Name', 'categories', $name);

            if ($check > 0) {
                $MSG = '<div class="alert alert-danger">This Category Is Already Exist.</div>';
                redirectFun($MSG, 'back');
            } else {

                $stmt = $conn->prepare("INSERT INTO categories
            (Name,Description,parent,Ordering,Visibility,Allow_Comment,Allow_Ads)
          VALUES (?,?,?,?,?,?,?)");

                $stmt->execute(array($name, $desc, $parent, $order, $visibile, $comment, $ads));

                $MSG = '<div class="alert alert-success"> Category Added Successfully.</div>';
                redirectFun($MSG, 'back');
            }
        } else {
            $MSG = '<div class="alert alert-danger">You Cant Browse Insert Page Directly</div>';
            redirectFun($MSG);
        }
    } elseif ($do == 'Edit') {


        $catID = (isset($_GET['catid']) && is_numeric($_GET['catid'])) ? intval($_GET['catid']) : 0;

        $stmt = $conn->prepare("SELECT * FROM categories WHERE ID = ?");
        $stmt->execute(array($catID));
        $cat = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {


        ?>
            <div class="container">
                <h1 class="text-center"> Edit Category</h1>

                <form class="form-horizental" action="Categories.php?do=Update" method="POST">

                    <input type="hidden" name="catID" value="<?php echo $cat['ID']; ?>">
                    <!--start of Name feild -->
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="name" value="<?php echo $cat['Name']; ?>" required="required">
                        </div>
                    </div>
                    <!-- end of Name feild -->

                    <!--start of Description feild -->
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="description" value="<?php echo $cat['Description']; ?>">
                        </div>
                    </div>
                    <!-- end of Description feild -->



                    <!--start of Parent feild -->
                    <div class="form-group">
                        <label for="parent" class="col-sm-2 control-label">Parent</label>
                        <div class="col-sm-10">
                            <select name="parent" class="form-control">
                                <option value="0">None</option>
                                <?php
                                $stmt = $conn->prepare("SELECT * FROM categories WHERE parent = 0 ");
                                $stmt->execute();
                                $addcats = $stmt->fetchAll();

                                foreach ($addcats as $addcat) {
                                    echo '<option value="' . $addcat['ID'] . '"';
                                    if ($cat['parent'] == $addcat['parent']) {
                                        echo 'selected';
                                    }
                                    echo '>' . $addcat['Name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- end of Parent feild -->

                    <!--start of Ordering feild -->
                    <div class="form-group">
                        <label for="ordering" class="col-sm-2 control-label">Ordering</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="ordering" value="<?php echo $cat['Ordering']; ?>">
                        </div>
                    </div>
                    <!-- end of Ordering feild -->

                    <!--start of Visibility feild -->
                    <div class="form-group">
                        <label for="visibile" class="col-sm-2 control-label">Visibile</label>
                        <div class="col-sm-10">
                            <input id="vis_yes" type="radio" name="visibile" value="0" <?php if ($cat['Visibility'] == 0) {
                                                                                            echo 'checked';
                                                                                        } ?>>
                            <label for="vis_yes">Yes</label>
                        </div>
                        <div class="col-sm-10">
                            <input id="vis_no" type="radio" name="visibile" value="1" <?php if ($cat['Visibility'] == 1) {
                                                                                            echo 'checked';
                                                                                        } ?>>
                            <label for="vis_no">No</label>
                        </div>
                    </div>
                    <!-- end of Visibility feild -->

                    <!--start of Commenting feild -->
                    <div class="form-group">
                        <label for="commenting" class="col-sm-2 control-label">Allow_Comment</label>
                        <div class="col-sm-10">
                            <input id="com_yes" type="radio" name="commenting" value="0" <?php if ($cat['Allow_Comment'] == 0) {
                                                                                                echo 'checked';
                                                                                            } ?>>
                            <label for="com_yes">Yes</label>
                        </div>
                        <div class="col-sm-10">
                            <input id="com_no" type="radio" name="commenting" value="1" <?php if ($cat['Allow_Comment'] == 1) {
                                                                                            echo 'checked';
                                                                                        } ?>>
                            <label for="com_no">No</label>
                        </div>
                    </div>
                    <!-- end of Comments feild -->

                    <!--start of Ads feild -->
                    <div class="form-group">
                        <label for="ads" class="col-sm-2 control-label">Allow_Ads</label>
                        <div class="col-sm-10">
                            <input id="Ads_yes" type="radio" name="ads" value="0" <?php if ($cat['Allow_Ads'] == 0) {
                                                                                        echo 'checked';
                                                                                    } ?>>
                            <label for="Ads_yes">Yes</label>
                        </div>
                        <div class="col-sm-10">
                            <input id="Ads_no" type="radio" name="ads" value="1" <?php if ($cat['Allow_Ads'] == 1) {
                                                                                        echo 'checked';
                                                                                    } ?>>
                            <label for="Ads_no">No</label>
                        </div>
                    </div>
                    <!-- end of Ads feild -->

                    <!--start of submit feild -->
                    <div class="form-group">

                        <input class="btn btn-primary " type="submit" name="edit" value="Edit Category" class="form-control">
                    </div>
                    <!-- end of submit feild -->


                </form>
            </div>

<?php
        } else {
            $MSG = '<div class="alert alert-danger">There Is No Such ID.</div>';
            redirectFun($MSG);
        }
    } elseif ($do == 'Update') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $ID1 = $_POST['catID'];
            $name1 =  $_POST['name'];
            $desc1 =  $_POST['description'];
            $parent1 =  $_POST['parent'];
            $order1 =  $_POST['ordering'];
            $visibile1 =  $_POST['visibile'];
            $comment1 =  $_POST['commenting'];
            $ads1 =  $_POST['ads'];

            // echo $ID . $name, $desc, $order, $visibile, $comment, $ads;

            $stmt = $conn->prepare(" UPDATE 
                                           `categories` 
                                     SET 
                                       `Name`=? , `Description`=? ,`parent`=? , `Ordering`=?
                                      ,`Visibility`=? , `Allow_Comment`=? ,
                                       `Allow_Ads`=? WHERE `ID`=?");

            $stmt->execute(array($name1, $desc1, $parent1, $order1, $visibile1, $comment1, $ads1, $ID1));

            $count = $stmt->rowCount();
            $MSG = '<div class="alert alert-success">' . $count . ' Category Updated Successfuly.</div>';
            redirectFun($MSG, 'back');
        } else {
            $MSG = '<div class="alert alert-danger">You Cant Browse Insert Page Directly</div>';
            redirectFun($MSG);
        }
    } elseif ($do == 'Delete') {


        echo '<h1 class="text-center"> Delete Members </h1>';
        echo '<div class="container">';


        $catID = (isset($_GET['catid']) && is_numeric($_GET['catid'])) ? intval($_GET['catid']) : 0;


        $check = checkItem('ID', 'categories', $catID);
        if ($check > 0) {

            $stmt = $conn->prepare("DELETE FROM `categories` WHERE `ID`=?");
            $stmt->execute(array($catID));


            $MSG = '<div class="alert alert-success">' . $check . ' Category Has Deleted Successfuly.</div>';
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
