<?php

namespace TCE\SAN\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prontuariodiabetes
 *
 * @Table(name="ProntuarioDiabetes")
 * @Entity
 */
class Prontuariodiabetes extends \Champion\Model1 {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var integer $complicacoesrenais
     *
     * @Column(name="complicacoesRenais", type="integer", nullable=true)
     */
    protected $complicacoesrenais;

    /**
     * @var integer $complicacoesvisuais
     *
     * @Column(name="complicacoesVisuais", type="integer", nullable=true)
     */
    protected $complicacoesvisuais;

    /**
     * @var integer $complicacoesneurologicas
     *
     * @Column(name="complicacoesNeurologicas", type="integer", nullable=true)
     */
    protected $complicacoesneurologicas;

    /**
     * @var integer $complicacoesepidermicas
     *
     * @Column(name="complicacoesEpidermicas", type="integer", nullable=true)
     */
    protected $complicacoesepidermicas;

    /**
     * @var integer $diabeticofamilia
     *
     * @Column(name="diabeticoFamilia", type="integer", nullable=true)
     */
    protected $diabeticofamilia;

    /**
     * @var integer $usoinsulina
     *
     * @Column(name="usoInsulina", type="integer", nullable=true)
     */
    protected $usoinsulina;

    /**
     * @var string $medicamento
     *
     * @Column(name="medicamento", type="string", length=255, nullable=true)
     */
    protected $medicamento;

    /**
     * @var Prontuario
     *
     * @ManyToOne(targetEntity="Prontuario")
     * @JoinColumns({
     *   @JoinColumn(name="idProntuario", referencedColumnName="id")
     * })
     */
    protected $idprontuario;

}