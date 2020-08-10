
<?php session_start() ?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>

<div>
    <h1>Lai Phu Duc Long's Resume Registry</h1>
    <?php
    if(isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
    if(isset($_SESSION['user_id'])) {
        echo '<form action="logout.php"><input type="submit" href="" value="logout" /></form>';
    } else {
        echo '<form action="login.php"><input type="submit" href="" value="login" /></form>';
    }
    ?>

    <?php include 'view.php' ?>
</div>

</body>

</html>