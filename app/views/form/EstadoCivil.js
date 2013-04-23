Ext.define('SAN.form.EstadoCivil', {
    extend: 'SAN.form.ui.EstadoCivil',
    id:'SAN.form.EstadoCivil',
    requires:['SAN.store.EstadoCivil','SAN.window.EstadoCivil'],
    checarPermissao:false,
    constructor: function() {
        this.storeEstadoCivil = Ext.create('SAN.store.EstadoCivil');
        this.callParent(arguments);
    }
});