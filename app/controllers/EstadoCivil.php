<?php

namespace TCE\SAN\controllers;

/**
 * @RemoteClass
 */
class EstadoCivil extends \Champion\Controller {

    /**
     * @RemoteMethod
     */
    public function getEstadosCivis()
    {
        try {
            $qb = $this->getEM()->createQueryBuilder();
            $qb->select('e.id, e.descricao')
                    ->from('\TCE\SAN\models\Estadocivil', 'e')
                    ->orderBy('e.descricao','ASC');
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
    public function getEstadoCivil()
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
                    ->from('\TCE\SAN\models\Estadocivil', 'p')
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
    public function salvarEstadoCivil()
    {
        try {
            $estadocivil = NULL;
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $estadocivil = $this->getEM()
                        ->getRepository('\TCE\SAN\models\Estadocivil')
                        ->findOneBy(['id' => trim($_POST['id'])]);
            } else {
                $estadocivil = new \TCE\SAN\models\Estadocivil();
            }
            $estadocivil->setDescricao(trim($_POST['descricao']));
            $this->getEM()->persist($estadocivil);
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
    public function excluirEstadoCivil()
    {
        try {
            if (!isset($_POST['id'])) {
                return [
                    'success' => FALSE,
                    'msg' => 'Código não enviado.',
                    'title' => 'Falha'
                ];
            }
            $estadocivil = $this->getEM()
                    ->getRepository('\TCE\SAN\models\Estadocivil')
                    ->findOneBy(['id' => trim($_POST['id'])]);
            if (empty($estadocivil)) {
                return [
                    'success' => FALSE,
                    'msg' => 'Registro não encontrado.',
                    'title' => 'Falha'
                ];
            }
            $this->getEM()->remove($estadocivil);
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