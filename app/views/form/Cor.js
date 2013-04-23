Ext.define('SAN.form.Cor', {
    extend: 'SAN.form.ui.Cor',
    id:'SAN.form.Cor',
    requires:['SAN.store.Cor','SAN.window.Cor'],
    checarPermissao:false,
    constructor: function() {
        this.storeCor = Ext.create('SAN.store.Cor');
        this.callParent(arguments);
    }
});