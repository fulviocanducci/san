<?php

namespace TCE\SAN\controllers;

/**
 * @RemoteClass
 */
class Prontuario extends \Champion\Controller {

    /** @RemoteMethod */
    public function getProntuarios()
    {
        try {
            $cpf = str_replace([".", "-"], "", $_POST['cpf']);
            $qb = $this->getEM()->createQueryBuilder();
            $qb->select('prontuario.id, prontuario.dtcadastro')
                    ->from('\TCE\SAN\models\Prontuario', 'prontuario')
                    ->innerJoin('prontuario.idpaciente', 'paciente')
                    ->where('paciente.cpf = :cpf')
                    ->setParameter('cpf', $cpf)
                    ->orderBy('prontuario.dtcadastro', 'DESC');
            $resultado = $qb->getQuery()->getArrayResult();
            $retorno = array_slice($resultado, $_POST['start'], $_POST['limit']);
            foreach ($retorno as &$item) {
                $item['dtcadastro'] = date('d/m/Y H:i:s', strtotime($item['dtcadastro']));
            }
            $this->array_walk_recursive_referential($retorno, 'utf8_encode');
            return [
                'raiz' => $retorno,
                'totalCount' => count($resultado),
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
    public function getProntuario()
    {
        try {
            $qb = $this->getEM()->createQueryBuilder();
            $qb->select('pat.id patologia, p.massa, p.altura, p.fumante, p.bebidasalcoolicas,
                        p.protesedentaria, p.desconfortointestinal, p.cansacodesanimofrequente,
                        p.hipertensaomedicamento usomedicamentodescricaoHipertensao,
                        p.obesidademedicamento usomedicamentodescricaoObesidade, p.perdadepeso ppe,
                        p.gripealergia, p.coposdeagua aguadia, p.dtcadastro, sg.id sintomagastrointestinal,
                        ag.id avaliacaoglobal, dm.id diagnosticometabolico')
                    ->from('\TCE\SAN\models\Prontuario', 'p')
                    ->innerJoin('p.idsintomagastrointestinal', 'sg')
                    ->innerJoin('p.idpatologia', 'pat')
                    ->innerJoin('p.idavaliacaoglobal', 'ag')
                    ->innerJoin('p.iddiagnosticometabolico', 'dm')
                    ->where('p.id = :id')
                    ->setParameter('id', $_POST['id']);
            $resultado = $qb->getQuery()->getOneOrNullResult();
            if (!empty($resultado['usomedicamentodescricaoHipertensao'])) {
                $resultado['usomedicamentoHipertensao'] = 1;
                $resultado['fieldsetHipertensao-checkbox'] = 1;
            }
            if (!empty($resultado['usomedicamentodescricaoObesidade'])) {
                $resultado['usomedicamentoObesidade'] = 1;
                $resultado['fieldsetObesidade-checkbox'] = 1;
            }

            $qb2 = $this->getEM()->createQueryBuilder();
            $qb2->select('pd.id,pd.medicamento,pd.usoinsulina,pd.diabeticofamilia ,pd.complicacoesepidermicas,
                            pd.complicacoesneurologicas,pd.complicacoesvisuais,pd.complicacoesrenais')
                    ->from('\TCE\SAN\models\Prontuariodiabetes', 'pd')
                    ->innerJoin('pd.idprontuario', 'p')
                    ->where('p.id = :id')
                    ->setParameter('id', $_POST['id']);
            $resultadoDiabetes = $qb2->getQuery()->getOneOrNullResult();
            if (!empty($resultadoDiabetes)) {
                $resultado['fieldsetDiabetes-checkbox'] = 1;
                $resultado['pc-renais'] = $resultadoDiabetes['complicacoesrenais'];
                $resultado['pc-visuais'] = $resultadoDiabetes['complicacoesvisuais'];
                $resultado['pc-neurologicas'] = $resultadoDiabetes['complicacoesneurologicas'];
                $resultado['pc-epidermicas'] = $resultadoDiabetes['complicacoesepidermicas'];
                $resultado['familiaDiabetes'] = $resultadoDiabetes['diabeticofamilia'];
                $resultado['insulinaDiabetes'] = $resultadoDiabetes['usoinsulina'];
                $resultado['usomedicamentodescricaoDiabetes'] = $resultadoDiabetes['medicamento'];
                $resultado['usomedicamentoDiabetes'] = NULL;
                if (!empty($resultadoDiabetes['medicamento'])) {
                    $resultado['usomedicamentoDiabetes'] = 1;
                }
            }
            return [
                'dados' => $resultado,
                'success' => TRUE,
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

//    /** @RemoteMethod */
//    public function getSexo()
//    {
//        try {
//            if (!isset($_POST['id'])) {
//                return [
//                    'success' => FALSE,
//                    'msg' => 'Código não enviado.',
//                    'title' => 'Falha'
//                ];
//            }
//            $qb = $this->getEM()->createQueryBuilder();
//            $qb->select('p.id, p.descricao')
//                    ->from('\TCE\SAN\models\Sexo', 'p')
//                    ->where('p.id = :id')
//                    ->setParameter('id', trim($_POST['id']));
//            $retorno = $qb->getQuery()->getArrayResult();
//            $this->array_walk_recursive_referential($retorno[0], 'utf8_encode');
//            return [
//                'success' => TRUE,
//                'dados' => $retorno[0]
//            ];
//        } catch (\Exception $e) {
//            return [
//                'success' => FALSE,
//                'msg' => 'Ocorreu um erro.',
//                'title' => 'Falha',
//                'erro' => $e->getMessage(),
//                'sql' => $this->SqlProfiler()
//            ];
//        }
//    }
//
//    /** @RemoteMethod */
//    public function salvarSexo()
//    {
//        try {
//            $sexo = NULL;
//            if (isset($_POST['id']) && !empty($_POST['id'])) {
//                $sexo = $this->getEM()
//                        ->getRepository('\TCE\SAN\models\Sexo')
//                        ->findOneBy(['id' => trim($_POST['id'])]);
//            } else {
//                $sexo = new \TCE\SAN\models\Sexo();
//            }
//            $sexo->setDescricao(trim($_POST['descricao']));
//            $this->getEM()->persist($sexo);
//            $this->getEM()->flush();
//            return [
//                'success' => TRUE,
//                'msg' => 'Salvo com sucesso.',
//                'title' => 'Sucesso'
//            ];
//        } catch (\Exception $e) {
//            return [
//                'success' => FALSE,
//                'msg' => 'Não foi possível salvar.',
//                'title' => 'Falha',
//                'erro' => $e->getMessage(),
//                'sql' => $this->SqlProfiler()
//            ];
//        }
//    }
//
//    /** @RemoteMethod */
//    public function excluirSexo()
//    {
//        try {
//            if (!isset($_POST['id'])) {
//                return [
//                    'success' => FALSE,
//                    'msg' => 'Código não enviado.',
//                    'title' => 'Falha'
//                ];
//            }
//            $sexo = $this->getEM()
//                    ->getRepository('\TCE\SAN\models\Sexo')
//                    ->findOneBy(['id' => trim($_POST['id'])]);
//            if (empty($sexo)) {
//                return [
//                    'success' => FALSE,
//                    'msg' => 'Registro não encontrado.',
//                    'title' => 'Falha'
//                ];
//            }
//            $this->getEM()->remove($sexo);
//            $this->getEM()->flush();
//            return [
//                'success' => TRUE,
//                'msg' => 'Excluído com sucesso.',
//                'title' => 'Sucesso'
//            ];
//        } catch (\Exception $e) {
//            return [
//                'success' => FALSE,
//                'msg' => 'Não foi possível salvar.',
//                'title' => 'Falha',
//                'erro' => $e->getMessage(),
//                'sql' => $this->SqlProfiler()
//            ];
//        }
//    }
}