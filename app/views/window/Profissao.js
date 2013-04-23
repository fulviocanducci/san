Ext.define('SAN.window.Profissao', {
    extend: 'SAN.window.ui.Profissao',
    id:'SAN.window.Profissao',
    checarPermissao:false,
    constructor: function() {
        this.callParent(arguments);
    },
    listeners:{
        afterrender:function(){
            if(!Ext.isEmpty(this.profissao_id)){
                Ext.Ajax.request({
                    scope:this,
                    url: TCE.SAN.getUrlController('Profissao','getProfissao'),
                    params:{
                        id:this.profissao_id
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