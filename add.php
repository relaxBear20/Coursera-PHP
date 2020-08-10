<?php
session_start();

require_once('pdo.php');
if (!isset($_SESSION['user_id'])) {
    die("ACCESS DENIED");
} else if (isset($_POST['firstname'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $headline = $_POST['headline'];
    $summary = $_POST['summary'];
    $user_id = $_SESSION['user_id'];

    if ($firstname == '' || $lastname == '' || $email == '' || $headline == '' || $summary == '' || $firstname == null || $lastname == null || $email == null || $headline == null || $summary == null) {
        $_SESSION['error'] = 'All fields are required';
        header('Location: add.php');
        return;
    }


    if (strpos($email, '@') === false) {
        $_SESSION['error'] = 'Email address must contain @';
        header('Location: add.php');
        return;
    }

    $stmt = $pdo->prepare('INSERT INTO `profile`(`user_id`, `first_name`, `last_name`, `email`, `headline`, `summary`)  VALUES (:user_id,:firstname,:lastname,:email,:headline,:summary)');
    $stmt->execute(array(':firstname' => $firstname, ':lastname' => $lastname, ':email' => $email, ':headline' => $headline, ':summary' => $summary, ':user_id' => $user_id));

    $_SESSION['message'] = 'Profile added';
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Add</title>
</head>

<body>
    <?php
    if (isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }

    ?>
    <div>
        <form method="POST" action="add.php">
            First Name: <input type="text" name="firstname" id="firstname"><br>
            Last Name: <input type="text" name="lastname" id="lastname"><br>
            Email: <input type="text" name="email" id="email"><br>
            Headline: <br><input type="text" name="headline" id="headline"><br>
            Summary: <br><textarea name="summary" id="summary"></textarea><br>
            <button type="submit" onclick="return doValidate();">Add</button>
            <button type="submit" name="cancel" value="Cancel">Cancel</button>
        </form>
    </div>
    <script>
        function doValidate() {
            //TODO
        }
    </script>
</body>

</html>