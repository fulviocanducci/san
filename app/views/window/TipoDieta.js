Ext.define('SAN.window.TipoDieta', {
    extend: 'SAN.window.ui.TipoDieta',
    id:'SAN.window.TipoDieta',
    checarPermissao:false,
    constructor: function() {
        this.callParent(arguments);
    },
    listeners:{
        afterrender:function(){
            if(!Ext.isEmpty(this.tipodieta_id)){
                Ext.Ajax.request({
                    scope:this,
                    url: TCE.SAN.getUrlController('TipoDieta','getTipoDieta'),
                    params:{
                        id:this.tipodieta_id
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