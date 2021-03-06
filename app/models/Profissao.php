<?php

namespace TCE\SAN\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profissao
 *
 * @Table(name="Profissao")
 * @Entity
 */
class Profissao extends \Champion\Model1 {

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
     * @Column(name="descricao", type="string", length=45, nullable=false)
     */
    protected $descricao;

}