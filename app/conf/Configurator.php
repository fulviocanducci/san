<?php

namespace TCE\SAN\conf;

require_once "Champion/Loader.php";
\Champion\Loader::registerAutoload1();

class Configurator extends \Champion\Configurator {

    public $CRIAR_SCHEMA = FALSE;
    public $ATUALIZAR_SCHEMA = FALSE;
    public $CRIAR_CRUD = FALSE;
    public $ENGENHARIA_REVERSA = FALSE;
    public $VERSAO_DOCTRINE = "2.0";
    public $ERROS_HTML = FALSE;
    public $DESCRICAO_PROJETO = "Sistema de Apoio ao Nutricionista";
    protected $connectionOptions = array(
        'dev' => array(
            'dbname' => 'mydb',
            'user' => 'root',
            'password' => 'password',
            'host' => 'localhost',
            'driver' => 'pdo_mysql'
        ),
        'prod' => array(
            'dbname' => 'mydb',
            'user' => 'root',
            'password' => 'password',
            'host' => 'localhost',
            'driver' => 'pdo_mysql'
        )
    );

}

return __NAMESPACE__ . "\\Configurator";