Ext.define('SAN.form.Profissao', {
    extend: 'SAN.form.ui.Profissao',
    id:'SAN.form.Profissao',
    requires:['SAN.store.Profissao','SAN.window.Profissao'],
    checarPermissao:false,
    constructor: function() {
        this.storeProfissao = Ext.create('SAN.store.Profissao');
        this.callParent(arguments);
    }
});