<?php

namespace TCE\SAN\controllers;

/**
 * @RemoteClass
 */
class Cidade extends \Champion\Controller {

    /**
     * @RemoteMethod
     */
    public function getCidades()
    {
        try {
            $qb = $this->getEM()->createQueryBuilder();
            $qb->select('c.id, c.descricao')
                    ->from('\TCE\SAN\models\Cidade', 'c')
                    ->orderBy('c.descricao', 'ASC');
            if (isset($_POST['estado'])) {
                $consulta = trim($_POST['estado']);
                $qb->select('c.id, c.descricao, e.id idestado,e.descricao estadodescricao')
                        ->innerJoin('c.idestado', 'e')
                        ->where('e.id = :estado')
                        ->setParameter('estado', $consulta);
            }
            $retorno = $qb->getQuery()->getArrayResult();
            $this->array_walk_recursive_referential($retorno, 'utf8_encode');
            return [
                'raiz' => $retorno,
                'sql' => $this->getSqlProfiler()
            ];
        } catch (\Exception $e) {
            return [
                'success' => FALSE,
                'msg' => 'Ocorreu um erro.',
                'title' => 'Falha'
            ];
        }
    }

    /** @RemoteMethod */
    public function getCidade()
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
            $qb->select('p.id, p.descricao, e.id estado')
                    ->from('\TCE\SAN\models\Cidade', 'p')
                    ->innerJoin('p.idestado', 'e')
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
    public function salvarCidade()
    {
        try {
            $cidade = NULL;
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $cidade = $this->getEM()
                        ->getRepository('\TCE\SAN\models\Cidade')
                        ->findOneBy(['id' => trim($_POST['id'])]);
            } else {
                $cidade = new \TCE\SAN\models\Cidade();
            }
            $estado = $this->getEM()
                    ->getRepository('\TCE\SAN\models\Estado')
                    ->findOneBy(['id' => trim($_POST['estado'])]);
            if (empty($estado)) {
                return [
                    'success' => FALSE,
                    'msg' => 'Estado inválido.',
                    'title' => 'Falha'
                ];
            }
            $cidade->setDescricao(trim($_POST['descricao']));
            $cidade->setIdestado($estado);
            $this->getEM()->persist($cidade);
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
    public function excluirCidade()
    {
        try {
            if (!isset($_POST['id'])) {
                return [
                    'success' => FALSE,
                    'msg' => 'Código não enviado.',
                    'title' => 'Falha'
                ];
            }
            $cidade = $this->getEM()
                    ->getRepository('\TCE\SAN\models\Cidade')
                    ->findOneBy(['id' => trim($_POST['id'])]);
            if (empty($cidade)) {
                return [
                    'success' => FALSE,
                    'msg' => 'Registro não encontrado.',
                    'title' => 'Falha'
                ];
            }
            $this->getEM()->remove($cidade);
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