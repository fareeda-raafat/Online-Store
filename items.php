<?php
session_start();
$User = $_SESSION['User'];
$Profileid = $_SESSION['ID'];
$pageTitle = 'Show-Item';
include 'init.php';

$item_id = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

$stmt = $conn->prepare("SELECT 
                            items.*,categories.Name AS category_name,users.Username
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
                        WHERE
                            Item_ID = ?
                       ");
$stmt->execute(array($item_id));
$item = $stmt->fetch();
$count = $stmt->rowCount();
if ($count > 0) {


?>
    <h1 class="text-center"><?php echo $item['Name'] ?></h1>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <img class="img-responsive" src="dress.jpg" />
            </div>
            <div class="col-md-8">
                <div class="caption">
                    <ul class="list-unstyled">
                        <li>
                            <span>Name :</span> <?php echo $item['Name'] ?>
                        </li>
                        <li>
                            <span>Description :</span> <?php echo $item['Description'] ?>
                        </li>
                        <li>
                            <span>Price :</span> <?php echo $item['Price'] ?>
                        </li>
                        <li>
                            <span>Date :</span><?php echo $item['Add_Date'] ?>
                        </li>
                        <li>
                            <span>Country :</span><?php echo $item['Country_Made'] ?>
                        </li>
                        <li>
                            <span>Category :</span><?php echo $item['category_name'] ?>
                        </li>
                        <li>
                            <span>Added By :</span><?php echo $item['Username'] ?>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-5">
                <div class="add-comment">
                    <h3 class="text-center">Type Your Comment</h3>
                    <form action="<?php $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID'];  ?>" method="POST">
                        <textarea class="commet" name="comment" cols="50" rows="5" required></textarea>
                        <input class="btn btn-primary" type="submit" value="Save" name="submit">
                    </form>
                    <?php

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $comment = $_POST['comment'];
                        $itemid = $item['Item_ID'];


                        if (isset($comment)) {
                            $stmt = $conn->prepare("INSERT 
                                                 INTO comments 
                                                    (Comment,Status,Comment_Date,item_id,user_id) 
                                                 VALUES 
                                                    (?,0,now(),?,?)");
                            $stmt->execute(array($comment, $itemid, $Profileid));
                            if ($stmt) {
                                echo '<div class = "alert alert-success"> Comment Added Successfuly.</div>';
                            } else {
                                echo '<div class = "alert alert-danger">Comment Not Added.</div>';
                            }
                        }
                    }
                    ?>

                </div>

            </div>


        </div>
        <hr>
        <div class="row">
            <div class="col-md-5">

                <?php
                $stmt = $conn->prepare("SELECT comments.*,users.Username
                                           FROM comments
                                           INNER JOIN 
                                           users
                                           ON
                                           comments.user_id = users.UserID
                                           WHERE item_id = ?");
                $stmt->execute(array($item_id));
                $comments = $stmt->fetchAll();

                $count = $stmt->rowCount();
                if ($count > 0) {

                    foreach ($comments as $comment) {
                        echo '<div class = "row">';
                        echo '<div class = "col-md-3">' . $comment['Username'] . '</div>';
                        echo '<div class = "col-md-9">' . $comment['Comment'] . '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class = "alert alert-danger">There Is No Comments For This Item</div>';
                }
                ?>
            </div>
        </div>
    </div>
<?php
} else {
    echo 'There is No Such Item';
}
include $tplt . 'footer.php';
?>