<?php

namespace TCE\SAN\classes;

/**
 * TCE\SAN\classes\Exception.php
 *
 * Descrição sobre a classe.
 * @author Leonardo Sales <leonardojs@tce.to.gov.br>
 * @version 1.0
 * @package TCE
 */

/**
 * @package SAN
 * @subpackage controllers
 */
class Exception extends \Exception {

    public function __construct($message)
    {
        parent::__construct($message);
    }

}