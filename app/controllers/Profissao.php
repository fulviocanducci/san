<?php

namespace TCE\SAN\controllers;

/**
 * @RemoteClass
 */
class Profissao extends \Champion\Controller {

    /**
     * @RemoteMethod
     */
    public function getProfissoes()
    {
        try {
            $qb = $this->getEM()->createQueryBuilder();
            $qb->select('p.id, p.descricao')
                    ->from('\TCE\SAN\models\Profissao', 'p');
            if (isset($_POST['query'])) {
                $consulta = utf8_decode(trim($_POST['query']));
                $qb->where($qb->expr()->like($qb->expr()->lower('p.descricao'), '?2'))
                        ->setParameter('2', strtolower($consulta) . '%');
            }
            $retorno = $qb->getQuery()->getArrayResult();
            if ($_POST['limit'] != 1) {
                $resultado = array_slice($retorno, $_POST['start'], $_POST['limit']);
                $this->array_walk_recursive_referential($resultado, 'utf8_encode');
                return [
                    'raiz' => $resultado,
                    'totalCount' => count($retorno),
                    'sql' => $this->getSqlProfiler()
                ];
            }
            $this->array_walk_recursive_referential($retorno, 'utf8_encode');
            return [
                'raiz' => $retorno,
                'totalCount' => count($retorno),
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
    public function getProfissao()
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
            $qb->select('p.id, p.descricao')
                    ->from('\TCE\SAN\models\Profissao', 'p')
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
    public function salvarProfissao()
    {
        try {
            $profissao = NULL;
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $profissao = $this->getEM()
                        ->getRepository('\TCE\SAN\models\Profissao')
                        ->findOneBy(['id' => trim($_POST['id'])]);
            } else {
                $profissao = new \TCE\SAN\models\Profissao();
            }
            $profissao->setDescricao(trim($_POST['descricao']));
            $this->getEM()->persist($profissao);
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
    public function excluirProfissao()
    {
        try {
            if (!isset($_POST['id'])) {
                return [
                    'success' => FALSE,
                    'msg' => 'Código não enviado.',
                    'title' => 'Falha'
                ];
            }
            $profissao = $this->getEM()
                    ->getRepository('\TCE\SAN\models\Profissao')
                    ->findOneBy(['id' => trim($_POST['id'])]);
            if (empty($profissao)) {
                return [
                    'success' => FALSE,
                    'msg' => 'Registro não encontrado.',
                    'title' => 'Falha'
                ];
            }
            $this->getEM()->remove($profissao);
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