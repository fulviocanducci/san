Ext.define('SAN.form.UnidadeMedida', {
    extend: 'SAN.form.ui.UnidadeMedida',
    id:'SAN.form.UnidadeMedida',
    requires:['SAN.store.UnidadeMedida','SAN.window.UnidadeMedida'],
    checarPermissao:false,
    constructor: function() {
        this.storeUnidadeMedida = Ext.create('SAN.store.UnidadeMedida');
        this.callParent(arguments);
    }
});