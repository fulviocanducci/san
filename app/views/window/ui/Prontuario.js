Ext.define('SAN.window.ui.Prontuario', {
    extend: 'Champion.window.Base',
    requires:['Ext.ux.CpfField'],
    height: 300,
    width: 637,
    layout: {
        type: 'fit'
    },
    title: 'Selecione o prontuário',
    modal:true,
    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            items: [
            {
                xtype: 'form',
                border: false,
                bodyPadding: 10,
                title: '',
                items: [
                {
                    xtype: 'cpffield',
                    flex: 1,
                    name:'cpf',
                    anchor: '100%',
                    fieldLabel: 'CPF',
                    allowBlank:false,
                    labelWidth: 40,
                    listeners:{
                        scope:this,
                        blur:function(component){
                            var cpf = component.getValue();
                            var scopeThis = this;
                            if(component.isValid()){
                                Ext.Ajax.request({
                                    params:{
                                        cpf:cpf
                                    },
                                    url:TCE.SAN.getUrlController('Paciente','getNomePaciente'),
                                    success:function(response){
                                        var resposta = Ext.decode(response.responseText);
                                        scopeThis.down('textfield[name=nome]').setValue('');
                                        if(resposta.success) {
                                            scopeThis.down('textfield[name=nome]').setValue(resposta.nome);
                                            scopeThis.storeProntuario.getProxy().extraParams.cpf = cpf;
                                            scopeThis.storeProntuario.load();
                                        } else {
                                            Ext.Msg.show({
                                                title: resposta.title,
                                                msg: resposta.msg,
                                                buttons: Ext.Msg.OK,
                                                icon: Ext.Msg.WARNING
                                            });
                                        }
                                    },
                                    failure:function(response){
                                        scopeThis.down('textfield[name=nome]').setValue('');
                                        Ext.Msg.show({
                                            title: 'Falha',
                                            msg: 'Falha na conexão. Tente novamente.',
                                            buttons: Ext.Msg.OK,
                                            icon: Ext.Msg.WARNING
                                        });
                                    }
                                });
                            }
                        }
                    }
                },
                {
                    xtype: 'textfield',
                    anchor: '100%',
                    margin: '10 0 0 0',
                    name:'nome',
                    readOnly: true,
                    fieldLabel: 'Nome',
                    labelWidth: 40
                },
                {
                    xtype: 'gridpanel',
                    margin: '20 0 0 0',
                    store:this.storeProntuario,
                    title: 'Prontuários',
                    columns: [
                    Ext.create('Ext.grid.RowNumberer'),
                    {
                        xtype: 'gridcolumn',
//                        hidden:true,
//                        hideable:false,
                        dataIndex: 'id'
                    },
                    {
                        xtype: 'gridcolumn',
                        flex:1,
                        dataIndex: 'dtcadastro',
                        text: 'Data de Cadastro'
                    }
                    ],
                    listeners: {
                        itemdblclick: function(el, record) {
                            TCE.SAN.exibirFormulario('SAN.form.Prontuario', true,{
                                idprontuario:record.data.id,
                                cpfpaciente:this.down('cpffield[name=cpf]').getValue()
                            });
                            this.close();
                        },
                        scope: this
                    },
                    dockedItems: [
                    {
                        xtype: 'pagingtoolbar',
                        dock: 'bottom',
                        store:this.storeProntuario,
                        displayInfo: true
                    }
                    ]
                }
                ]
            }
            ]
        });

        me.callParent(arguments);
    }

});