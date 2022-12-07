<?php

$pageTitle = 'index';
include 'init.php'; ?>


<div class="container">
    <h1 class="text-center"> All Items </h1>

    <div class="row">
        <?php
        $items = getAll('items', 'Item_ID');
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
</div>
<?php

include $tplt . 'footer.php';
?>