<?php

namespace TCE\SAN\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Refeicaocardapio
 *
 * @Table(name="RefeicaoCardapio")
 * @Entity
 */
class Refeicaocardapio extends \Champion\Model1 {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

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
     * @var Cardapio
     *
     * @ManyToOne(targetEntity="Cardapio")
     * @JoinColumns({
     *   @JoinColumn(name="idRefeicao", referencedColumnName="id")
     * })
     */
    protected $idrefeicao;

}