<?php

namespace TCE\SAN\controllers;

/**
 * @RemoteClass
 */
class AlimentosAlergicos extends \Champion\Controller {

    /**
     * @RemoteMethod
     */
    public function getAlimentosAlergicos()
    {
        try {
            if (!isset($_POST['idprontuario'])) {
                return [
                    'raiz' => [],
                    'sql' => $this->getSqlProfiler()
                ];
            }
            $qb = $this->getEM()->createQueryBuilder();
            $qb->select('a.id,t.nome,g.descricao grupoalimento')
                    ->from('\TCE\SAN\models\Alimentosalergicos', 'a')
                    ->innerJoin('a.idprontuario', 'p')
                    ->innerJoin('a.idtabelanacionalalimentos', 't')
                    ->innerJoin('t.idgrupoalimento', 'g')
                    ->where('p.id = :id')
                    ->setParameter('id', $_POST['idprontuario']);
            $retorno = $qb->getQuery()->getArrayResult();
            return [
                'raiz' => $retorno,
                'sql' => $this->getSqlProfiler()
            ];
        } catch (\Exception $e) {
            return [
                'success' => FALSE,
                'erro' => $e->getMessage(),
                'msg' => 'Ocorreu um erro.',
                'title' => 'Falha'
            ];
        }
    }

    /**
     * @RemoteMethod
     */
    public function salvarAlimentosAlergicos($grid)
    {
        try {
            $prontuario = $this->getEM()
                    ->getRepository('\TCE\SAN\models\Prontuario')
                    ->findOneBy(['id' => trim($_POST['idprontuario'])]);
            foreach ($grid as $alimento) {
                $alimento = $this->getEM()
                        ->getRepository('\TCE\SAN\models\Tabelanacionalalimentos')
                        ->findOneBy(['id' => trim($alimento['idalimento'])]);

                $alimentoalergico = $this->getEM()
                        ->getRepository('\TCE\SAN\models\Alimentosalergicos')
                        ->findOneBy(['id' => trim($alimento['id'])]);
                if (empty($alimentoalergico)) {
                    $alimentoalergico = new \TCE\SAN\models\Alimentosalergicos();
                }
                $alimentoalergico->Idtabelanacionalalimentos($alimento);
                $alimentoalergico->Idprontuario($prontuario);
                $this->getEM()->persist($alimentoalergico);
                $this->getEM()->flush();
            }
            return [
                'success' => TRUE,
                'resposta' => $this->getSqlProfiler()
            ];
        } catch (\Exception $e) {
            return [
                'success' => FALSE,
                'msg' => 'Ocorreu um erro.',
                'title' => 'Falha'
            ];
        }
    }

    /**
     * @RemoteMethod
     */
    public function excluirAlimentosAlergicos($grid)
    {
        try {
            foreach ($grid as $alimento) {
                $alimentoalergico = $this->getEM()
                        ->getRepository('\TCE\SAN\models\Alimentosalergicos')
                        ->findOneBy(['id' => trim($alimento['id'])]);
                $this->getEM()->remove($alimentoalergico);
                $this->getEM()->flush();
            }
        } catch (\Exception $e) {
            return [
                'erro' => $e->getMessage()
            ];
        }
        return ['grid' => $grid, 'get' => $_GET];
    }

}