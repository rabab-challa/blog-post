<?php

session_start();

require_once("../config/db.php");

$result = $conn->query(
    "SELECT username, points
     FROM users
     ORDER BY points DESC"
);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Leaderboard</title>
</head>
<body>

<h2>🏆 Leaderboard</h2>

<table border="1" cellpadding="10">

    <tr>
        <th>Rank</th>
        <th>Username</th>
        <th>Points</th>
    </tr>

<?php

$rank = 1;

while($row = $result->fetch_assoc())
{
?>

<tr>

    <td>
        <?php echo $rank++; ?>
    </td>

    <td>
        <?php echo htmlspecialchars($row['username']); ?>
    </td>

    <td>
        <?php echo $row['points']; ?>
    </td>

</tr>

<?php
}
?>

</table>

<br>

<a href="dashboard.php">
    Back to Dashboard
</a>

</body>
</html>