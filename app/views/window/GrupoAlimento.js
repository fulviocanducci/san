Ext.define('SAN.window.GrupoAlimento', {
    extend: 'SAN.window.ui.GrupoAlimento',
    id:'SAN.window.GrupoAlimento',
    checarPermissao:false,
    constructor: function() {
        this.callParent(arguments);
    },
    listeners:{
        afterrender:function(){
            if(!Ext.isEmpty(this.grupoalimento_id)){
                Ext.Ajax.request({
                    scope:this,
                    url: TCE.SAN.getUrlController('GrupoAlimento','getGrupoAlimento'),
                    params:{
                        id:this.grupoalimento_id
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