<?php

namespace TCE\SAN\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cardapio
 *
 * @Table(name="Cardapio")
 * @Entity
 */
class Cardapio extends \Champion\Model1 {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string $tipo
     *
     * @Column(name="tipo", type="string", length=1, nullable=false)
     */
    protected $tipo;

    /**
     * @var datetime $dtcadastro
     *
     * @Column(name="dtCadastro", type="datetime", nullable=false)
     */
    protected $dtcadastro;

    /**
     * @var datetime $data
     *
     * @Column(name="data", type="datetime", nullable=false)
     */
    protected $data;

    /**
     * @var Dietaalimentar
     *
     * @ManyToOne(targetEntity="Dietaalimentar")
     * @JoinColumns({
     *   @JoinColumn(name="idDietaAlimentar", referencedColumnName="id")
     * })
     */
    protected $iddietaalimentar;

}