<?php

namespace TCE;

/**
 * Classe que implementa ações referente a um
 * aplicativo.
 * @package SAN
 * @subpackage controllers
 * @RemoteClass
 */
class SAN extends \Champion\App {

    /**
     * Armazena o namespace javascript do aplicativo atual
     * @var string
     * @example TCE.SAN
     */
    public $appNamespace;

    /**
     * Instância do controller Login
     * @var TCE\Autenticat\controllers\Login
     */
    protected $login;

    public function __construct()
    {
        $this->appNamespace = str_ireplace("\\", ".", __CLASS__);
        $this->login = new \TCE\Autenticar\controllers\Login();
        $this->exibeAutenticacaoCertificacao = FALSE;
        parent::__construct();
    }

    /**
     * @return HTML_AJAX_Action
     * @RemoteMethod
     * @Index
     */
    public function index()
    {
        try {
            parent::index();
            if ($this->login->isAuth()) {
                $sistema_id = $this->login->getUsuarioPerfil()->getSistemaPelaURL();
                if ($sistema_id['success']) {
                    if ($this->login->_usuarioTemPermissaoNoSistema()) {
                        if ($this->login->temPerfil(NULL, ["Administrador"])) {
                            $this->response->insertScript($this->_minify("
                                Ext.getCmp('menuPrincipal').add([
                                   {
                                      text: 'Cadastro de Paciente',
                                      iconCls: 'silk-application-form',
                                      handler: function() {
                                         TCE.SAN.exibirFormulario('SAN.form.Paciente', true);
                                      }
                                   },
                                   {
                                      text: 'Prontuário Médico',
                                      iconCls: 'silk-book',
                                      handler: function() {
                                         TCE.SAN.exibirJanela('SAN.window.Prontuario', true);
                                      }
                                   },
                                   {
                                        text: 'Cadastros',
                                        iconCls: 'silk-application',
                                        menu:[
                                        {
                                            text: 'Cor',
                                            handler: function() {
                                                TCE.SAN.exibirFormulario('SAN.form.Cor', true);
                                            }
                                        },
                                        {
                                            text: 'Estado Civil',
                                            handler: function() {
                                                TCE.SAN.exibirFormulario('SAN.form.EstadoCivil', true);
                                            }
                                        },
                                        {
                                            text: 'Sexo',
                                            handler: function() {
                                                TCE.SAN.exibirFormulario('SAN.form.Sexo', true);
                                            }
                                        },
                                        {
                                            text: 'Cidade',
                                            handler: function() {
                                                TCE.SAN.exibirFormulario('SAN.form.Cidade', true);
                                            }
                                        },
                                        {
                                            text: 'Profissão',
                                            handler: function() {
                                                TCE.SAN.exibirFormulario('SAN.form.Profissao', true);
                                            }
                                        },
                                        {
                                            text: 'Telefone Tipo',
                                            handler: function() {
                                                TCE.SAN.exibirFormulario('SAN.form.TelefoneTipo', true);
                                            }
                                        },
                                        {
                                            text: 'Estado',
                                            handler: function() {
                                                TCE.SAN.exibirFormulario('SAN.form.Estado', true);
                                            }
                                        },
                                        {
                                            text: 'Sintoma Gastrointestinal',
                                            handler: function() {
                                                TCE.SAN.exibirFormulario('SAN.form.SintomaGastrointestinal', true);
                                            }
                                        },
                                        {
                                            text: 'Composição do Alimento',
                                            handler: function() {
                                                TCE.SAN.exibirFormulario('SAN.form.TipoComposicao', true);
                                            }
                                        },
                                        {
                                            text: 'Diagnóstico Metabólico',
                                            handler: function() {
                                                TCE.SAN.exibirFormulario('SAN.form.DiagnosticoMetabolico', true);
                                            }
                                        },
                                        {
                                            text: 'Unidade de Medida',
                                            handler: function() {
                                                TCE.SAN.exibirFormulario('SAN.form.UnidadeMedida', true);
                                            }
                                        },
                                        {
                                            text: 'Avaliação Global',
                                            handler: function() {
                                                TCE.SAN.exibirFormulario('SAN.form.AvaliacaoGlobal', true);
                                            }
                                        },
                                        {
                                            text: 'Tipo de Dieta',
                                            handler: function() {
                                                TCE.SAN.exibirFormulario('SAN.form.TipoDieta', true);
                                            }
                                        },
                                        {
                                            text: 'Grupo de Alimento',
                                            handler: function() {
                                                TCE.SAN.exibirFormulario('SAN.form.GrupoAlimento', true);
                                            }
                                        },
                                        {
                                            text: 'Patologia',
                                            handler: function() {
                                                TCE.SAN.exibirFormulario('SAN.form.Patologia', true);
                                            }
                                        }
                                        ]
                                   },
                                   {
                                      text: 'Sair',
                                      iconCls: 'silk-door-out',
                                      handler: function() {
                                         TCE.Autenticar.encerrar();
                                      }
                                   },
                                   '->',
                                   " . $this->getBotaoInformacaoesUsuario() . "
                                   ]
                                );
                           "));
                        }
                    } else {
                        throw new \Champion\Exception("Você não tem permissão para acessar este sistema.");
                    }
                } else {
                    throw new \Champion\Exception($sistema_id['msg']);
                }
            }
        } catch (\Champion\Exception $exc) {
            $this->response->insertScript($this->_minify("
                Ext.getCmp('menuPrincipal').add([{
                    text:'Sair',
                    iconCls: 'silk-door-out',
                    handler: function() {
                       " . $this->appNamespace . ".encerrar();
                    }
                },
                '->',
                " . $this->getBotaoInformacaoesUsuario() . "
                ]);
                Ext.Msg.show({
                    closable: false,
                    modal: true,
                    title: 'Falha de acesso',
                    icon: Ext.Msg.ERROR,
                    msg: '" . $exc->getMessage() . "',
                    buttons: Ext.Msg.OK,
                    fn: function() {
                        Ext.getCmp('menuSistemas').expand();
                    }
                });
            "));
        }
        return $this->response;
    }

}
