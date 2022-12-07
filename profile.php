<?php

$pageTitle = 'profile';
include 'init.php';

if (isset($_SESSION['User'])) {

    $stmt = $conn->prepare("SELECT * FROM users WHERE Username = ? ");
    $stmt->execute(array($_SESSION['User']));
    $info = $stmt->fetch();
?>

    <h1 class="text-center"> <?php echo $_SESSION['User']; ?> Profile</h1>

    <div class="information block">
        <div class="container">
            <div class="card ">
                <div class="card-header">
                    My Information
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><span> Name </span> : <?php echo $info['Username']; ?> </li>
                        <li><span> Email </span> : <?php echo $info['Email']; ?> </li>
                        <li><span> Full Name </span> : <?php echo $info['FullName']; ?> </li>
                        <li><span> Register Date </span> : <?php echo $info['Date']; ?> </li>
                        <li><span> Favorite Category </span> :
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <div id="my_item" class="ads block">
        <div class="container">

            <div class="card ">
                <div class="card-header">
                    My Ads
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php
                        $items = getItems('Member_ID', $info['UserID']);
                        if ($items) {
                            foreach ($items as $item) {

                                echo '<div class="col-md-3 col-sm-6 items-control">';
                                echo '<img class="img-responsive" src="dress.jpg"/>';
                                echo '<div class="caption">';
                                echo '<span class="price">' . $item['Price'] . '</span>';
                                echo '<a href="items.php?itemid=' . $item['Item_ID'] . '"><h3>' . $item['Name'] . '</h3></a>';
                                echo '<p>' . $item['Description'] . '</p>';
                                echo '<div class="date">' . $item['Add_Date'] . '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo 'There Is No Items To Show .' . " " . '<a href="new_ads.php"> Create New Ads </a>';
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="comments block">
        <div class="container">

            <div class="card ">
                <div class="card-header">
                    My Comments
                </div>
                <div class="card-body">

                    <?php
                    $comments = getComments($info['UserID']);
                    if ($comments) {
                        foreach ($comments as $com) {

                            echo '<div class="comment-box">';
                            echo '<p class="member-c">' . $com['Comment'] . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo 'There Is No Comments To Show';
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>



<?php

} else {
    header("Location:login.php");
    exit();
}
include $tplt . 'footer.php';
?>