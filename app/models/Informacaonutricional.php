<?php

namespace TCE\SAN\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Informacaonutricional
 *
 * @Table(name="InformacaoNutricional")
 * @Entity
 */
class Informacaonutricional extends \Champion\Model1 {

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
     * @var Unidademedida
     *
     * @ManyToOne(targetEntity="Unidademedida")
     * @JoinColumns({
     *   @JoinColumn(name="idUnidadeMedida", referencedColumnName="id")
     * })
     */
    protected $idunidademedida;

    /**
     * @var Tipocomposicao
     *
     * @ManyToOne(targetEntity="Tipocomposicao")
     * @JoinColumns({
     *   @JoinColumn(name="idComposicaoAlimento", referencedColumnName="id")
     * })
     */
    protected $idcomposicaoalimento;

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