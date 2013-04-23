Ext.define('SAN.window.Prontuario', {
    extend: 'SAN.window.ui.Prontuario',
    id:'SAN.window.Prontuario',
    checarPermissao:false,
    requires:['SAN.store.Prontuario','SAN.form.Prontuario'],
    constructor: function() {
        this.storeProntuario = Ext.create('SAN.store.Prontuario');
        this.callParent(arguments);
    }
});