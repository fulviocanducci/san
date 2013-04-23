Ext.define('SAN.form.TipoDieta', {
    extend: 'SAN.form.ui.TipoDieta',
    id:'SAN.form.TipoDieta',
    requires:['SAN.store.TipoDieta','SAN.window.TipoDieta'],
    checarPermissao:false,
    constructor: function() {
        this.storeTipoDieta = Ext.create('SAN.store.TipoDieta');
        this.callParent(arguments);
    }
});