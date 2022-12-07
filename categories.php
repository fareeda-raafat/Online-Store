<?php

$pageTitle = 'categories';

include 'init.php'; ?>

<div class="container">
    <?php
    if (isset($_GET['pagename']) && isset($_GET['pageid'])) {
    ?>
        <h1 class="text-center"> <?php echo $_GET['pagename'] ?> </h1>

        <div class="row">
            <?php
            $items = getItems('Cat_ID', $_GET['pageid']);
            foreach ($items as $item) {
                echo '<div class="col-md-3 col-sm-6">';
                echo '<img class="img-responsive" src="dress.jpg"/>';
                echo '<div class="caption">';
                echo '<span class="price">' . $item['Price'] . '</span>';
                echo '<a href="items.php?itemid=' . $item['Item_ID'] . '"><h3>' . $item['Name'] . '</h3></a>';
                // echo '<h3>' . $item['Name'] . '</h3>';
                echo '<p>' . $item['Description'] . '</p>';
                echo '</div>';
                echo '</div>';
            } ?>
        </div>
    <?php
    } else {
    ?>
        <h1 class="text-center"> All Categories </h1>

        <div class="row">
            <?php
            $cats = getAll('categories', 'ID');
            foreach ($cats as $cat) {
                echo '<div class="col-md-3 col-sm-6">';
                echo '<img class="img-responsive" src="dress.jpg"/>';
                echo '<div class="caption">';
                echo '<a  href="categories.php?pageid=' . $cat['ID'] . '&pagename=' . $cat['Name'] . '"><h3>' . $cat['Name'] . '</h3></a>';
                echo '<p>' . $cat['Description'] . '</p>';
                echo '</div>';
                echo '</div>';
            } ?>
        </div>
    <?php
    }
    ?>
</div>
<?php

include $tplt . 'footer.php';
?>