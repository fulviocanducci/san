Ext.define('SAN.form.Sexo', {
    extend: 'SAN.form.ui.Sexo',
    id:'SAN.form.Sexo',
    requires:['SAN.store.Sexo','SAN.window.Sexo'],
    checarPermissao:false,
    constructor: function() {
        this.storeSexo = Ext.create('SAN.store.Sexo');
        this.callParent(arguments);
    }
});