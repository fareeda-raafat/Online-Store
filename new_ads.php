<?php

$pageTitle = 'Create New Ads';
include 'init.php';

if (isset($_SESSION['User'])) {


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


        echo '<div class="container">';

        $name = $_POST['name'];
        $desc = $_POST['description'];
        $price = $_POST['price'];
        $country = $_POST['country'];
        $status = $_POST['status'];
        $category = $_POST['category'];
        $member = $_SESSION['ID'];

        $check = checkItem('Name', 'items', $name);

        if ($check > 0) {
            $MSG = '<div class="alert alert-danger">This Item Is Already Exist.</div>';
            echo ($MSG);
        } else {
            $stmt = $conn->prepare("INSERT INTO items 
        (`Name`,`Description`,`Price`,`Country_Made`,`Status`,`Add_Date`,`Cat_ID`,`Member_ID`) 
        VALUES (?,?,?,?,?,now(),?,?)");
            $stmt->execute(array($name, $desc, $price, $country, $status, $category, $member));
            $MSG = '<div class= "alert alert-success">' . $stmt->rowCount() . ' ' . 'Item Added Successfully </div>';
            echo ($MSG);

            echo '</div>';
        }
        // } else {
        //     $MSG = '<div class="alert alert-danger">You Cant Browse Insert Page Directly</div>';
        //     echo ($MSG);
        // }
    }
?>
    <h1 class="text-center"> Create New Ad</h1>
    <div class="create-ad block">
        <div class="container">

            <div class="card ">
                <div class="card-header">
                    Create Ad
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 new-ad-form">
                            <!-- Start of Create New Ad Form-->

                            <form class="form-horizental" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                                <!--start of Name feild -->
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-10">
                                        <input class="form-control live" type="text" name="name" required="required" data-class=".live-name">
                                    </div>
                                </div>
                                <!-- end of Name feild -->

                                <!--start of Description feild -->
                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-10">
                                        <input class="form-control live" type="text" name="description" data-class=".live-description">
                                    </div>
                                </div>
                                <!-- end of Description feild -->

                                <!--start of price feild -->
                                <div class="form-group">
                                    <label for="price" class="col-sm-2 control-label">Price</label>
                                    <div class="col-sm-10">
                                        <input class="form-control live" type="text" name="price" data-class=".live-price">
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

                                                echo '<option value="' . $cat['ID'] . '">' . $cat['Name'] . '</option>';
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

                            <!-- End of Create New Ad Form-->

                        </div>

                        <div class="col-md-4">
                            <div class="items-control live-preview">
                                <span class="price live-price">$0</span>
                                <img class="img-responsive" src="dress.jpg" />
                                <div class="caption">
                                    <h3 class="live-name">Item Name</h3>
                                    <p class="live-description">Description</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php
}

?>


<?php
include $tplt . 'footer.php';
?>