<?php
require_once 'data.php';

$data = new JsonData();

$id = ShortUrl::getIDFromRequest();

if ($id != false)
{
    $url = $data->getUrl($id);

    if ($url == false)
    {
        echo '<h2>NOT FOUND</h2>';
        exit();
    }

    header('Location: '.$url);
    exit();
}
?>

<html>

<head>
    <title>shorturl</title>
    <style>
        #url {
            min-width: 400px;
        }
    </style>
</head>

<body>
    <form action="/short.php" method="post">
        <label for="url">url:</label>
        <input type="text" name="url" id="url">
        <input type="submit" value="short">
    </form>
</body>

</html>
