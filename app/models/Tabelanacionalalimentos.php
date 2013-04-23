<?php

namespace TCE\SAN\models;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tabelanacionalalimentos
 *
 * @Table(name="TabelaNacionalAlimentos")
 * @Entity
 */
class Tabelanacionalalimentos extends \Champion\Model1 {

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
     * @Column(name="nome", type="string", length=255, nullable=false)
     */
    protected $nome;

    /**
     * @var text $descricao
     *
     * @Column(name="descricao", type="text", nullable=true)
     */
    protected $descricao;

    /**
     * @var float $quantidade
     *
     * @Column(name="quantidade", type="float", nullable=false)
     */
    protected $quantidade;

    /**
     * @var string $umidade
     *
     * @Column(name="umidade", type="string", length=10, nullable=true)
     */
    protected $umidade;

    /**
     * @var string $energia
     *
     * @Column(name="energia", type="string", length=10, nullable=true)
     */
    protected $energia;

    /**
     * @var string $proteina
     *
     * @Column(name="proteina", type="string", length=10, nullable=true)
     */
    protected $proteina;

    /**
     * @var string $lipideos
     *
     * @Column(name="lipideos", type="string", length=10, nullable=true)
     */
    protected $lipideos;

    /**
     * @var string $colesterol
     *
     * @Column(name="colesterol", type="string", length=10, nullable=true)
     */
    protected $colesterol;

    /**
     * @var string $carboidrato
     *
     * @Column(name="carboidrato", type="string", length=10, nullable=true)
     */
    protected $carboidrato;

    /**
     * @var string $fibraalimentar
     *
     * @Column(name="fibraalimentar", type="string", length=10, nullable=true)
     */
    protected $fibraalimentar;

    /**
     * @var string $cinzas
     *
     * @Column(name="cinzas", type="string", length=10, nullable=true)
     */
    protected $cinzas;

    /**
     * @var string $calcio
     *
     * @Column(name="calcio", type="string", length=10, nullable=true)
     */
    protected $calcio;

    /**
     * @var string $magnesio
     *
     * @Column(name="magnesio", type="string", length=10, nullable=true)
     */
    protected $magnesio;

    /**
     * @var string $manganes
     *
     * @Column(name="manganes", type="string", length=10, nullable=true)
     */
    protected $manganes;

    /**
     * @var string $fosforo
     *
     * @Column(name="fosforo", type="string", length=10, nullable=true)
     */
    protected $fosforo;

    /**
     * @var string $ferro
     *
     * @Column(name="ferro", type="string", length=10, nullable=true)
     */
    protected $ferro;

    /**
     * @var float $sodio
     *
     * @Column(name="sodio", type="float", nullable=true)
     */
    protected $sodio;

    /**
     * @var float $potassio
     *
     * @Column(name="potassio", type="float", nullable=true)
     */
    protected $potassio;

    /**
     * @var float $cobre
     *
     * @Column(name="cobre", type="float", nullable=true)
     */
    protected $cobre;

    /**
     * @var float $zinco
     *
     * @Column(name="zinco", type="float", nullable=true)
     */
    protected $zinco;

    /**
     * @var float $retinol
     *
     * @Column(name="retinol", type="float", nullable=true)
     */
    protected $retinol;

    /**
     * @var float $re
     *
     * @Column(name="re", type="float", nullable=true)
     */
    protected $re;

    /**
     * @var float $rae
     *
     * @Column(name="rae", type="float", nullable=true)
     */
    protected $rae;

    /**
     * @var float $tiamina
     *
     * @Column(name="tiamina", type="float", nullable=true)
     */
    protected $tiamina;

    /**
     * @var float $riboflavina
     *
     * @Column(name="riboflavina", type="float", nullable=true)
     */
    protected $riboflavina;

    /**
     * @var float $piridoxina
     *
     * @Column(name="piridoxina", type="float", nullable=true)
     */
    protected $piridoxina;

    /**
     * @var float $niacina
     *
     * @Column(name="niacina", type="float", nullable=true)
     */
    protected $niacina;

    /**
     * @var float $vitaminac
     *
     * @Column(name="vitaminac", type="float", nullable=true)
     */
    protected $vitaminac;

    /**
     * @var Grupoalimento
     *
     * @ManyToOne(targetEntity="Grupoalimento")
     * @JoinColumns({
     *   @JoinColumn(name="idGrupoAlimento", referencedColumnName="id")
     * })
     */
    protected $idgrupoalimento;

    /**
     * @var Unidademedida
     *
     * @ManyToOne(targetEntity="Unidademedida")
     * @JoinColumns({
     *   @JoinColumn(name="idUnidademedida", referencedColumnName="id")
     * })
     */
    protected $idunidademedida;

}