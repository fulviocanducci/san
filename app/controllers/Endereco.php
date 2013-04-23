<?php

namespace TCE\SAN\controllers;

/**
 * @RemoteClass
 */
class Endereco extends \Champion\Controller {

    /**
     * @RemoteMethod
     */
    public function getEnderecos()
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
            $qb->select('e.id,e.logradouro,e.numero,e.cep,e.complemento,c.id cidade')
                    ->from('\TCE\SAN\models\Endereco', 'e')
                    ->innerJoin('e.idcidade', 'c')
                    ->innerJoin('e.idpaciente', 'p')
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
    public function salvarEnderecos($grid)
    {
        try {
            $cpf = str_replace([".", "-"], "", $_GET['cpf']);
            $paciente = $this->getEM()
                    ->getRepository('\TCE\SAN\models\Paciente')
                    ->findOneBy(['cpf' => trim($cpf)]);
            foreach ($grid as $endereco) {
                $enderecoobj = $this->getEM()
                        ->getRepository('\TCE\SAN\models\Endereco')
                        ->findOneBy(['id' => trim($endereco['id'])]);
                if (empty($enderecoobj)) {
                    $enderecoobj = new \TCE\SAN\models\Endereco();
                }

                $enderecoobj->setLogradouro(trim($endereco['logradouro']));
                $enderecoobj->setNumero(trim($endereco['numero']));
                $enderecoobj->setCep(trim($endereco['cep']));
                $enderecoobj->setComplemento(trim($endereco['complemento']));
                $enderecoobj->setDatacadastro(new \DateTime());
                $cidadeobj = $this->getEM()
                        ->getRepository('\TCE\SAN\models\Cidade')
                        ->findOneBy(['id' => trim($endereco['cidade'])]);
                if (empty($cidadeobj)) {
                    $cidadeobj = $this->getEM()
                            ->getRepository('\TCE\SAN\models\Telefonetipo')
                            ->findOneBy(['descricao' => trim($endereco['cidade'])]);
                }
                $enderecoobj->setIdcidade($cidadeobj);
                $enderecoobj->setIdpaciente($paciente);

                $this->getEM()->persist($enderecoobj);
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
                        ->getRepository('\TCE\SAN\models\Endereco')
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