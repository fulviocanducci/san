Ext.define('SAN.form.Cidade', {
    extend: 'SAN.form.ui.Cidade',
    id:'SAN.form.Cidade',
    requires:['SAN.store.Cidade','SAN.window.Cidade'],
    checarPermissao:false,
    constructor: function() {
        this.storeCidade = Ext.create('SAN.store.Cidade');
        this.callParent(arguments);
    },
    listeners:{
        afterrender:function(){
            this.storeCidade.load();
        }
    }
});