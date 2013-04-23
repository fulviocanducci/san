<?php
try {
    $confClass = require_once dirname(__FILE__) . '/conf/Configurator.php';
    $configurator = new $confClass();
    if ($configurator->isDevMode()) {
        $ext = "ext-all-dev.js";
    } else {
        $ext = "ext-all.js";
    }
} catch (\Champion\Exception $exc) {
    echo $exc->getTraceAsString();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title><?php echo $configurator->DESCRICAO_PROJETO ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="/resources/extjs/resources/css/ext-all.css">
        <link rel="stylesheet" type="text/css" href="/resources/extjs/icons/silk.css">
        <link rel="stylesheet" type="text/css" href="/resources/extjs/resources/css/statusbar.css">
        <link rel="stylesheet" type="text/css" href="/resources/css/tce-adm.css">
    </head>
    <body>
    </body>
    <script type="text/javascript" src="/resources/extjs/<?php echo $ext ?>"></script>
    <script type="text/javascript" src="/resources/extjs/locale/ext-lang-pt_BR.js"></script>
    <script type="text/javascript" src="/resources/extjs/override.js"></script>
    <script type="text/javascript" src="<?php echo $configurator->RAIZ_PROJETO ?>app.js"></script>
    <?php
    if ($configurator->isDevMode()) {
    ?>
    <?php
    } else {
    ?>
    <?php
    }
    ?>
</html>