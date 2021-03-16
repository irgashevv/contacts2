<?php
$url = $_SERVER['REQUEST_URI'];

if($url == '/?model=contacts&action=read' || $url == '/?model=contacts&action=save') {
    $city = 'Добавить контакт';
    $town = 'create';
}
else {
    $city = 'Список Контактов';
    $town = 'read';
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Контакты</title>
    <link rel="stylesheet" href="../dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../dist/css/style.css">

    <nav class="navbar navbar-light bg-light justify-content-between">
        <a class="navbar-brand">Контакты</a>
        <a href="/?model=contacts&action=<?php echo $town ?>" class="btn btn-primary"><?php echo $city ?></a>
    </nav>

</head>
<body>
