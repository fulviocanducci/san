Ext.define('SAN.window.UnidadeMedida', {
    extend: 'SAN.window.ui.UnidadeMedida',
    id:'SAN.window.UnidadeMedida',
    checarPermissao:false,
    constructor: function() {
        this.callParent(arguments);
    },
    listeners:{
        afterrender:function(){
            if(!Ext.isEmpty(this.unidademedida_id)){
                Ext.Ajax.request({
                    scope:this,
                    url: TCE.SAN.getUrlController('UnidadeMedida','getUnidadeMedida'),
                    params:{
                        id:this.unidademedida_id
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