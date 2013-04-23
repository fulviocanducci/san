<?php

namespace TCE\SAN\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Refeicaotabeladealimentos
 *
 * @Table(name="RefeicaoTabeladeAlimentos")
 * @Entity
 */
class Refeicaotabeladealimentos extends \Champion\Model1 {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var float $quantidade
     *
     * @Column(name="quantidade", type="float", nullable=false)
     */
    protected $quantidade;

    /**
     * @var Refeicao
     *
     * @ManyToOne(targetEntity="Refeicao")
     * @JoinColumns({
     *   @JoinColumn(name="idCardapio", referencedColumnName="id")
     * })
     */
    protected $idcardapio;

    /**
     * @var Tabelanacionalalimentos
     *
     * @ManyToOne(targetEntity="Tabelanacionalalimentos")
     * @JoinColumns({
     *   @JoinColumn(name="idTabelaNacionalAlimentos", referencedColumnName="id")
     * })
     */
    protected $idtabelanacionalalimentos;

}