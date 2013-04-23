Ext.define('SAN.form.Patologia', {
    extend: 'SAN.form.ui.Patologia',
    id:'SAN.form.Patologia',
    requires:['SAN.store.Patologia','SAN.window.Patologia'],
    checarPermissao:false,
    constructor: function() {
        this.storePatologia = Ext.create('SAN.store.Patologia');
        this.callParent(arguments);
    }
});