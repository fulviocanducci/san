Ext.define('SAN.window.SintomaGastrointestinal', {
    extend: 'SAN.window.ui.SintomaGastrointestinal',
    id:'SAN.window.SintomaGastrointestinal',
    checarPermissao:false,
    constructor: function() {
        this.callParent(arguments);
    },
    listeners:{
        afterrender:function(){
            if(!Ext.isEmpty(this.sintomagastrointestinal_id)){
                Ext.Ajax.request({
                    scope:this,
                    url: TCE.SAN.getUrlController('SintomaGastrointestinal','getSintomaGastrointestinal'),
                    params:{
                        id:this.sintomagastrointestinal_id
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