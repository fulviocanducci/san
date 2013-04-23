<?php

namespace TCE\SAN\controllers;

/**
 * @RemoteClass
 */
class Paciente extends \Champion\Controller {

    /**
     * @RemoteMethod
     */
    public function getNomePaciente()
    {
        try {
            if (!isset($_POST['cpf']) || (isset($_POST['cpf']) && strlen(trim($_POST['cpf'])) != 14)) {
                return [
                    'success' => FALSE,
                    'title' => 'Falha',
                    'msg' => 'CPF Inválido.'
                ];
            }
            $cpf = str_replace([".", "-"], "", $_POST['cpf']);
            $qb = $this->getEM()->createQueryBuilder();
            $qb->select('p.nome')
                    ->from('\TCE\SAN\models\Paciente', 'p')
                    ->where('p.cpf = :cpf')
                    ->setParameter('cpf', $cpf);
            $paciente = $qb->getQuery()->getOneOrNullResult();
            if (empty($paciente)) {
                return [
                    'success' => FALSE,
                    'title' => 'Falha',
                    'msg' => 'CPF não cadastrado.'
                ];
            }
            return [
                'success' => TRUE,
                'nome' => $paciente['nome']
            ];
        } catch (\Exception $e) {
            return [
                'success' => FALSE,
                'title' => 'Falha',
                'msg' => 'Ocorreu um erro.',
                'erro' => $e->getMessage()
            ];
        }
    }

    /**
     * @RemoteMethod
     */
    public function carregarPaciente()
    {
        try {
            if (!isset($_POST['cpf'])) {
                return [
                    'success' => NULL,
                    'msg' => 'CPF não enviado'
                ];
            }
            $cpf = str_replace([".", "-"], "", $_POST['cpf']);
            $qb = $this->getEM()->createQueryBuilder();
            $qb->select('p.nome, p.pai, p.mae, p.numerosus, p.datanascimento,
                p.responsavel, es.id estado, ci.id cidade,p.rg,
                s.id sexo, pr.id profissao, e.id estadocivil, c.id cor,
                p.email, p.observacao, p.rgdataexpedicao dataexpedicao, p.rgorgaoexpedidor orgaoexpedidor')
                    ->from('\TCE\SAN\models\Paciente', 'p')
                    ->innerJoin('p.idsexo', 's')
                    ->innerJoin('p.idprofissao', 'pr')
                    ->innerJoin('p.idestadocivil', 'e')
                    ->innerJoin('p.idcor', 'c')
                    ->innerJoin('p.idcidadenaturalidade', 'ci')
                    ->innerJoin('ci.idestado', 'es')
                    ->where('p.cpf = :cpf')
                    ->setParameter('cpf', $cpf);
            $retorno = $qb->getQuery()->getOneOrNullResult();
            if (empty($retorno)) {
                return [
                    'success' => FALSE,
                    'msg' => 'CPF não encontrado.'
                ];
            }
            $retorno['dataexpedicao'] = $this->formatarData($retorno['dataexpedicao'], 'd/m/Y');
            $retorno['datanascimento'] = $this->formatarData($retorno['datanascimento'], 'd/m/Y');
            $this->array_walk_recursive_referential($retorno, 'utf8_encode');
            return [
                'success' => TRUE,
                'cpf' => $cpf,
                'title' => 'Sucesso',
                'msg' => 'CPF encontrado. Os dados foram carregados.',
                'dados' => $retorno
            ];
        } catch (\Exception $e) {
            return [
                'success' => FALSE,
                'erro' => $e->getMessage(),
                'sql' => $this->getSqlProfiler(),
                'msg' => 'Erro'
            ];
        }
    }

    /**
     * @RemoteMethod
     */
    public function salvarPaciente()
    {
        try {
            $_POST['outras'] = json_decode($_POST['outras'], true);
            $_POST['adicionais'] = json_decode($_POST['adicionais'], true);
            $_POST['cpf'] = str_replace([".", "-"], "", $_POST['cpf']);
            $paciente = $this->getEM()
                    ->getRepository('\TCE\SAN\models\Paciente')
                    ->findOneBy(['cpf' => trim($_POST['cpf'])]);
            if (empty($paciente)) {
                $paciente = new \TCE\SAN\models\Paciente();
            }
            $paciente->setNome(trim($_POST['nome']));
            $paciente->setPai(trim($_POST['pai']));
            $paciente->setMae(trim($_POST['mae']));
            $paciente->setCpf(trim($_POST['cpf']));
            $paciente->setRg(trim($_POST['rg']));
            $paciente->setRgdataexpedicao(new \DateTime(trim($_POST['dataexpedicao'])));
            $paciente->setRgorgaoexpedidor(trim($_POST['orgaoexpedidor']));
            $paciente->setDatanascimento(new \DateTime(trim($_POST['datanascimento'])));
            $paciente->setNumerosus(trim($_POST['numerosus']));
            $paciente->setResponsavel(trim($_POST['responsavel']));
            $paciente->setEmail(trim($_POST['outras']['email']));
            $paciente->setObservacao(trim($_POST['outras']['observacao']));
            $paciente->setIdsexo($this->getEM()->getRepository('\TCE\SAN\models\Sexo')->findOneBy(['id' => trim($_POST['sexo'])]));
            $paciente->setIdestadocivil($this->getEM()->getRepository('\TCE\SAN\models\Estadocivil')->findOneBy(['id' => trim($_POST['estadocivil'])]));
            $paciente->setIdcor($this->getEM()->getRepository('\TCE\SAN\models\Cor')->findOneBy(['id' => trim($_POST['cor'])]));
            $paciente->setIdcidadenaturalidade($this->getEM()->getRepository('\TCE\SAN\models\Cidade')->findOneBy(['id' => trim($_POST['cidade'])]));
            $paciente->setIdprofissao($this->getEM()->getRepository('\TCE\SAN\models\Profissao')->findOneBy(['id' => trim($_POST['outras']['profissao'])]));
            $this->getEM()->persist($paciente);
            $this->getEM()->flush();
            return [
                'success' => TRUE,
                'post' => $_POST,
                'msg' => 'Salvo com sucesso',
                'title' => 'Sucesso'
            ];
        } catch (\Exception $e) {
            return [
                'success' => FALSE,
                'erro' => $e->getMessage(),
                'msg' => 'Ocorreu um erro.',
                'title' => 'Falha'
            ];
        } catch (\Champion\Exception $e) {
            return [
                'success' => FALSE,
                'msg' => 'Ocorreu um erro.',
                'title' => 'Falha'
            ];
        }
    }

}