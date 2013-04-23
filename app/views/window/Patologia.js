Ext.define('SAN.window.Patologia', {
    extend: 'SAN.window.ui.Patologia',
    id:'SAN.window.Patologia',
    checarPermissao:false,
    constructor: function() {
        this.callParent(arguments);
    },
    listeners:{
        afterrender:function(){
            if(!Ext.isEmpty(this.patologia_id)){
                Ext.Ajax.request({
                    scope:this,
                    url: TCE.SAN.getUrlController('Patologia','getPatologia'),
                    params:{
                        id:this.patologia_id
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