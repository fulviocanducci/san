Ext.define('SAN.window.Sexo', {
    extend: 'SAN.window.ui.Sexo',
    id:'SAN.window.Sexo',
    checarPermissao:false,
    constructor: function() {
        this.callParent(arguments);
    },
    listeners:{
        afterrender:function(){
            if(!Ext.isEmpty(this.sexo_id)){
                Ext.Ajax.request({
                    scope:this,
                    url: TCE.SAN.getUrlController('Sexo','getSexo'),
                    params:{
                        id:this.sexo_id
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