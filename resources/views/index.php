<?php
if (!isset($baseUrl)) $baseUrl = null;
if (!isset($dataUrl)) $dataUrl = null;
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Octfolio - Transactions</title>
    <link rel="stylesheet" type="text/css"
          href="<?php echo htmlentities($baseUrl, ENT_QUOTES) ?>/css/main.css"/>
</head>
<body>
    <div
        data-component="MainPage"
        data-prop-dataurl="<?php echo htmlentities($dataUrl, ENT_QUOTES) ?>">
    >
    </div>
    <script src="webapp/app.js"></script>

</body>
</html>