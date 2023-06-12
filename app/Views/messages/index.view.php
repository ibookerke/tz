<?php
$messages ??= [];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>

<nav>
    <a href="/messages/create">Create</a>
</nav>

<h1>index</h1>

<div>
    <table>
        <thead>
        <th>ID</th>
        <th>Message</th>
        </thead>
        <tbody>
        <?php
        foreach ($messages as $message) {
            echo "<tr>";
            echo "<td>$message->id</td>";
            echo "<td class='table__message_cell'>$message->message</td>";
            echo "</tr>";
        }
        ?>

        </tbody>
    </table>
</div>

</body>
</html>