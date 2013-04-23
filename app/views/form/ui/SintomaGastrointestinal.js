Ext.define('SAN.form.ui.SintomaGastrointestinal', {
    extend: 'Champion.form.Base',
    title: 'Sintomas Gastrointestinais',
    bodyPadding: 5,
    layout: 'fit',
    initComponent: function() {
        var me = this;
        Ext.apply(me, {
            tbar: [
            this.getBotaoNovo(),
            this.getBotaoEditar(),
            this.getBotaoExcluir()
            ],
            items: [
            this.getGridSistema()
            ]
        });
        me.callParent(arguments);
    },
    getBotaoNovo: function() {
        if (!this.botaoNovo) {
            this.botaoNovo = Ext.widget("button", {
                text: 'Novo',
                iconCls: 'silk-application-add',
                handler: function() {
                    Ext.create('SAN.window.SintomaGastrointestinal').show();
                },
                scope: this
            });
        }
        return this.botaoNovo;
    },
    getBotaoEditar: function() {
        if (!this.botaoEditar) {
            this.botaoEditar = Ext.widget("button", {
                text: 'Editar',
                name:'editar',
                iconCls: 'silk-application-edit',
                disabled: true,
                handler: function() {
                    var record = this.getGridSistema().getSelectionModel().getSelection();
                    Ext.create('SAN.window.SintomaGastrointestinal', {
                        sintomagastrointestinal_id: record[0].data.id
                    }).show();
                },
                scope: this
            });
        }
        return this.botaoEditar;
    },
    getGridSistema: function() {
        if (!this.gridSistema) {
            this.gridSistema = Ext.widget("gridpanel",
            {
                xtype: 'gridpanel',
                title: 'Sintomas Gastrointestinais Cadastrados',
                store:this.storeSintomaGastrointestinal,
                columns: [
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'id',
                    flex: 1,
                    text: 'Id'
                },
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'descricao',
                    flex: 3,
                    text: 'Descrição'
                }
                ],
                listeners: {
                    itemclick: function(el, record) {
                        this.down('button[name=excluir]').enable();
                        this.down('button[name=editar]').enable();
                    },
                    itemdblclick: function(el, record) {
                        Ext.create('SAN.window.SintomaGastrointestinal', {
                            sintomagastrointestinal_id: record.data.id
                        }).show();
                    },
                    scope: this
                },
                dockedItems: [
                {
                    xtype: 'pagingtoolbar',
                    dock: 'bottom',
                    store:this.storeSintomaGastrointestinal,
                    displayInfo: true
                }
                ]
            });
        }
        return this.gridSistema;
    },
    getBotaoExcluir: function() {
        if (!this.botaoExcluir) {
            this.botaoExcluir = Ext.widget("button", {
                xtype: 'button',
                text: 'Excluir',
                name:'excluir',
                iconCls:'silk-application-delete',
                disabled:true,
                scope:this,
                handler:function(){
                    var record = this.getGridSistema().getSelectionModel().getSelection();
                    Ext.Msg.show({
                        title: 'Confirmação de remoção',
                        msg: 'Deseja realmente remover?',
                        buttons: Ext.Msg.YESNO,
                        icon: Ext.Msg.QUESTION,
                        fn: function(resp) {
                            if (resp == 'yes') {
                                Ext.Ajax.request({
                                    url: TCE.SAN.getUrlController('SintomaGastrointestinal','excluirSintomaGastrointestinal'),
                                    params: {
                                        id:record[0].data.id
                                    },
                                    scope:this,
                                    success: function(response) {
                                        var resposta = Ext.decode(response.responseText);
                                        if(resposta.success){
                                            this.down('button[name=excluir]').disable();
                                            this.down('button[name=editar]').disable();
                                            this.getGridSistema().getStore().load();
                                        }
                                        Ext.Msg.show({
                                            modal: true,
                                            title: resposta.title,
                                            msg: resposta.msg,
                                            buttons: Ext.Msg.OK,
                                            icon: Ext.Msg.INFO
                                        });
                                    },
                                    failure: function(response) {
                                        var resposta = Ext.decode(response.responseText);
                                        Ext.Msg.show({
                                            modal: true,
                                            title: resposta.title,
                                            msg: resposta.msg,
                                            buttons: Ext.Msg.OK,
                                            icon: Ext.Msg.ERROR
                                        });
                                    }
                                });
                            }
                        },
                        scope: this
                    });
                }
            });
        }
        return this.botaoExcluir;
    }
});