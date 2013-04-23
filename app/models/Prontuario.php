<?php

namespace TCE\SAN\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prontuario
 *
 * @Table(name="Prontuario")
 * @Entity
 */
class Prontuario extends \Champion\Model1 {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var float $massa
     *
     * @Column(name="massa", type="float", nullable=false)
     */
    protected $massa;

    /**
     * @var float $altura
     *
     * @Column(name="altura", type="float", nullable=false)
     */
    protected $altura;

    /**
     * @var integer $fumante
     *
     * @Column(name="fumante", type="integer", nullable=false)
     */
    protected $fumante;

    /**
     * @var integer $bebidasalcoolicas
     *
     * @Column(name="bebidasAlcoolicas", type="integer", nullable=false)
     */
    protected $bebidasalcoolicas;

    /**
     * @var integer $protesedentaria
     *
     * @Column(name="proteseDentaria", type="integer", nullable=false)
     */
    protected $protesedentaria;

    /**
     * @var integer $desconfortointestinal
     *
     * @Column(name="desconfortoIntestinal", type="integer", nullable=false)
     */
    protected $desconfortointestinal;

    /**
     * @var integer $cansacodesanimofrequente
     *
     * @Column(name="cansacoDesanimoFrequente", type="integer", nullable=false)
     */
    protected $cansacodesanimofrequente;

    /**
     * @var integer $gripealergia
     *
     * @Column(name="gripeAlergia", type="integer", nullable=false)
     */
    protected $gripealergia;

    /**
     * @var integer $coposdeagua
     *
     * @Column(name="coposDeAgua", type="integer", nullable=false)
     */
    protected $coposdeagua;

    /**
     * @var datetime $dtcadastro
     *
     * @Column(name="dtCadastro", type="datetime", nullable=true)
     */
    protected $dtcadastro;

    /**
     * @var string $hipertensaomedicamento
     *
     * @Column(name="hipertensaoMedicamento", type="string", length=255, nullable=true)
     */
    protected $hipertensaomedicamento;

    /**
     * @var string $obesidademedicamento
     *
     * @Column(name="obesidadeMedicamento", type="string", length=255, nullable=true)
     */
    protected $obesidademedicamento;

    /**
     * @var integer $perdadepeso
     *
     * @Column(name="perdaDePeso", type="integer", nullable=true)
     */
    protected $perdadepeso;

    /**
     * @var Sintomagastrointestinal
     *
     * @ManyToOne(targetEntity="Sintomagastrointestinal")
     * @JoinColumns({
     *   @JoinColumn(name="idSintomaGastrointestinal", referencedColumnName="id")
     * })
     */
    protected $idsintomagastrointestinal;

    /**
     * @var Paciente
     *
     * @ManyToOne(targetEntity="Paciente")
     * @JoinColumns({
     *   @JoinColumn(name="idPaciente", referencedColumnName="id")
     * })
     */
    protected $idpaciente;

    /**
     * @var Patologia
     *
     * @ManyToOne(targetEntity="Patologia")
     * @JoinColumns({
     *   @JoinColumn(name="idPatologia", referencedColumnName="id")
     * })
     */
    protected $idpatologia;

    /**
     * @var Avaliacaoglobal
     *
     * @ManyToOne(targetEntity="Avaliacaoglobal")
     * @JoinColumns({
     *   @JoinColumn(name="idAvaliacaoGlobal", referencedColumnName="id")
     * })
     */
    protected $idavaliacaoglobal;

    /**
     * @var Diagnosticometabolico
     *
     * @ManyToOne(targetEntity="Diagnosticometabolico")
     * @JoinColumns({
     *   @JoinColumn(name="idDiagnosticoMetabolico", referencedColumnName="id")
     * })
     */
    protected $iddiagnosticometabolico;

}