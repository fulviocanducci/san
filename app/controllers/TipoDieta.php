<?php

namespace TCE\SAN\controllers;

/**
 * @RemoteClass
 */
class TipoDieta extends \Champion\Controller {

    /** @RemoteMethod */
    public function getTipoDietas()
    {
        try {
            $qb = $this->getEM()->createQueryBuilder();
            $qb->select('p.id, p.descricao,p.observacao')
                    ->from('\TCE\SAN\models\Tipodieta', 'p')
                    ->orderBy('p.id', 'ASC');
            $resultado = $qb->getQuery()->getArrayResult();
            $retorno = array_slice($resultado, $_POST['start'], $_POST['limit']);
            $this->array_walk_recursive_referential($retorno, 'utf8_encode');
            return [
                'raiz' => $retorno,
                'total' => count($resultado),
                'sql' => $this->getSqlProfiler()
            ];
        } catch (\Exception $e) {
            return [
                'success' => FALSE,
                'msg' => 'Ocorreu um erro.',
                'erro' => $e->getMessage(),
                'sql' => $this->SqlProfiler(),
                'title' => 'Falha'
            ];
        }
    }

    /** @RemoteMethod */
    public function getTipoDieta()
    {
        try {
            if (!isset($_POST['id'])) {
                return [
                    'success' => FALSE,
                    'msg' => 'Código não enviado.',
                    'title' => 'Falha'
                ];
            }
            $qb = $this->getEM()->createQueryBuilder();
            $qb->select('p.id, p.descricao,p.observacao')
                    ->from('\TCE\SAN\models\Tipodieta', 'p')
                    ->where('p.id = :id')
                    ->setParameter('id', trim($_POST['id']));
            $retorno = $qb->getQuery()->getArrayResult();
            $this->array_walk_recursive_referential($retorno[0], 'utf8_encode');
            return [
                'success' => TRUE,
                'dados' => $retorno[0]
            ];
        } catch (\Exception $e) {
            return [
                'success' => FALSE,
                'msg' => 'Ocorreu um erro.',
                'title' => 'Falha',
                'erro' => $e->getMessage(),
                'sql' => $this->SqlProfiler()
            ];
        }
    }

    /** @RemoteMethod */
    public function salvarTipoDieta()
    {
        try {
            $tipodieta = NULL;
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $tipodieta = $this->getEM()
                        ->getRepository('\TCE\SAN\models\Tipodieta')
                        ->findOneBy(['id' => trim($_POST['id'])]);
            } else {
                $tipodieta = new \TCE\SAN\models\Tipodieta();
            }
            $tipodieta->setDescricao(trim($_POST['descricao']));
            $tipodieta->setObservacao(trim($_POST['observacao']));
            $this->getEM()->persist($tipodieta);
            $this->getEM()->flush();
            return [
                'success' => TRUE,
                'msg' => 'Salvo com sucesso.',
                'title' => 'Sucesso'
            ];
        } catch (\Exception $e) {
            return [
                'success' => FALSE,
                'msg' => 'Não foi possível salvar.',
                'title' => 'Falha',
                'erro' => $e->getMessage(),
                'sql' => $this->SqlProfiler()
            ];
        }
    }

    /** @RemoteMethod */
    public function excluirTipoDieta()
    {
        try {
            if (!isset($_POST['id'])) {
                return [
                    'success' => FALSE,
                    'msg' => 'Código não enviado.',
                    'title' => 'Falha'
                ];
            }
            $tipodieta = $this->getEM()
                    ->getRepository('\TCE\SAN\models\Tipodieta')
                    ->findOneBy(['id' => trim($_POST['id'])]);
            if (empty($tipodieta)) {
                return [
                    'success' => FALSE,
                    'msg' => 'Registro não encontrado.',
                    'title' => 'Falha'
                ];
            }
            $this->getEM()->remove($tipodieta);
            $this->getEM()->flush();
            return [
                'success' => TRUE,
                'msg' => 'Excluído com sucesso.',
                'title' => 'Sucesso'
            ];
        } catch (\Exception $e) {
            return [
                'success' => FALSE,
                'msg' => 'Não foi possível salvar.',
                'title' => 'Falha',
                'erro' => $e->getMessage(),
                'sql' => $this->SqlProfiler()
            ];
        }
    }

}