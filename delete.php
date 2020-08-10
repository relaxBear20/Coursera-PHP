<?php
require_once('pdo.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    die('ACCESS DENIED');
}

if(isset($_POST['delete'])) {
    $profile_id = $_POST['delete'];
    $stmt = $pdo->prepare('DELETE FROM `profile` WHERE `profile_id` = :pid');
    $stmt -> execute(array(':pid' => $profile_id));
    
    $_SESSION['message'] = 'Profile deleted';
    header('Location: index.php');
    return;
}
if(isset($_POST['cancel'])) {
    header('Location: index.php');
    return ;
}
$profile_id = $_GET['profile_id'];
$stmt = $pdo->prepare('SELECT `first_name`, `last_name` FROM `profile` WHERE `profile_id` = :pid');
$stmt->execute(array(':pid' => $profile_id));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$firstname = $row['first_name'];
$lastname = $row['last_name'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Delete</title>
</head>

<body>

    <div>
        <h1>Deleteing Profile</h1>
        <?php
        echo 'firstname: '.$firstname.'<br>';
        echo 'lastname: '.$lastname;
        ?>
        <form method="POST" action="delete.php">
        <button type="submit" name="delete" value="<?php echo $profile_id?>">Delete</button>
        <button type="submit" name="cancel" value="Cancel">Cancel</button>
        </form>
        
    </div>
</body>

</html>