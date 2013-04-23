Ext.define('SAN.form.Estado', {
    extend: 'SAN.form.ui.Estado',
    id:'SAN.form.Estado',
    requires:['SAN.store.Estado','SAN.window.Estado'],
    checarPermissao:false,
    constructor: function() {
        this.storeEstado = Ext.create('SAN.store.Estado');
        this.callParent(arguments);
    }
});