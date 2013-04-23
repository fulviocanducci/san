<?php

namespace TCE\SAN\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Endereco
 *
 * @Table(name="Endereco")
 * @Entity
 */
class Endereco extends \Champion\Model1 {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string $logradouro
     *
     * @Column(name="logradouro", type="string", length=100, nullable=false)
     */
    protected $logradouro;

    /**
     * @var integer $numero
     *
     * @Column(name="numero", type="integer", nullable=false)
     */
    protected $numero;

    /**
     * @var string $cep
     *
     * @Column(name="cep", type="string", length=10, nullable=true)
     */
    protected $cep;

    /**
     * @var string $complemento
     *
     * @Column(name="complemento", type="string", length=100, nullable=false)
     */
    protected $complemento;

    /**
     * @var datetime $datacadastro
     *
     * @Column(name="dataCadastro", type="datetime", nullable=false)
     */
    protected $datacadastro;

    /**
     * @var string $referencia
     *
     * @Column(name="referencia", type="string", length=45, nullable=true)
     */
    protected $referencia;

    /**
     * @var Cidade
     *
     * @ManyToOne(targetEntity="Cidade")
     * @JoinColumns({
     *   @JoinColumn(name="idCidade", referencedColumnName="id")
     * })
     */
    protected $idcidade;

    /**
     * @var Paciente
     *
     * @ManyToOne(targetEntity="Paciente")
     * @JoinColumns({
     *   @JoinColumn(name="idPaciente", referencedColumnName="id")
     * })
     */
    protected $idpaciente;

}