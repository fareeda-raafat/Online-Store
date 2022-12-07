<?php
session_start();
$noNav = "";

$pageTitle = 'index';

if(isset($_SESSION['Username']))
{
    header('Locaton:dashboard.php');
}

include 'init.php';



if($_SERVER['REQUEST_METHOD']=='POST')
{
  $name = $_POST['user'];
  $pass = $_POST['pass'];
  $hashedPass = sha1($pass);
  

  


  $stmt = $conn->prepare("SELECT 
                              UserID , Username , Password 
                          FROM 
                               users 
                          WHERE 
                               Username= ? 
                          AND 
                              Password = ? 
                          AND 
                              GroupID = '1'
                          LIMIT 1 " );
  $stmt->execute(array($name,$hashedPass));
  $row = $stmt->fetch();
  $count = $stmt->rowCount();


  if($count > 0 )
  {
    $_SESSION['Username']=$name;
    $_SESSION['ID']=$row['UserID'];
    header('Location:dashboard.php');
    exit();
  }


}

?>



<form class="login d-grid gap-3 input-group-lg" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
    <h3 class="text-center"> Login Form </h3>
    <input class="form-control " type="text" name="user" placeholder="username" autocomplete="off">
    <input class="form-control " type="password" name="pass" placeholder="password" autocomplete="new-password">
    <input class="btn " type="submit" value="Login"/>
</form>

<?php
include $tplt.'footer.php';
?>
