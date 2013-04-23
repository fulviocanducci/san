Ext.define('SAN.window.Cor', {
    extend: 'SAN.window.ui.Cor',
    id:'SAN.window.Cor',
    checarPermissao:false,
    constructor: function() {
        this.callParent(arguments);
    },
    listeners:{
        afterrender:function(){
            if(!Ext.isEmpty(this.cor_id)){
                Ext.Ajax.request({
                    scope:this,
                    url: TCE.SAN.getUrlController('Cor','getCor'),
                    params:{
                        id:this.cor_id
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