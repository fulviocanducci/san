<?php

namespace TCE\SAN\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Refeicao
 *
 * @Table(name="Refeicao")
 * @Entity
 */
class Refeicao extends \Champion\Model1 {

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
     * @var text $formapreparo
     *
     * @Column(name="formaPreparo", type="text", nullable=false)
     */
    protected $formapreparo;

}