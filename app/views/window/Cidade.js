Ext.define('SAN.window.Cidade', {
    extend: 'SAN.window.ui.Cidade',
    id:'SAN.window.Cidade',
    checarPermissao:false,
    requires:['SAN.store.Estado'],
    constructor: function() {
        this.storeEstado = Ext.create('SAN.store.Estado');
        this.callParent(arguments);
    },
    listeners:{
        afterrender:function(){
            if(!Ext.isEmpty(this.cidade_id)){
                Ext.Ajax.request({
                    scope:this,
                    url: TCE.SAN.getUrlController('Cidade','getCidade'),
                    params:{
                        id:this.cidade_id
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