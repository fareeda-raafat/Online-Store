<?php
session_start();
if (isset($_SESSION['Username'])) {

    $pageTitle = 'Comments';
    include('init.php');

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {

        $stmt = $conn->prepare("SELECT 
                                    comments.*,
                                    items.Name AS item_name,
                                    users.Username
                                FROM 
                                    comments
                                INNER JOIN
                                    items 
                                ON 
                                    items.Item_ID = comments.item_id
                                INNER JOIN
                                    users
                                ON
                                    users.UserID = comments.user_id

                                 ");
        $stmt->execute();
        $rows = $stmt->fetchAll();

?>
        <h1 class="text-center"> Manage Comments </h1>
        <div class="container">

            <div class="table-responsive">
                <table class="main-table table text-center table-bordered">

                    <tr class="first">
                        <td>#ID</td>
                        <td>Comment</td>
                        <td>Comment Date</td>
                        <td>Item</td>
                        <td>Member</td>
                        <td>Control</td>
                    </tr>

                    <?php

                    foreach ($rows as $row) {
                        echo '<tr>';
                        echo '<td>' . $row['ComID'] . '</td>';
                        echo '<td>' . $row['Comment'] . '</td>';
                        echo '<td>' . $row['Comment_Date'] . '</td>';
                        echo '<td>' . $row['item_name'] . '</td>';
                        echo '<td>' . $row['Username'] . ' </td>';
                        echo
                        '<td>
                        <a href="comments.php?do=Edit&comid=' . $row['ComID'] . '" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                        <a href="comments.php?do=Delete&comid=' . $row['ComID'] . '" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>';

                        if ($row['Status'] == 0) {
                            echo '<a href="comments.php?do=Approve&comid=' . $row['ComID'] . '" class="btn btn-primary approve "><i class="fa fa-check"></i>Approve</a>';
                        }
                        echo '</td>';


                        echo '</tr>';
                    }
                    ?>

                </table>

            </div>
        </div>


        <?php
    } elseif ($do == 'Edit') {


        $id = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;


        $stmt = $conn->prepare("SELECT * FROM comments WHERE ComID = ? ");
        $stmt->execute(array($id));
        $row = $stmt->fetch();
        $counter = $stmt->rowCount();

        if ($counter > 0) {

        ?>


            <h1 class="text-center"> Edit Comment </h1>
            <div class="container" style="width: 900px ;">
                <form class="form-horizental" action="comments.php?do=Update" method="POST">

                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <!--start of Comment feild -->
                    <div class="form-group" style="position: relative;">
                        <label for="comment" class="col-sm-2 control-label">Comment</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="comment" required="required"><?php echo $row['Comment']; ?></textarea>
                        </div>
                    </div>
                    <!-- end of Comment feild -->

                    <!--start of submit feild -->
                    <div class="form-group">

                        <input class="btn btn-primary " type="submit" name="edit" value="Edit Item" class="form-control">
                    </div>
                    <!-- end of submit feild -->


                </form>
            </div>

<?php

        } else {
            $MSG = '<div class="alert alert-danger">There Is No Such ID</div>';
            redirectFun($MSG);
        }
    } elseif ($do == 'Update') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo '<h1 class="text-center"> Update Comment </h1>';
            echo '<div class="container">';

            $id = $_POST['id'];
            $comment = $_POST['comment'];


            $stmt = $conn->prepare(" UPDATE 
                                        comments 
                                    SET 
                                        `comment` = ?
                                    WHERE 
                                         ComID = ?");

            $stmt->execute(array($comment, $id));
            $MSG = '<div class= "alert alert-success">' . $stmt->rowCount() . ' ' . 'Recordes updated </div>';
            redirectFun($MSG, 'back');
        } else {
            $MSG = '<div class="alert alert-danger">You Cant Browse Update Page Directly</div>';
            redirectFun($MSG);
        }

        echo '</div>';
    } elseif ($do == 'Delete') {

        echo '<h1 class="text-center"> Delete Comment </h1>';
        echo '<div class="container">';

        $id = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

        $check = checkItem('ComID', 'comments', $id);

        if ($check > 0) {
            $stmt = $conn->prepare("DELETE FROM comments WHERE ComID = ? ");
            $stmt->execute(array($id));
            $MSG =  '<div class= "alert alert-success">  ' . $check . '  Record Deleted Successfully </div>';
            redirectFun($MSG, 'back');
        } else {
            $MSG = '<div class= "alert alert-danger"> There is No Such ID </div>';
            redirectFun($MSG);
        }

        echo '</div>';
    } elseif ($do == 'Approve') {


        echo '<h1 class="text-center"> Approve Comment </h1>';
        echo '<div class="container">';


        $id = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

        $check = checkItem('ComID', 'comments', $id);

        if ($check > 0) {

            $stmt = $conn->prepare(" UPDATE 
        comments 
    SET 
        `Status` = 1
    WHERE 
         ComID=?");

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
?>