<?php

namespace TCE\SAN\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alimentosalergicos
 *
 * @Table(name="AlimentosAlergicos")
 * @Entity
 */
class Alimentosalergicos extends \Champion\Model1 {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var Tabelanacionalalimentos
     *
     * @ManyToOne(targetEntity="Tabelanacionalalimentos")
     * @JoinColumns({
     *   @JoinColumn(name="idTabelaNacionalAlimentos", referencedColumnName="id")
     * })
     */
    protected $idtabelanacionalalimentos;

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