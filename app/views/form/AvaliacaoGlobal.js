Ext.define('SAN.form.AvaliacaoGlobal', {
    extend: 'SAN.form.ui.AvaliacaoGlobal',
    id:'SAN.form.AvaliacaoGlobal',
    requires:['SAN.store.AvaliacaoGlobal','SAN.window.AvaliacaoGlobal'],
    checarPermissao:false,
    constructor: function() {
        this.storeAvaliacaoGlobal = Ext.create('SAN.store.AvaliacaoGlobal');
        this.callParent(arguments);
    }
});