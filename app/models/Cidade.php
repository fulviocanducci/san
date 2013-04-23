<?php

namespace TCE\SAN\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cidade
 *
 * @Table(name="Cidade")
 * @Entity
 */
class Cidade extends \Champion\Model1 {

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

    /**
     * @var Estado
     *
     * @ManyToOne(targetEntity="Estado")
     * @JoinColumns({
     *   @JoinColumn(name="idEstado", referencedColumnName="id")
     * })
     */
    protected $idestado;

}