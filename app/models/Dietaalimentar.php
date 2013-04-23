<?php

namespace TCE\SAN\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dietaalimentar
 *
 * @Table(name="DietaAlimentar")
 * @Entity
 */
class Dietaalimentar extends \Champion\Model1 {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var integer $valorcalorico
     *
     * @Column(name="valorCalorico", type="integer", nullable=false)
     */
    protected $valorcalorico;

    /**
     * @var datetime $dtcadastro
     *
     * @Column(name="dtCadastro", type="datetime", nullable=false)
     */
    protected $dtcadastro;

    /**
     * @var Prontuario
     *
     * @ManyToOne(targetEntity="Prontuario")
     * @JoinColumns({
     *   @JoinColumn(name="idProntuario", referencedColumnName="id")
     * })
     */
    protected $idprontuario;

    /**
     * @var Tipodieta
     *
     * @ManyToOne(targetEntity="Tipodieta")
     * @JoinColumns({
     *   @JoinColumn(name="idTipoDieta", referencedColumnName="id")
     * })
     */
    protected $idtipodieta;

}