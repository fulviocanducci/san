Ext.define('SAN.window.DiagnosticoMetabolico', {
    extend: 'SAN.window.ui.DiagnosticoMetabolico',
    id:'SAN.window.DiagnosticoMetabolico',
    checarPermissao:false,
    constructor: function() {
        this.callParent(arguments);
    },
    listeners:{
        afterrender:function(){
            if(!Ext.isEmpty(this.diagnosticometabolico_id)){
                Ext.Ajax.request({
                    scope:this,
                    url: TCE.SAN.getUrlController('DiagnosticoMetabolico','getDiagnosticoMetabolico'),
                    params:{
                        id:this.diagnosticometabolico_id
                    },
                    success:function(response){
                        var resposta = Ext.decode(response.responseText);
                        this.down('form').getForm().setValues(resposta.dados);
                    },
                    failure:function(response){
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
        }
    }
});