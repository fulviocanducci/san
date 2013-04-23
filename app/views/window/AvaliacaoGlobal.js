Ext.define('SAN.window.AvaliacaoGlobal', {
    extend: 'SAN.window.ui.AvaliacaoGlobal',
    id:'SAN.window.AvaliacaoGlobal',
    checarPermissao:false,
    constructor: function() {
        this.callParent(arguments);
    },
    listeners:{
        afterrender:function(){
            if(!Ext.isEmpty(this.avaliacaoglobal_id)){
                Ext.Ajax.request({
                    scope:this,
                    url: TCE.SAN.getUrlController('AvaliacaoGlobal','getAvaliacaoGlobal'),
                    params:{
                        id:this.avaliacaoglobal_id
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