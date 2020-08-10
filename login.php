<?php

require_once 'pdo.php';

session_start();
unset($_SESSION['name']);
unset($_SESSION['user_id']);

if (isset($_POST['cancel'])) {
    header('Location: index.php');
    return;
}
if (isset($_POST['pwd']) && isset($_POST['email'])) {
    $salt = 'XyZzy12*_';
    $check = hash('md5', $salt . $_POST['pwd']);
    $stmt = $pdo->prepare('SELECT user_id, name FROM users
            WHERE email = :em AND password = :pw');
    $stmt->execute(array(':em' => $_POST['email'], ':pw' => $check));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    

    if ($row !== false) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        // Redirect the browser to index.php
        
        header("Location: index.php");
        return;
    } else {
        $_SESSION['error'] = "incorrect password";
        header("Location: login.php");
        return;
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>


    <?php
    if (isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }

    ?>
    <form method="POST" action="login.php">
        <div style="margin: auto;">
            <h2>Please Log In</h2>
            Email <input type="text" name="email" id="email"><br>
            Passwor <input type="password" name="pwd" id="pwd"><br>
            <button type="submit" onclick="return doValidate();">Log In</button>
            <button type="submit" name="cancel" value="Cancel">Cancel</button>
        </div>
    </form>
    <script>
        function doValidate() {
            console.log('Validating...');
            try {
                addr = document.getElementById('email').value;
                pw = document.getElementById('pwd').value;
                console.log("Validating addr=" + addr + " pw=" + pw);
                if (addr == null || addr == "" || pw == null || pw == "") {
                    alert("Both fields must be filled out");
                    return false;
                }
                if (addr.indexOf('@') == -1) {
                    alert("Invalid email address");
                    return false;
                }
                return true;
            } catch (e) {
                alert(e);
                return false;
            }
            return false;
        }
    </script>
</body>

</html>