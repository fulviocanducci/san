Ext.define('SAN.form.ui.Prontuario', {
    extend: 'Champion.form.Base',
    autoScroll: true,
    bodyPadding: 5,
    title: 'Prontuário Médico',
    getIMCDescricao:function(IMC){
        if(IMC <= 18.5){
            return " Abaixo do peso ideal";
        } else if (IMC > 18.5 && IMC <= 24.9){
            return " Peso normal!";
        } else if (IMC > 24.9 && IMC <= 29.9){
            return " Acima de seu peso (sobrepeso)";
        } else if (IMC > 29.9 && IMC <= 34.9){
            return " Obesidade grau I";
        } else if (IMC > 34.9 && IMC <= 39.9){
            return " Obesidade grau II";
        }
        return "Obesidade grau III";
    },
    getIdProntuario:function(){
        return this.down('hiddenfield[name=idprontuario]').getValue();
    },
    getCpfPaciente:function(){
        return this.down('hiddenfield[name=cpfpaciente]').getValue();
    },
    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            items: [
            {
                xtype:'hiddenfield',
                name:'idprontuario'
            },
            {
                xtype:'hiddenfield',
                name:'cpfpaciente'
            },
            {
                xtype: 'tabpanel',
                activeTab: 0,
                items: [
                {
                    xtype: 'panel',
                    autoScroll: true,
                    title: 'Anamnese Nutricional',
                    items: [
                    {
                        xtype: 'form',
                        name:'formAnamneseNutricional',
                        autoScroll: true,
                        border:false,
                        bodyPadding: 10,
                        title: '',
                        items: [
                        {
                            xtype: 'combobox',
                            anchor: '100%',
                            allowBlank:false,
                            fieldLabel: 'Patologia',
                            store:this.storeProntuario,
                            queryMode:'local',
                            forceSelection:true,
                            valueField:'id',
                            displayField:'descricao',
                            name:'patologia',
                            labelWidth: 200
                        },
                        {
                            xtype: 'fieldcontainer',
                            margin: '20 0 0 0',
                            layout: {
                                align: 'stretch',
                                type: 'hbox'
                            },
                            fieldLabel: '',
                            items: [
                            {
                                xtype: 'textfield',
                                flex: 2,
                                regex:/^\d*[0-9](\.\d*[0-9])?$/,
                                name:'altura',
                                allowBlank:false,
                                fieldLabel: 'Altura(m)',
                                labelWidth: 200,
                                listeners:{
                                    scope:this,
                                    blur:function(component){
                                        if(!Ext.isEmpty(this.down('textfield[name=massa]').getValue()) && !Ext.isEmpty(component.getValue())
                                            && this.down('textfield[name=massa]').isValid() && component.isValid()
                                            ){
                                            var massa = this.down('textfield[name=massa]').getValue();
                                            var altura = component.getValue();
                                            var IMC = massa / (altura * altura);
                                            this.down('textfield[name=IMC]').setValue(IMC.toPrecision(4) + this.getIMCDescricao(IMC));
                                        }
                                    }
                                }
                            },
                            {
                                xtype: 'textfield',
                                flex: 1,
                                margins: '0 0 0 10',
                                regex:/^\d*[0-9](\.\d*[0-9])?$/,
                                name:'massa',
                                allowBlank:false,
                                fieldLabel: 'Massa(Kg)',
                                labelWidth: 60,
                                listeners:{
                                    scope:this,
                                    blur:function(component){
                                        if(!Ext.isEmpty(this.down('textfield[name=altura]').getValue()) && !Ext.isEmpty(component.getValue())
                                            && this.down('textfield[name=altura]').isValid() && component.isValid()){
                                            var altura = this.down('textfield[name=altura]').getValue();
                                            var massa = component.getValue();
                                            var IMC = massa / (altura * altura);
                                            this.down('textfield[name=IMC]').setValue(IMC.toPrecision(4) + this.getIMCDescricao(IMC));
                                        }
                                    }
                                }
                            },
                            {
                                xtype: 'textfield',
                                flex: 3,
                                margins: '0 0 0 10',
                                fieldLabel: 'IMC',
                                name:'IMC',
                                submitValue:false,
                                readOnly:true,
                                labelWidth: 30
                            }
                            ]
                        },
                        {
                            xtype: 'fieldset',
                            margin: '10 0 0 0',
                            checkboxToggle: true,
                            id:'fieldsetDiabetes',
                            collapsed: true,
                            title: 'Diabetes',
                            items: [
                            {
                                xtype: 'checkboxgroup',
                                fieldLabel: 'Presença de complicações',
                                labelWidth: 185,
                                items: [
                                {
                                    xtype: 'checkboxfield',
                                    name:'pc-renais',
                                    inputValue:'1',
                                    boxLabel: 'Renais'
                                },
                                {
                                    xtype: 'checkboxfield',
                                    name:'pc-visuais',
                                    inputValue:'2',
                                    boxLabel: 'Visuais'
                                },
                                {
                                    xtype: 'checkboxfield',
                                    name:'pc-neurologicas',
                                    inputValue:'3',
                                    boxLabel: 'Neurológicas'
                                },
                                {
                                    xtype: 'checkboxfield',
                                    name:'pc-epidermicas',
                                    inputValue:'4',
                                    boxLabel: 'Epidérmicas'
                                }
                                ]
                            },
                            {
                                xtype: 'checkboxfield',
                                anchor: '100%',
                                margin: '10 0 0 0',
                                name:'familiaDiabetes',
                                inputValue:'1',
                                fieldLabel: 'Há diabético na família',
                                labelWidth: 188,
                                boxLabel: ''
                            },
                            {
                                xtype: 'checkboxfield',
                                anchor: '100%',
                                margin: '10 0 0 0',
                                name:'insulinaDiabetes',
                                inputValue:'1',
                                fieldLabel: 'Uso de insulina',
                                labelWidth: 188,
                                boxLabel: ''
                            },
                            {
                                xtype: 'fieldcontainer',
                                margin: '10 0 0 0',
                                layout: {
                                    align: 'stretch',
                                    type: 'hbox'
                                },
                                fieldLabel: '',
                                items: [
                                {
                                    xtype: 'checkboxfield',
                                    flex: 1,
                                    name:'usomedicamentoDiabetes',
                                    inputValue:'1',
                                    fieldLabel: 'Faz uso de medicamento',
                                    labelSeparator: '?',
                                    labelWidth: 188,
                                    boxLabel: ''
                                },
                                {
                                    xtype: 'textfield',
                                    flex: 2.5,
                                    name:'usomedicamentodescricaoDiabetes',
                                    margins: '0 0 0 10',
                                    fieldLabel: 'Qual',
                                    labelSeparator: '?',
                                    labelWidth: 35
                                }
                                ]
                            }
                            ]
                        },
                        {
                            xtype: 'fieldset',
                            margin: '10 0 0 0',
                            layout: {
                                align: 'stretch',
                                type: 'hbox'
                            },
                            checkboxToggle: true,
                            collapsed: true,
                            title: 'Hipertensão',
                            id:'fieldsetHipertensao',
                            items: [
                            {
                                xtype: 'checkboxfield',
                                flex: 1,
                                fieldLabel: 'Faz uso de medicamentos',
                                name:'usomedicamentoHipertensao',
                                inputValue:'1',
                                labelSeparator: '?',
                                labelWidth: 188,
                                boxLabel: ''
                            },
                            {
                                xtype: 'textfield',
                                flex: 2.5,
                                name:'usomedicamentodescricaoHipertensao',
                                margins: '0 0 0 10',
                                fieldLabel: 'Qual',
                                labelSeparator: '?',
                                labelWidth: 35
                            }
                            ]
                        },
                        {
                            xtype: 'fieldset',
                            id:'fieldsetObesidade',
                            margin: '10 0 0 0',
                            layout: {
                                align: 'stretch',
                                type: 'hbox'
                            },
                            checkboxToggle: true,
                            collapsed: true,
                            title: 'Obesidade',
                            items: [
                            {
                                xtype: 'checkboxfield',
                                flex: 1,
                                name:'usomedicamentoObesidade',
                                inputValue:'1',
                                fieldLabel: 'Faz uso de medicamentos',
                                labelSeparator: '?',
                                labelWidth: 188,
                                boxLabel: ''
                            },
                            {
                                xtype: 'textfield',
                                name:'usomedicamentodescricaoObesidade',
                                flex: 2.5,
                                margins: '0 0 0 10',
                                fieldLabel: 'Qual',
                                labelSeparator: '?',
                                labelWidth: 35
                            }
                            ]
                        },
                        {
                            xtype: 'radiogroup',
                            margin: '20 0 0 0',
                            allowBlank:false,
                            fieldLabel: 'Perda de peso estimada',
                            labelWidth: 197,
                            items: [
                            {
                                name:'ppe',
                                inputValue:'1',
                                boxLabel: 'Não sabe informar'
                            },
                            {
                                name:'ppe',
                                inputValue:'2',
                                boxLabel: 'Sem perda de peso'
                            },
                            {
                                name:'ppe',
                                inputValue:'3',
                                boxLabel: 'Perda < 1 %'
                            },
                            {
                                name:'ppe',
                                inputValue:'4',
                                boxLabel: 'Perda moderada 5-10 %'
                            },
                            {
                                name:'ppe',
                                inputValue:'5',
                                boxLabel: 'Perda acentuada > 10 %'
                            }
                            ]
                        },
                        {
                            xtype: 'checkboxfield',
                            anchor: '100%',
                            margin: '20 0 0 0',
                            name:'fumante',
                            inputValue:'1',
                            fieldLabel: 'Fumante',
                            labelWidth: 200,
                            boxLabel: ''
                        },
                        {
                            xtype: 'checkboxfield',
                            anchor: '100%',
                            margin: '20 0 0 0',
                            name:'bebidasalcoolicas',
                            inputValue:'1',
                            fieldLabel: 'Consome Bebidas Alcoólicas',
                            labelWidth: 200,
                            boxLabel: ''
                        },
                        {
                            xtype: 'checkboxfield',
                            anchor: '100%',
                            margin: '20 0 0 0',
                            name:'protesedentaria',
                            inputValue:'1',
                            fieldLabel: 'Faz uso de prótese dentária',
                            labelWidth: 200,
                            boxLabel: ''
                        },
                        {
                            xtype: 'checkboxfield',
                            anchor: '100%',
                            margin: '20 0 0 0',
                            name:'desconfortointestinal',
                            inputValue:'1',
                            fieldLabel: 'Desconforto Intestinal',
                            labelWidth: 200,
                            boxLabel: ''
                        },
                        {
                            xtype: 'checkboxfield',
                            anchor: '100%',
                            margin: '20 0 0 0',
                            name:'cansacodesanimofrequente',
                            inputValue:'1',
                            fieldLabel: 'Cansaço/Desânimo Frequente',
                            labelWidth: 200,
                            boxLabel: ''
                        },
                        {
                            xtype: 'checkboxfield',
                            anchor: '100%',
                            margin: '20 0 0 0',
                            name:'gripealergia',
                            inputValue:'1',
                            fieldLabel: 'Gripe/Alergia',
                            labelWidth: 200,
                            boxLabel: ''
                        },
                        {
                            xtype: 'combobox',
                            anchor: '100%',
                            margin: '20 0 0 0',
                            allowBlank:false,
                            fieldLabel: 'Sintomas Gastrointestinais',
                            store:this.storeSintomaGastrointestinal,
                            queryMode:'local',
                            forceSelection:true,
                            valueField:'id',
                            displayField:'descricao',
                            name:'sintomagastrointestinal',
                            labelWidth: 200
                        },
                        {
                            xtype: 'combobox',
                            anchor: '100%',
                            margin: '20 0 0 0',
                            allowBlank:false,
                            fieldLabel: 'Diagnóstico Metabólico',
                            store:this.storeDiagnosticoMetabolico,
                            queryMode:'local',
                            forceSelection:true,
                            valueField:'id',
                            displayField:'descricao',
                            name:'diagnosticometabolico',
                            labelWidth: 200
                        },
                        {
                            xtype: 'combobox',
                            anchor: '100%',
                            margin: '20 0 0 0',
                            name:'aguadia',
                            allowBlank:false,
                            forceSelection:true,
                            valueField:'id',
                            displayField:'descricao',
                            fieldLabel: 'Quantidade de Líquido por dia',
                            labelWidth: 200,
                            store: this.storeAguaDia
                        },
                        {
                            xtype: 'combobox',
                            anchor: '100%',
                            margin: '20 0 0 0',
                            name:'avaliacaoglobal',
                            queryMode:'local',
                            allowBlank:false,
                            displayField:'descricao',
                            valueField:'id',
                            forceSelection:true,
                            store:this.storeAvaliacaoGlobal,
                            fieldLabel: 'Avaliação subjetiva global',
                            labelWidth: 200
                        },
                        {
                            xtype: 'gridpanel',
                            margin: '20 0 0 0',
                            name:'gridAlimentosAlergicos',
                            store:this.storeAlimentosAlergicos,
                            title: 'Alimentos Alérgicos',
                            listeners:{
                                itemclick:function(grid,record,item){
                                    this.down('button[name=BtnRemoverAlimentoAlergico]').enable();
                                }
                            },
                            columns: [
                            {
                                xtype: 'gridcolumn',
                                dataIndex: 'id',
                                hidden:true,
                                hideable:false
                            },
                            {
                                xtype: 'gridcolumn',
                                dataIndex: 'nome',
                                flex: 3,
                                text: 'Alimento',
                                scope:this
//                                renderer: function(val){
//                                    console.debug(val);
//                                    var index = this.storeTabelaNacional.findExact('id',val);
//                                    console.debug(index);
//                                    if (index != -1){
//                                        rs = this.storeTabelaNacional.getAt(index).data;
//                                        console.debug(rs);
//                                        return rs.descricao;
//                                    }
//                                },
//                                editor:
//                                Ext.widget({
//                                    xtype:'combobox',
//                                    scope:this,
//                                    queryMode:'local',
//                                    typeAhead: true,
//                                    triggerAction: 'all',
//                                    selectOnTab: true,
//                                    displayField: 'descricao',
//                                    name:'nome',
//                                    valueField: 'id',
//                                    store: this.storeTabelaNacional,
//                                    lazyRender: true,
//                                    allowBlank: false,
//                                    forceSelection:true,
//                                    listClass: 'x-combo-list-small'
//                                })
                            },
                            {
                                xtype: 'gridcolumn',
                                dataIndex: 'grupoalimento',
                                flex: 1,
                                text: 'Grupo Alimentar'
                            }
                            ],
                            plugins: [Ext.create('Ext.grid.plugin.RowEditing')],
                            dockedItems: [
                            {
                                xtype: 'pagingtoolbar',
                                dock: 'bottom',
                                store:this.storeAlimentosAlergicos,
                                displayInfo: true
                            },
                            {
                                xtype: 'toolbar',
                                items: [
                                {
                                    text: 'Adicionar',
                                    name:'BtnAddAlimentoAlergico',
                                    iconCls: 'silk-add',
                                    disabled: true,
                                    scope:this,
                                    handler: function(){
                                        this.storeAlimentosAlergicos.add({});
                                    }
                                }, '-', {
                                    itemId: 'delete',
                                    text: 'Remover',
                                    name:'BtnRemoverAlimentoAlergico',
                                    iconCls: 'silk-delete',
                                    disabled: true,
                                    scope:this,
                                    handler: function(){
                                        var selection = this.down('gridpanel[name=gridAlimentosAlergicos]').getView().getSelectionModel().getSelection()[0];
                                        if (selection) {
                                            this.storeAlimentosAlergicos.remove(selection);
                                        }
                                        this.down('button[name=BtnRemoverAlimentoAlergico]').disable();
                                    }
                                }]
                            }
                            ]
                        },
                        //                        {
                        //                            xtype: 'gridpanel',
                        //                            margin: '20 0 0 0',
                        //                            title: 'Dieta Alimentar',
                        //                            columns: [
                        //                            {
                        //                                xtype: 'gridcolumn',
                        //                                dataIndex: 'string',
                        //                                text: 'Tipo'
                        //                            },
                        //                            {
                        //                                xtype: 'numbercolumn',
                        //                                dataIndex: 'number',
                        //                                text: 'Number'
                        //                            },
                        //                            {
                        //                                xtype: 'datecolumn',
                        //                                dataIndex: 'date',
                        //                                text: 'Date'
                        //                            },
                        //                            {
                        //                                xtype: 'booleancolumn',
                        //                                dataIndex: 'bool',
                        //                                text: 'Boolean'
                        //                            }
                        //                            ],
                        //                            listeners: {
                        //                                itemclick: function(el, record) {
                        //                                    this.down('button[name=excluir]').enable();
                        //                                    this.down('button[name=editar]').enable();
                        //                                },
                        //                                itemdblclick: function(el, record) {
                        //                                    Ext.create('SAN.window.Cidade', {
                        //                                        cidade_id: record.data.id
                        //                                    }).show();
                        //                                },
                        //                                scope: this
                        //                            },
                        //                            dockedItems: [
                        //                            {
                        //                                xtype: 'pagingtoolbar',
                        //                                dock: 'bottom',
                        //                                store:this.storeCidade,
                        //                                displayInfo: true
                        //                            }
                        //                            ],
                        //                            viewConfig: {
                        //
                        //                        }
                        //                        },
                        {
                            xtype:'button',
                            text:'Salvar',
                            iconCls:'silk-disk',
                            margin:'20 0 0 0',
                            style:'float:right',
                            scope:this,
                            handler:function(){
                                var form = this.down('form[name=formAnamneseNutricional]').getForm();
                                var prontuario = this.getIdProntuario();
                                var paciente = this.getCpfPaciente();
                                if(form.isValid()){
                                    form.submit({
                                        scope:this,
                                        params:{
                                            id:prontuario,
                                            cpfPaciente:paciente
                                        },
                                        url:TCE.SAN.getUrlController('AnamneseNutricional','salvarAnamneseNutricional'),
                                        success:function(form,action){
                                            Ext.Msg.show({
                                                title: action.result.title,
                                                msg: action.result.msg,
                                                buttons: Ext.Msg.OK,
                                                icon: Ext.Msg.INFO
                                            });
                                            this.storeAlimentosAlergicos.sync();
                                        },
                                        failure:function(form,action){
                                            Ext.Msg.show({
                                                title: action.result.title,
                                                msg: action.result.msg,
                                                buttons: Ext.Msg.OK,
                                                icon: Ext.Msg.WARNING
                                            });
                                        }
                                    });
                                }
                            }
                        }
                        ]
                    }
                    ]
                },
                {
                    xtype: 'panel',
                    autoScroll: true,
                    title: 'Refeição'
                },
                {

                    xtype: 'panel',
                    autoScroll: true,
                    title: 'Refeição'
                }
                ]
            }
            ]
        });

        me.callParent(arguments);
    }

});