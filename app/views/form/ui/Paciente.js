Ext.define('SAN.form.ui.Paciente', {
    extend: 'Champion.form.Base',
    requires:['Ext.ux.CpfField'],
    bodyPadding: 10,
    autoScroll:true,
    title: 'Formulário de Cadastro',
    desativarTodosOsCampos:function(){
        var textfields = this.query('textfield:not([name!=cpf])');
        var comboboxes = this.query('combobox');
        var grids = this.query('gridpanel');
        Ext.each(textfields,function(textfield,index){
            textfield.disable();
        });
        Ext.each(comboboxes,function(combobox,index){
            combobox.disable();
        });
        Ext.each(grids,function(grid,index){
            grid.disable();
        });
    },
    ativarTodosOsCampos:function(){
        var textfields = this.query('textfield');
        var comboboxes = this.query('combobox:not([name!=cidade])');
        var grids = this.query('gridpanel');
        Ext.each(textfields,function(textfield,index){
            textfield.enable();
        });
        Ext.each(comboboxes,function(combobox,index){
            combobox.enable();
        });
        Ext.each(grids,function(grid,index){
            grid.enable();
        });
    },
    getCpf:function(){
        var cpf = this.down('cpffield[name=cpf]').getValue();
        return cpf
    },
    initComponent: function() {
        var me = this;
        var rowEditing = Ext.create('Ext.grid.plugin.RowEditing', {
            clicksToMoveEditor: 1,
            errorsText: 'Erro',
            dirtyText: '',
            autoCancel: false
        });
        Ext.applyIf(me, {
            items: [
            {
                xtype: 'tabpanel',
                border: false,
                activeTab: 0,
                autoScroll:true,
                items: [
                {
                    xtype: 'form',
                    border: false,
                    autoScroll:true,
                    title: 'Dados do Paciente',
                    items: [
                    {
                        xtype: 'fieldset',
                        //                        title: 'Dados do Paciente',
                        items: [
                        {
                            xtype: 'fieldcontainer',
                            margin: '10 0 10 0',
                            layout: {
                                align: 'stretch',
                                type: 'hbox'
                            },
                            fieldLabel: '',
                            items: [
                            {
                                xtype: 'cpffield',
                                flex: 1,
                                name:'cpf',
                                fieldLabel: 'CPF',
                                allowBlank:false,
                                labelWidth: 25,
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
                                                url:TCE.SAN.getUrlController('Paciente','carregarPaciente'),
                                                success:function(response){
                                                    var resposta = Ext.decode(response.responseText);
                                                    if(resposta.success) {
                                                        Ext.Msg.show({
                                                            title: resposta.title,
                                                            msg: resposta.msg,
                                                            buttons: Ext.Msg.OK,
                                                            icon: Ext.Msg.INFO
                                                        });
                                                        var forms = scopeThis.query('form');
                                                        Ext.each(forms, function(form,index){
                                                            form.getForm().setValues(resposta.dados);
                                                        });
                                                        scopeThis.down('combobox[name=cidade]').enable();
                                                        scopeThis.storeCidade.load({
                                                            params:{
                                                                estado:resposta.dados.estado
                                                            }
                                                        });
                                                        scopeThis.storeTelefone.getProxy().extraParams.cpf = cpf;
                                                        scopeThis.storeEndereco.getProxy().extraParams.cpf = cpf;
                                                        scopeThis.storeTelefone.load();
                                                        scopeThis.storeEndereco.load();
                                                    }
                                                    me.ativarTodosOsCampos();
                                                },
                                                failure:function(response){
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
                                flex: 4,
                                margin: '0 0 0 10',
                                name:'nome',
                                fieldLabel: 'Nome',
                                allowBlank:false,
                                labelWidth: 40
                            }
                            ]
                        },
                        {
                            xtype: 'textfield',
                            anchor: '100%',
                            margin: '10 0 10 0',
                            fieldLabel: 'Pai',
                            name:'pai',
                            allowBlank:false,
                            labelWidth: 40
                        },
                        {
                            xtype: 'textfield',
                            anchor: '100%',
                            margin: '10 0 10 0',
                            fieldLabel: 'Mãe',
                            name:'mae',
                            allowBlank:false,
                            labelWidth: 40
                        },
                        {
                            xtype: 'fieldcontainer',
                            margin: '10 0 10 0',
                            layout: {
                                align: 'stretch',
                                type: 'hbox'
                            },
                            fieldLabel: '',
                            items: [
                            {
                                xtype: 'textfield',
                                flex: 1,
                                name:'rg',
                                fieldLabel: 'RG',
                                allowBlank:false,
                                labelWidth: 25
                            },
                            {
                                xtype: 'datefield',
                                flex: 1.5,
                                margins: '0 0 0 10',
                                name:'dataexpedicao',
                                submitFormat:'Y-m-d',
                                fieldLabel: 'Data de Expedição',
                                allowBlank:false,
                                labelWidth: 120
                            },
                            {
                                xtype: 'textfield',
                                flex: 1,
                                margins: '0 0 0 10',
                                name:'orgaoexpedidor',
                                fieldLabel: 'Orgão Expedidor',
                                allowBlank:false,
                                labelWidth: 110
                            }
                            ]
                        },
                        {
                            xtype: 'fieldcontainer',
                            margin: '10 0 10 0',
                            layout: {
                                align: 'stretch',
                                type: 'hbox'
                            },
                            fieldLabel: '',
                            items: [
                            {
                                xtype: 'datefield',
                                flex: 2,
                                name:'datanascimento',
                                submitFormat:'Y-m-d',
                                fieldLabel: 'Data de Nascimento',
                                allowBlank:false,
                                labelWidth: 130
                            },
                            {
                                xtype: 'combobox',
                                flex: 1,
                                margins: '0 0 0 10',
                                fieldLabel: 'Sexo',
                                store:this.storeSexo,
                                valueField:'id',
                                forceSelection:true,
                                queryMode:'local',
                                displayField:'descricao',
                                name:'sexo',
                                allowBlank:false,
                                labelWidth: 35
                            },
                            {
                                xtype: 'combobox',
                                flex: 1.5,
                                margins: '0 0 0 10',
                                fieldLabel: 'Estado Civil',
                                store:this.storeEstadoCivil,
                                valueField:'id',
                                forceSelection:true,
                                queryMode:'local',
                                displayField:'descricao',
                                name:'estadocivil',
                                allowBlank:false,
                                labelWidth: 75
                            },
                            {
                                xtype: 'combobox',
                                flex: 1.5,
                                margins: '0 0 0 10',
                                fieldLabel: 'Cor',
                                store:this.storeCor,
                                valueField:'id',
                                forceSelection:true,
                                queryMode:'local',
                                displayField:'descricao',
                                name:'cor',
                                allowBlank:false,
                                labelWidth: 25
                            }
                            ]
                        },
                        {
                            xtype: 'fieldcontainer',
                            margin: '10 0 10 0',
                            layout: {
                                align: 'stretch',
                                type: 'hbox'
                            },
                            fieldLabel: '',
                            items: [
                            {
                                xtype: 'combobox',
                                flex: 2,
                                store:this.storeEstado,
                                valueField:'id',
                                forceSelection:true,
                                queryMode:'local',
                                displayField:'descricao',
                                name:'estado',
                                fieldLabel: 'Estado',
                                allowBlank:false,
                                labelWidth: 90,
                                listeners:{
                                    scope:this,
                                    select:function(combo,records){
                                        var estado = records[0].data.id;
                                        this.storeCidade.load({
                                            params:{
                                                estado:estado
                                            }
                                        });
                                        this.down('combobox[name=cidade]').enable();
                                    }
                                }
                            },
                            {
                                xtype: 'combobox',
                                flex: 2,
                                margins: '0 0 0 10',
                                disabled:true,
                                fieldLabel: 'Cidade',
                                store:this.storeCidade,
                                valueField:'id',
                                forceSelection:true,
                                queryMode:'local',
                                displayField:'descricao',
                                name:'cidade',
                                allowBlank:false,
                                labelWidth: 90
                            }
                            ]
                        },
                        {
                            xtype: 'fieldcontainer',
                            margin: '10 0 10 0',
                            layout: {
                                align: 'stretch',
                                type: 'hbox'
                            },
                            fieldLabel: '',
                            items: [
                            {
                                xtype: 'textfield',
                                flex: 1.3,
                                name:'numerosus',
                                regex: /^\d{15}$/i,
                                maskRe: /\d/i,
                                regexText: 'Deve ter 15 números',
                                allowBlank:false,
                                fieldLabel: 'Número do SUS'
                            },
                            {
                                xtype: 'textfield',
                                flex: 3,
                                margins: '0 0 0 10',
                                name:'responsavel',
                                fieldLabel: 'Responsável',
                                allowBlank:false,
                                labelWidth: 80
                            }
                            ]
                        }
                        ]
                    },
                    {
                        xtype: 'button',
                        style: 'float:right;',
                        text: 'Proximo Passo >>',
                        handler:function(){
                            me.down('tabpanel').setActiveTab(1);
                        }
                    }
                    ]
                },
                {
                    xtype: 'form',
                    border: false,
                    title: 'Informações Adicionais',
                    layout:'anchor',
                    items: [
                    {
                        xtype: 'fieldset',
                        title: 'Telefones',
                        items: [
                        {
                            xtype: 'gridpanel',
                            name:'gridTelefone',
                            title: 'Telefones cadastrados',
                            height:200,
                            store:this.storeTelefone,
                            listeners:{
                                itemclick:function(grid,record,item){
                                    this.down('button[name=BtnRemoverTelefone]').enable();
                                }
                            },
                            columns: [
                            {
                                dataIndex: 'id',
                                hideable:false,
                                hidden:true
                            },
                            {
                                header: 'Número',
                                dataIndex: 'numero',
                                flex: 1,
                                editor: {
                                    allowBlank: false
                                }
                            },
                            {
                                dataIndex: 'tipotelefone',
                                header: 'Tipo Telefone',
                                flex: 3,
                                scope:this,
                                renderer: function(val){
                                    console.debug(val);
                                    var index = this.storeTelefoneTipo.findExact('tipotelefone',val);
                                    if (index != -1){
                                        rs = this.storeTelefoneTipo.getAt(index).data;
                                        return rs.descricao;
                                    }
                                },
                                editor:
                                Ext.widget({
                                    xtype:'combobox',
                                    scope:this,
                                    typeAhead: true,
                                    triggerAction: 'all',
                                    selectOnTab: true,
                                    displayField: 'descricao',
                                    name:'tipotelefone',
                                    valueField: 'tipotelefone',
                                    store: this.storeTelefoneTipo,
                                    lazyRender: true,
                                    allowBlank: false,
                                    forceSelection:true,
                                    listClass: 'x-combo-list-small'
                                })
                            }
                            ],
                            plugins: [Ext.create('Ext.grid.plugin.RowEditing')],
                            dockedItems: [
                            {
                                xtype: 'toolbar',
                                items: [
                                {
                                    text: 'Adicionar',
                                    name:'BtnAddTelefone',
                                    iconCls: 'silk-add',
                                    scope:this,
                                    handler: function(){
                                        this.storeTelefone.add({});
                                    }
                                }, '-', {
                                    itemId: 'delete',
                                    text: 'Remover',
                                    name:'BtnRemoverTelefone',
                                    iconCls: 'silk-delete',
                                    disabled: true,
                                    scope:this,
                                    handler: function(){
                                        var selection = this.down('gridpanel[name=gridTelefone]').getView().getSelectionModel().getSelection()[0];
                                        if (selection) {
                                            this.storeTelefone.remove(selection);
                                        }
                                        this.down('button[name=BtnRemoverTelefone]').disable();
                                    }
                                }]
                            },
                            {
                                xtype: 'pagingtoolbar',
                                dock: 'bottom',
                                store:this.storeTelefone,
                                displayInfo: true
                            }
                            ]
                        }
                        ]
                    },
                    {
                        xtype: 'fieldset',
                        title: 'Endereços',
                        items: [
                        {
                            xtype: 'gridpanel',
                            name:'gridEndereco',
                            title: 'Endereços cadastrados',
                            height:200,
                            store:this.storeEndereco,
                            listeners:{
                                itemclick:function(grid,record,item){
                                    this.down('button[name=BtnRemoverEndereco]').enable();
                                }
                            },
                            columns: [
                            {
                                dataIndex: 'id',
                                hideable:false,
                                hidden:true
                            },
                            {
                                header: 'Logradouro',
                                dataIndex: 'logradouro',
                                flex: 1,
                                editor: {
                                    allowBlank: false
                                }
                            },
                            {
                                header: 'Número',
                                dataIndex: 'numero',
                                flex: 1,
                                editor: {
                                    allowBlank: false
                                }
                            },
                            {
                                header: 'CEP',
                                dataIndex: 'cep',
                                flex: 1,
                                editor: {
                                    allowBlank: false
                                }
                            },
                            {
                                header: 'Complemento',
                                dataIndex: 'complemento',
                                flex: 1,
                                editor: {
                                    allowBlank: false
                                }
                            },
                            {
                                dataIndex: 'cidade',
                                header: 'Cidade',
                                flex: 3,
                                scope:this,
                                renderer: function(val){
                                    var index = this.storeCidade.findExact('id',val);
                                    if (index != -1){
                                        rs = this.storeCidade.getAt(index).data;
                                        return rs.descricao;
                                    }
                                },
                                editor:
                                Ext.widget({
                                    xtype:'combobox',
                                    scope:this,
                                    typeAhead: true,
                                    triggerAction: 'all',
                                    selectOnTab: true,
                                    displayField: 'descricao',
                                    name:'cidade',
                                    valueField: 'id',
                                    store: this.storeCidade,
                                    lazyRender: true,
                                    allowBlank: false,
                                    forceSelection:true,
                                    listClass: 'x-combo-list-small'
                                })
                            }
                            ],
                            plugins: [Ext.create('Ext.grid.plugin.RowEditing', {
                                clicksToMoveEditor: 1,
                                errorsText: 'Erro',
                                dirtyText: '',
                                autoCancel: false
                            })],
                            dockedItems: [
                            {
                                xtype: 'toolbar',
                                items: [
                                {
                                    text: 'Adicionar',
                                    name:'BtnAddEndereco',
                                    iconCls: 'silk-add',
                                    scope:this,
                                    handler: function(){
                                        this.storeEndereco.add({});
                                    }
                                }, '-', {
                                    itemId: 'delete',
                                    text: 'Remover',
                                    name:'BtnRemoverEndereco',
                                    iconCls: 'silk-delete',
                                    disabled: true,
                                    scope:this,
                                    handler: function(){
                                        var selection = this.down('gridpanel[name=gridEndereco]').getView().getSelectionModel().getSelection()[0];
                                        if (selection) {
                                            this.storeEndereco.remove(selection);
                                        }
                                        this.down('button[name=BtnRemoverEndereco]').disable();
                                    }
                                }]
                            },
                            {
                                xtype: 'pagingtoolbar',
                                dock: 'bottom',
                                store:this.storeEndereco,
                                displayInfo: true
                            }
                            ]
                        }
                        ]
                    },
                    {
                        xtype: 'button',
                        style: 'float:right;',
                        margin:'0 0 0 10',
                        text: 'Próximo Passo >>',
                        handler:function(){
                            me.down('tabpanel').setActiveTab(2);
                        }
                    },
                    {
                        xtype: 'button',
                        style: 'float:right;',
                        text: '<< Voltar Passo',
                        handler:function(){
                            me.down('tabpanel').setActiveTab(1);
                        }
                    }
                    ]
                },
                {
                    xtype: 'form',
                    border: false,
                    title: 'Outras Informações',
                    items: [
                    {
                        xtype: 'fieldset',
                        items: [
                        {
                            xtype: 'combobox',
                            queryMode:'remote',
                            valueField:'id',
                            displayField:'descricao',
                            name:'profissao',
                            hideTrigger:true,
                            forceSelection:true,
                            allowBlank:false,
                            store:this.storeProfissoes,
                            anchor: '100%',
                            fieldLabel: 'Profissão',
                            labelWidth: 75
                        },
                        {
                            xtype: 'textfield',
                            anchor: '100%',
                            name:'email',
                            allowBlank:false,
                            regex:/^([0-9a-zA-Z]+([_.-]?[0-9a-zA-Z]+)*@[0-9a-zA-Z]+[0-9,a-z,A-Z,.,-]*(.){1}[a-zA-Z]{2,4})+$/,
                            fieldLabel: 'Email',
                            labelWidth: 75
                        },
                        {
                            xtype: 'textareafield',
                            anchor: '100%',
                            name:'observacao',
                            fieldLabel: 'Observação',
                            labelWidth: 75
                        }
                        ]
                    },
                    {
                        xtype: 'button',
                        margin:'0 0 0 10',
                        iconCls:'silk-disk',
                        style: 'float:right;',
                        text: 'Salvar Cadastro',
                        scope:this,
                        handler:function() {
                            var forms = this.query('form');
                            if(forms[0].getForm().isValid() && forms[1].getForm().isValid() && forms[2].getForm().isValid()){
                                forms[0].getForm().submit({
                                    url:TCE.SAN.getUrlController('Paciente','salvarPaciente'),
                                    params:{
                                        outras: Ext.JSON.encode(forms[2].getForm().getValues()),
                                        adicionais:Ext.JSON.encode(forms[1].getForm().getValues())
                                    },
                                    scope:this,
                                    success:function(form,action){
                                        if(action.result.success){
                                            Ext.Msg.show({
                                                title: action.result.title,
                                                msg: action.result.msg,
                                                buttons: Ext.Msg.OK,
                                                icon: Ext.Msg.INFO
                                            });
                                        } else {
                                            Ext.Msg.show({
                                                title: action.result.title,
                                                msg: action.result.msg,
                                                buttons: Ext.Msg.OK,
                                                icon: Ext.Msg.WARNING
                                            });
                                        }
                                        this.storeTelefone.getProxy().extraParams.cpf = me.down('textfield[name=cpf]').getValue();
                                        this.storeTelefone.sync({
                                            success: function(){
                                            },
                                            failure: function(){
                                            },
                                            scope: this
                                        });

                                        this.storeEndereco.getProxy().extraParams.cpf = me.down('textfield[name=cpf]').getValue();
                                        this.storeEndereco.sync({});

                                    },
                                    failure:function(form,action){
                                        Ext.Msg.show({
                                            title: 'Falha',
                                            msg: 'Não foi possível salvar as informações. Tente novamente',
                                            buttons: Ext.Msg.OK,
                                            icon: Ext.Msg.WARNING
                                        });
                                    }
                                });
                            }
                        }
                    },
                    {
                        xtype: 'button',
                        style: 'float:right;',
                        text: '<< Voltar Passo',
                        handler:function(){
                            me.down('tabpanel').setActiveTab(2);
                        }
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