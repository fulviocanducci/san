<?php

namespace TCE\SAN\controllers;

/**
 * @RemoteClass
 */
class TelefoneTipo extends \Champion\Controller {

    /**
     * @RemoteMethod
     */
    public function getTelefonesTipo()
    {
        try {
            $qb = $this->getEM()->createQueryBuilder();
            $qb->select('tt.id tipotelefone,tt.descricao')
                    ->from('\TCE\SAN\models\Telefonetipo', 'tt');
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
    public function getTelefoneTipo()
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
                    ->from('\TCE\SAN\models\Telefonetipo', 'p')
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
    public function salvarTelefoneTipo()
    {
        try {
            $telefonetipo = NULL;
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $telefonetipo = $this->getEM()
                        ->getRepository('\TCE\SAN\models\Telefonetipo')
                        ->findOneBy(['id' => trim($_POST['id'])]);
            } else {
                $telefonetipo = new \TCE\SAN\models\Telefonetipo();
            }
            $telefonetipo->setDescricao(trim($_POST['descricao']));
            $this->getEM()->persist($telefonetipo);
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
    public function excluirTelefoneTipo()
    {
        try {
            if (!isset($_POST['id'])) {
                return [
                    'success' => FALSE,
                    'msg' => 'Código não enviado.',
                    'title' => 'Falha'
                ];
            }
            $telefonetipo = $this->getEM()
                    ->getRepository('\TCE\SAN\models\Telefonetipo')
                    ->findOneBy(['id' => trim($_POST['id'])]);
            if (empty($telefonetipo)) {
                return [
                    'success' => FALSE,
                    'msg' => 'Registro não encontrado.',
                    'title' => 'Falha'
                ];
            }
            $this->getEM()->remove($telefonetipo);
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