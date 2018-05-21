<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Парсим Новости</title>
    <meta name='robots' content='noindex,nofollow' />
    <script type="text/javascript">
      function show() {
				setTimeout("document.getElementById('subbut').click();", 1000000);
}
</script>


</head>
<body onLoad="show()">
<h2><?php echo date('H:i:s') ?></h2>
    <form>
        <input type="hidden" name="r" value="parse">
        <button id="subbut">Обновить</button>
    </form>

    <?php
        $filePath = $config['rootDir'] . DIRECTORY_SEPARATOR . $config['dumpFile'];
        if (is_file($filePath)){
            echo file_get_contents($filePath);
        }
    ?>
</body>
</html>