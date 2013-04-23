Ext.define('SAN.window.ui.Cadastro', {
    extend: 'Champion.window.Base',
    bodyPadding: 10,
    title: 'Formulário de Cadastro',
    modal:true,
    border:false,
    autoScroll:true,
    height: 335,
    width: 750,
    layout: {
        type: 'fit'
    },
    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            items: [
            {
                xtype: 'fieldcontainer',
                layout: {
                    align: 'stretch',
                    type: 'hbox'
                },
                fieldLabel: '',
                items: [
                {
                    xtype: 'textfield',
                    flex: 2,
                    fieldLabel: 'Nome',
                    labelWidth: 60
                },
                {
                    xtype: 'textfield',
                    flex: 1,
                    margin: '0 0 0 10',
                    fieldLabel: 'Data de Nascimento',
                    labelWidth: 130
                }
                ]
            },
            {
                xtype: 'textfield',
                anchor: '100%',
                fieldLabel: 'Endereço',
                labelWidth: 60
            },
            {
                xtype: 'radiogroup',
                width: 200,
                fieldLabel: 'Sexo',
                labelWidth: 60,
                items: [
                {
                    xtype: 'radiofield',
                    boxLabel: 'M'
                },
                {
                    xtype: 'radiofield',
                    boxLabel: 'F'
                }
                ]
            },
            {
                xtype: 'gridpanel',
                title: 'My Grid Panel',
                columns: [
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'string',
                    text: 'String'
                },
                {
                    xtype: 'numbercolumn',
                    dataIndex: 'number',
                    text: 'Number'
                },
                {
                    xtype: 'datecolumn',
                    dataIndex: 'date',
                    text: 'Date'
                },
                {
                    xtype: 'booleancolumn',
                    dataIndex: 'bool',
                    text: 'Boolean'
                }
                ],
                viewConfig: {

            }
            }
            ]
        });

        me.callParent(arguments);
    }

});