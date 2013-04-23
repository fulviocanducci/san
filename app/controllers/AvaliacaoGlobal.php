<?php

namespace TCE\SAN\controllers;

/**
 * @RemoteClass
 */
class AvaliacaoGlobal extends \Champion\Controller {

    /** @RemoteMethod */
    public function getAvaliacoesGlobais()
    {
        try {
            $qb = $this->getEM()->createQueryBuilder();
            $qb->select('p.id, p.descricao')
                    ->from('\TCE\SAN\models\Avaliacaoglobal', 'p')
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
    public function getAvaliacaoGlobal()
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
                    ->from('\TCE\SAN\models\Avaliacaoglobal', 'p')
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
    public function salvarAvaliacaoGlobal()
    {
        try {
            $avaliacaoglobal = NULL;
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $avaliacaoglobal = $this->getEM()
                        ->getRepository('\TCE\SAN\models\Avaliacaoglobal')
                        ->findOneBy(['id' => trim($_POST['id'])]);
            } else {
                $avaliacaoglobal = new \TCE\SAN\models\Avaliacaoglobal();
            }
            $avaliacaoglobal->setDescricao(trim($_POST['descricao']));
            $this->getEM()->persist($avaliacaoglobal);
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
    public function excluirAvaliacaoGlobal()
    {
        try {
            if (!isset($_POST['id'])) {
                return [
                    'success' => FALSE,
                    'msg' => 'Código não enviado.',
                    'title' => 'Falha'
                ];
            }
            $avaliacaoglobal = $this->getEM()
                    ->getRepository('\TCE\SAN\models\Avaliacaoglobal')
                    ->findOneBy(['id' => trim($_POST['id'])]);
            if (empty($avaliacaoglobal)) {
                return [
                    'success' => FALSE,
                    'msg' => 'Registro não encontrado.',
                    'title' => 'Falha'
                ];
            }
            $this->getEM()->remove($avaliacaoglobal);
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