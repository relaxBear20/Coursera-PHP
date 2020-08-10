<?php
require_once('pdo.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    die('ACCESS DENIED');
}

if (isset($_POST['cancel'])) {
    header('Location: index.php');
    return;
}



if (isset($_POST['edit'])) {

    $profile_id = $_POST['edit'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $headline = $_POST['headline'];
    $summary = $_POST['summary'];

    if ($firstname == '' || $lastname == '' || $email == '' || $headline == '' || $summary == '' || $firstname == null || $lastname == null || $email == null || $headline == null || $summary == null) {
        $_SESSION['error'] = 'All fields are required';
        header('Location: edit.php?profile_id='. $profile_id);
        return;
    }


    if (strpos($email, '@') === false) {
        $_SESSION['error'] = 'Email address must contain @';
        header('Location: edit.php?profile_id='. $profile_id);
        return;
    }

    $stmt = $pdo->prepare('UPDATE `profile` SET
    `first_name`=:firstname,
    `last_name`=:lastname,`email`=:email,
    `headline`=:headline,`summary`=:summary 
    WHERE `profile_id`=:pid');
    $stmt->execute(array(':firstname' => $firstname, ':lastname' => $lastname, ':email' => $email, ':headline' => $headline, ':summary' => $summary ,':pid' => $profile_id));

    $_SESSION['message'] = 'Profile updated';
    header('Location: index.php');
    return;
}


$profile_id = $_GET['profile_id'];
$stmt = $pdo->prepare('SELECT * FROM `profile` WHERE `profile_id` = :pid');
$stmt->execute(array(':pid' => $profile_id));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$firstname = $row['first_name'];
$lastname = $row['last_name'];
$email = $row['email'];
$headline = $row['headline'];
$summary = $row['summary'];
$user_id = $row['user_id'];

?>

<!DOCTYPE html>
<html>

<head>
    <title>Delete</title>
</head>

<body>
<?php
    if (isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }

    ?>

    <div>
        <form method="POST" action="edit.php">
            First Name: <input type="text" name="firstname" id="firstname" value="<?php echo $firstname ?>"><br>
            Last Name: <input type="text" name="lastname" id="lastname" value="<?php echo $lastname ?>"><br>
            Email: <input type="text" name="email" id="email" value="<?php echo $email ?>"><br>
            Headline: <br><input type="text" name="headline" id="headline" value="<?php echo $headline ?>"><br>
            Summary: <br><textarea name="summary" id="summary"><?php echo $summary ?></textarea><br>
            <button type="submit" name="edit" value="<?php echo $_GET['profile_id'] ?>" onclick="return doValidate();">Edit</button>
            <button type="submit" name="cancel" value="Cancel">Cancel</button>
        </form>

        <script>
            function doValidate() {
                
            }
        </script>
</body>

</html>