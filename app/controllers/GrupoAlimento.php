<?php

namespace TCE\SAN\controllers;

/**
 * @RemoteClass
 */
class GrupoAlimento extends \Champion\Controller {

    /** @RemoteMethod */
    public function getGrupoAlimentos()
    {
        try {
            $qb = $this->getEM()->createQueryBuilder();
            $qb->select('p.id, p.descricao,p.observacao')
                    ->from('\TCE\SAN\models\Grupoalimento', 'p')
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
    public function getGrupoAlimento()
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
                    ->from('\TCE\SAN\models\Grupoalimento', 'p')
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
    public function salvarGrupoAlimento()
    {
        try {
            $grupoalimento = NULL;
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $grupoalimento = $this->getEM()
                        ->getRepository('\TCE\SAN\models\Grupoalimento')
                        ->findOneBy(['id' => trim($_POST['id'])]);
            } else {
                $grupoalimento = new \TCE\SAN\models\Grupoalimento();
            }
            $grupoalimento->setDescricao(trim($_POST['descricao']));
            $grupoalimento->setObservacao(trim($_POST['observacao']));
            $this->getEM()->persist($grupoalimento);
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
    public function excluirGrupoAlimento()
    {
        try {
            if (!isset($_POST['id'])) {
                return [
                    'success' => FALSE,
                    'msg' => 'Código não enviado.',
                    'title' => 'Falha'
                ];
            }
            $grupoalimento = $this->getEM()
                    ->getRepository('\TCE\SAN\models\Grupoalimento')
                    ->findOneBy(['id' => trim($_POST['id'])]);
            if (empty($grupoalimento)) {
                return [
                    'success' => FALSE,
                    'msg' => 'Registro não encontrado.',
                    'title' => 'Falha'
                ];
            }
            $this->getEM()->remove($grupoalimento);
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