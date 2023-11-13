<?php
require_once 'data.php';

$data = new JsonData();

$shortUrl = $data->shortUrl($_POST['url']);
?>

<html>

<head>
    <title>shorturl</title>
    <style>
        #url {
            min-width: 300px;
        }
    </style>
</head>

<body>
    <input type="text" readonly id="url" value="<?php echo $shortUrl ?>">
    <button id="copyButton">copy</button>

    <script>
        const copyButton = document.querySelector('#copyButton');
        const url = document.querySelector('#url');

        copyButton.onclick = function()
        {
            url.select();
            url.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(url.value);
        };
    </script>
</body>

</html>
