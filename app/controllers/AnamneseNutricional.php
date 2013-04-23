<?php

namespace TCE\SAN\controllers;

/**
 * @RemoteClass
 */
class AnamneseNutricional extends \Champion\Controller {

    /** @RemoteMethod */
    public function carregarAnamneseNutricional()
    {
        try {
            if (!isset($_POST['id'])) {
                return [
                    'success' => FALSE,
                    'msg' => 'Código não enviado.',
                    'title' => 'Falha'
                ];
            }

//            $qb = $this->getEM()->createQueryBuilder();
//            $resultado = $qb->getQuery()->getArrayResult();

            return [
                'success' => TRUE,
//                'dados' => $resultado
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
    public function salvarAnamneseNutricional()
    {
        try {
            $_POST['cpfPaciente'] = '03304808124';
            if (!isset($_POST['cpfPaciente'])) {
                return [
                    'success' => FALSE,
                    'msg' => 'Paciente não encontrado.',
                    'title' => 'Falha'
                ];
            }
            $this->getConnection()->beginTransaction();
            $this->array_walk_recursive_referential($_POST, 'trim');

            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $prontuario = $this->getEM()
                        ->getRepository('\TCE\SAN\models\Prontuario')
                        ->findOneBy(['id' => $_POST['id']]);
            } else {
                $prontuario = new \TCE\SAN\models\Prontuario();
                $paciente = $this->getEM()
                        ->getRepository('\TCE\SAN\models\Paciente')
                        ->findOneBy(['cpf' => $_POST['cpfPaciente']]);
                $prontuario->setIdpaciente($paciente);
            }
            $patologia = $this->getEM()
                    ->getRepository('\TCE\SAN\models\Patologia')
                    ->findOneBy(['id' => $_POST['patologia']]);
            $prontuario->setIdpatologia($patologia);
            $prontuario->setMassa($_POST['massa']);
            $prontuario->setAltura($_POST['altura']);
            $prontuario->setFumante(isset($_POST['fumante']) ? $_POST['fumante'] : 0);
            $prontuario->setBebidasalcoolicas(isset($_POST['bebidasalcoolicas']) ? $_POST['bebidasalcoolicas'] : 0);
            $prontuario->setProtesedentaria(isset($_POST['protesedentaria']) ? $_POST['protesedentaria'] : 0);
            $prontuario->setDesconfortointestinal(isset($_POST['desconfortointestinal']) ? $_POST['desconfortointestinal'] : 0);
            $prontuario->setCansacodesanimofrequente(isset($_POST['cansacodesanimofrequente']) ? $_POST['cansacodesanimofrequente'] : 0);
            $prontuario->setGripealergia(isset($_POST['gripealergia']) ? $_POST['gripealergia'] : 0);
            $prontuario->setCoposdeagua($_POST['aguadia']);
            $prontuario->setDtcadastro(new \DateTime());

            $avaliacaoglobal = $this->getEM()
                    ->getRepository('\TCE\SAN\models\Avaliacaoglobal')
                    ->findOneBy(['id' => $_POST['avaliacaoglobal']]);
            $prontuario->setIdavaliacaoglobal($avaliacaoglobal);

            $diagnosticometabolico = $this->getEM()
                    ->getRepository('\TCE\SAN\models\Avaliacaoglobal')
                    ->findOneBy(['id' => $_POST['diagnosticometabolico']]);
            $prontuario->setIddiagnosticometabolico($diagnosticometabolico);

            $sintomagastrointestinal = $this->getEM()
                    ->getRepository('\TCE\SAN\models\Avaliacaoglobal')
                    ->findOneBy(['id' => $_POST['sintomagastrointestinal']]);
            $prontuario->setIdsintomagastrointestinal($sintomagastrointestinal);

            if (isset($_POST['fieldsetHipertensao-checkbox'])) {
                $prontuario->setHipertensaomedicamento($_POST['usomedicamentodescricaoHipertensao']);
            }
            if (isset($_POST['fieldsetObesidade-checkbox'])) {
                $prontuario->setObesidademedicamento($_POST['usomedicamentodescricaoObesidade']);
            }

            $prontuario->setPerdadepeso($_POST['ppe']);
            $this->getEM()->persist($prontuario);

            if (isset($_POST['fieldsetDiabetes-checkbox'])) {
                $prontuarioDiabetes = $this->getEM()
                        ->getRepository('\TCE\SAN\models\Prontuariodiabetes')
                        ->findBy(['idprontuario' => $prontuario->getId()]);
                foreach ($prontuarioDiabetes as &$item) {
                    $this->getEM()->remove($item);
                }
                $novoDiabetes = new \TCE\SAN\models\Prontuariodiabetes();
                if (isset($_POST['pc-renais'])) {
                    $novoDiabetes->setComplicacoesrenais($_POST['pc-renais']);
                }
                if (isset($_POST['pc-visuais'])) {
                    $novoDiabetes->setComplicacoesvisuais($_POST['pc-visuais']);
                }
                if (isset($_POST['pc-neurologicas'])) {
                    $novoDiabetes->setComplicacoesneurologicas($_POST['pc-neurologicas']);
                }
                if (isset($_POST['pc-epidermicas'])) {
                    $novoDiabetes->setComplicacoesepidermicas($_POST['pc-epidermicas']);
                }
                if (isset($_POST['familiaDiabetes'])) {
                    $novoDiabetes->setDiabeticofamilia($_POST['familiaDiabetes']);
                }
                if (isset($_POST['familiaDiabetes'])) {
                    $novoDiabetes->setUsoinsulina($_POST['familiaDiabetes']);
                }
                if (isset($_POST['usomedicamentoDiabetes']) && !empty($_POST['usomedicamentodescricaoDiabetes'])) {
                    $novoDiabetes->setMedicamento($_POST['usomedicamentodescricaoDiabetes']);
                }
                $novoDiabetes->setIdprontuario($prontuario);

                $this->getEM()->persist($novoDiabetes);
            }
            $this->getEM()->flush();
            $this->getConnection()->commit();
            return [
                'success' => TRUE,
                'post' => $_POST,
                'msg' => 'Salvo com sucesso.',
                'title' => 'Sucesso'
            ];
        } catch (\Exception $e) {
            $this->getConnection()->rollback();
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