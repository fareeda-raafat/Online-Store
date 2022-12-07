<?php
session_start();

if (isset($_SESSION['Username'])) {
    $pageTitle = 'Dashboard';
    include 'init.php';

    $latestMembers = getLatest('*', 'users', 'UserID');
    $latestItems = getLatest('*', 'items', 'Item_ID', 6);


?>
    <!-- Start of DashBoard -->


    <div class="container home-stats text-center">
        <h1> DashBoard </h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat st-member">
                    <p>Total Members</p>
                    <span><a href="members.php"><?php echo countItem('UserID', 'users'); ?></a></span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat st-pending">
                    <p>Pending Members</p>
                    <span><a href="members.php?do=Manage&page=Pending"> <?php echo checkItem('RegStatus', 'users', 0); ?></a></span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat st-item">
                    <p>Total Items</p>
                    <span><a href="items.php?do=Manage"> <?php echo countItem('Item_ID', 'items'); ?></a></span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat st-coment">
                    <p>Total Comments</p>
                    <span><a href="comments.php?do=Manage"> <?php echo countItem('ComID', 'comments'); ?></a></span>

                </div>
            </div>

        </div>
    </div>

    <div class="container latest">
        <div class="row">
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header">
                        <i class="fa fa-users"></i> Latest Registerd Useres
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled latest-user">
                            <?php
                            foreach ($latestMembers as $member) {

                                echo '<li>' . $member['Username'];

                                echo   '<a href="members.php?do=Edit&userid=' . $member['UserID'] . '">';
                                echo '<div class="edit-user">';
                                echo   '<span class="btn btn-success ">';
                                echo      'Edit';
                                echo   '</span>';
                                echo '</div>';
                                echo   '</a>';

                                if ($member['RegStatus'] == 0) {
                                    echo   '<a href="members.php?do=Activate&userid=' . $member['UserID'] . '">';
                                    echo '<div class="active-user">';
                                    echo   '<span class="btn btn-primary">';
                                    echo      'Activate';
                                    echo   '</span>';
                                    echo '</div>';
                                    echo   '</a>';
                                }
                                echo   '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header">
                        <i class="fa-solid fa-tag"></i> Latest Items
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled latest-user">
                            <?php
                            foreach ($latestItems as $item) {

                                echo '<li>' . $item['Name'];

                                echo   '<a href="items.php?do=Edit&itemid=' . $item['Item_ID'] . '">';
                                echo '<div class="edit-user">';
                                echo   '<span class="btn btn-success ">';
                                echo      'Edit';
                                echo   '</span>';
                                echo '</div>';
                                echo   '</a>';

                                if ($item['Approve'] == 0) {
                                    echo   '<a href="items.php?do=Approve&itemid=' . $item['Item_ID'] . '">';
                                    echo '<div class="active-user approve-item">';
                                    echo   '<span class="btn btn-primary">';
                                    echo      'Activate';
                                    echo   '</span>';
                                    echo '</div>';
                                    echo   '</a>';
                                }
                                echo   '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="container latest">
        <div class="row">
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header">
                        <i class="fa fa-users"></i> Latest Comments
                    </div>
                    <div class="card-body">

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
                                              "
                        );

                        $stmt->execute();
                        $coms = $stmt->fetchAll();


                        foreach ($coms as $com) {

                            echo '<div class="comment-box">';
                            echo '<a class="member-n" href="comments.php?do=Manage">' . $com['Username'] . '</a>';
                            echo '<p class="member-c">' . $com['Comment'] . '</p>';
                            echo '</div>';
                        }
                        ?>

                    </div>
                </div>
            </div>
            <!-- End of DashBoard -->
        <?php
        include $tplt . 'footer.php';
    } else {
        header('Location:index.php');
        exit();
    }
        ?>