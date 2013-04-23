<?php

$confClass = require_once dirname(__FILE__) . '/../conf/Configurator.php';

class RemoteClass extends \Annotation {
    
}

class RemoteMethod extends \Annotation {

    public $AllowInvoke = FALSE;
    public $Serializer = 'JSON';

}

class Scaffold extends \Annotation {
    
}

class Index extends \Annotation {
    
}

class CRUD extends \Annotation {
    
}

header("Content-Type: text/javascript; charset=UTF-8", TRUE);
try {
    $configurator = new $confClass();
    $output = \Champion\Exporter::generateStubs($configurator);
} catch (\Champion\Exception $e) {
    if (isset($_GET['c']) AND isset($_GET['m'])) {
        $response = array(
            'success' => FALSE,
            'mb' => array(
                'title' => "Falha",
                'msg' => $e->getMessage(),
                'icon' => 'ext-mb-error',
                'buttons' => 1,
                'action' => \Champion\Utils::_minify("new Function(" . json_encode($e->getAction()) . ");")
            )
        );
        $output = json_encode($response);
    } else {
        $output = "alert(" . json_encode($e->getMessage()) . ");";
    }
}
echo $output;