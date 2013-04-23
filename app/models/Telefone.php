<?php

namespace TCE\SAN\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Telefone
 *
 * @Table(name="Telefone")
 * @Entity
 */
class Telefone extends \Champion\Model1 {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string $numero
     *
     * @Column(name="numero", type="string", length=45, nullable=false)
     */
    protected $numero;

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
     * @var Telefonetipo
     *
     * @ManyToOne(targetEntity="Telefonetipo")
     * @JoinColumns({
     *   @JoinColumn(name="idTipoTelefone", referencedColumnName="id")
     * })
     */
    protected $idtipotelefone;

}