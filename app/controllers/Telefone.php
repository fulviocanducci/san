<?php

namespace TCE\SAN\controllers;

/**
 * @RemoteClass
 */
class Telefone extends \Champion\Controller {

    /**
     * @RemoteMethod
     */
    public function getTelefones()
    {
        try {
            if (!isset($_POST['cpf'])) {
                return [
                    'raiz' => [],
                    'sql' => $this->getSqlProfiler()
                ];
            }
            $cpf = str_replace([".", "-"], "", $_POST['cpf']);
            $qb = $this->getEM()->createQueryBuilder();
            $qb->select('t.numero,tt.id tipotelefone,t.id')
                    ->from('\TCE\SAN\models\Telefone', 't')
                    ->innerJoin('t.idtipotelefone', 'tt')
                    ->innerJoin('t.idpaciente', 'p')
                    ->where('p.cpf = :cpf')
                    ->setParameter('cpf', $cpf);
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
    public function salvarTelefones($grid)
    {
        try {
            $cpf = str_replace([".", "-"], "", $_GET['cpf']);
            $paciente = $this->getEM()
                    ->getRepository('\TCE\SAN\models\Paciente')
                    ->findOneBy(['cpf' => trim($cpf)]);
            foreach ($grid as $telefone) {
                $telefoneobj = $this->getEM()
                        ->getRepository('\TCE\SAN\models\Telefone')
                        ->findOneBy(['id' => trim($telefone['id'])]);
                if (empty($telefoneobj)) {
                    $telefoneobj = new \TCE\SAN\models\Telefone();
                }
                $telefoneobj->setIdpaciente($paciente);
                $tipo = $telefone['tipotelefone'];
                settype($tipo, "integer");
                $telefonetipoobj = $this->getEM()
                        ->getRepository('\TCE\SAN\models\Telefonetipo')
                        ->findOneBy(['id' => trim($telefone['tipotelefone'])]);
                if (empty($telefonetipoobj)) {
                    $telefonetipoobj = $this->getEM()
                            ->getRepository('\TCE\SAN\models\Telefonetipo')
                            ->findOneBy(['descricao' => trim($telefone['tipotelefone'])]);
                }

                $telefoneobj->setIdtipotelefone($telefonetipoobj);

                $telefoneobj->setNumero(trim($telefone['numero']));

                $this->getEM()->persist($telefoneobj);
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
    public function excluirTelefones($grid)
    {
        try {
            foreach ($grid as $telefone) {
                $telefoneobj = $this->getEM()
                        ->getRepository('\TCE\SAN\models\Telefone')
                        ->findOneBy(['id' => trim($telefone['id'])]);
                $this->getEM()->remove($telefoneobj);
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