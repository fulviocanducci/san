<?php

namespace TCE\SAN\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sintomagastrointestinal
 *
 * @Table(name="SintomaGastrointestinal")
 * @Entity
 */
class Sintomagastrointestinal extends \Champion\Model1 {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string $descricao
     *
     * @Column(name="descricao", type="string", length=45, nullable=true)
     */
    protected $descricao;

}