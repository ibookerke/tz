<?php
$code ??= 500;
$msg ??= 'Server Error';
$err ??= '';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $msg ?></title>
</head>
<body>
    <h1><?= $code ?></h1>
    <p>
        <?= $msg ?>
    </p>
    <?php
    if(DEBUG_MODE) {
        echo "<pre>$err</pre>";
    }
    ?>
</body>
</html>
