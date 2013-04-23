Ext.define('SAN.window.TelefoneTipo', {
    extend: 'SAN.window.ui.TelefoneTipo',
    id:'SAN.window.TelefoneTipo',
    checarPermissao:false,
    constructor: function() {
        this.callParent(arguments);
    },
    listeners:{
        afterrender:function(){
            if(!Ext.isEmpty(this.telefonetipo_id)){
                Ext.Ajax.request({
                    scope:this,
                    url: TCE.SAN.getUrlController('TelefoneTipo','getTelefoneTipo'),
                    params:{
                        id:this.telefonetipo_id
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