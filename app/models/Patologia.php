<?php

namespace TCE\SAN\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Patologia
 *
 * @Table(name="Patologia")
 * @Entity
 */
class Patologia extends \Champion\Model1 {

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
     * @Column(name="descricao", type="string", length=255, nullable=false)
     */
    protected $descricao;

    /**
     * @var text $observacao
     *
     * @Column(name="observacao", type="text", nullable=false)
     */
    protected $observacao;

}