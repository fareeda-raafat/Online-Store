<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="../index.php">Online Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="app-nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="dashboard.php"><?php echo lang('HOME_PAGE') ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="categories.php"><?php echo lang('CATEGORY') ?></a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="items.php"><?php echo lang('ITEMS') ?></a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="members.php"><?php echo lang('MEMBERS') ?></a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="comments.php"><?php echo lang('COMMENTS') ?></a>
        </li>


        <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION['Username'] ?>
          </a>
          <ul class="dropdown-menu ">
            <li><a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['ID']; ?>"><?php echo lang('PROFILE') ?></a></li>
            <li><a class="dropdown-item" href="#"><?php echo lang('SETTING') ?></a></li>
            <li><a class="dropdown-item" href="logout.php"><?php echo lang('LOG_OUT') ?></a></li>
          </ul>
        </li>

      </ul>

    </div>
  </div>
</nav>