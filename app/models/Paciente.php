<?php

namespace TCE\SAN\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paciente
 *
 * @Table(name="Paciente")
 * @Entity
 */
class Paciente extends \Champion\Model1 {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string $nome
     *
     * @Column(name="nome", type="string", length=100, nullable=false)
     */
    protected $nome;

    /**
     * @var string $cpf
     *
     * @Column(name="cpf", type="string", length=15, nullable=false)
     */
    protected $cpf;

    /**
     * @var string $rg
     *
     * @Column(name="rg", type="string", length=20, nullable=false)
     */
    protected $rg;

    /**
     * @var string $pai
     *
     * @Column(name="pai", type="string", length=100, nullable=true)
     */
    protected $pai;

    /**
     * @var string $mae
     *
     * @Column(name="mae", type="string", length=100, nullable=true)
     */
    protected $mae;

    /**
     * @var string $numerosus
     *
     * @Column(name="numeroSus", type="string", length=40, nullable=true)
     */
    protected $numerosus;

    /**
     * @var date $datanascimento
     *
     * @Column(name="dataNascimento", type="date", nullable=true)
     */
    protected $datanascimento;

    /**
     * @var string $responsavel
     *
     * @Column(name="responsavel", type="string", length=100, nullable=true)
     */
    protected $responsavel;

    /**
     * @var string $email
     *
     * @Column(name="email", type="string", length=45, nullable=true)
     */
    protected $email;

    /**
     * @var string $observacao
     *
     * @Column(name="observacao", type="string", length=45, nullable=true)
     */
    protected $observacao;

    /**
     * @var date $rgdataexpedicao
     *
     * @Column(name="rgdataexpedicao", type="date", nullable=true)
     */
    protected $rgdataexpedicao;

    /**
     * @var string $rgorgaoexpedidor
     *
     * @Column(name="rgorgaoexpedidor", type="string", length=10, nullable=true)
     */
    protected $rgorgaoexpedidor;

    /**
     * @var date $ultimaalteracao
     *
     * @Column(name="ultimaAlteracao", type="date", nullable=true)
     */
    protected $ultimaalteracao;

    /**
     * @var Cidade
     *
     * @ManyToOne(targetEntity="Cidade")
     * @JoinColumns({
     *   @JoinColumn(name="idCidadeNaturalidade", referencedColumnName="id")
     * })
     */
    protected $idcidadenaturalidade;

    /**
     * @var Cor
     *
     * @ManyToOne(targetEntity="Cor")
     * @JoinColumns({
     *   @JoinColumn(name="idCor", referencedColumnName="id")
     * })
     */
    protected $idcor;

    /**
     * @var Estadocivil
     *
     * @ManyToOne(targetEntity="Estadocivil")
     * @JoinColumns({
     *   @JoinColumn(name="idEstadoCivil", referencedColumnName="id")
     * })
     */
    protected $idestadocivil;

    /**
     * @var Profissao
     *
     * @ManyToOne(targetEntity="Profissao")
     * @JoinColumns({
     *   @JoinColumn(name="idProfissao", referencedColumnName="id")
     * })
     */
    protected $idprofissao;

    /**
     * @var Sexo
     *
     * @ManyToOne(targetEntity="Sexo")
     * @JoinColumns({
     *   @JoinColumn(name="idSexo", referencedColumnName="id")
     * })
     */
    protected $idsexo;

}