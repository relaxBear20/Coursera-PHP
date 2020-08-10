<?php


require_once('pdo.php');

$stmt = $pdo->prepare('SELECT * FROM profile WHERE 1');
$stmt->execute(array());


if (isset($_SESSION['user_id'])) {
    echo '<table border="1 solid black" style ="border-collapse: collapse">';
    echo "<tr><th>Name</th><th>Headline</th><th>Action</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>";
        echo (htmlentities($row['last_name']) . ' ' . htmlentities($row['first_name']));
        echo ("</td><td>");
        echo (htmlentities($row['headline']));
        echo ("</td><td>");
        echo ('<a href="edit.php?profile_id=' . $row['profile_id'] . '">Edit</a> / ');
        echo ('<a href="delete.php?profile_id=' . $row['profile_id'] . '">Delete</a>');
        echo ("</td></tr>\n");
    }
    echo '</table>';
    echo ('<a href="add.php?user_id=' . $_SESSION['user_id'] . '">Add New Entry</a>  ');

} else {
    echo '<table border="1 solid black">';
    echo "<tr><th>Name</th><th>Headline</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>";
        echo (htmlentities($row['last_name']) . ' ' . htmlentities($row['first_name']));
        echo ("</td><td>");
        echo (htmlentities($row['headline']));
        echo ("</td></tr>\n");
    }
    echo '</table>';
}
