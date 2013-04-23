Ext.define('SAN.form.GrupoAlimento', {
    extend: 'SAN.form.ui.GrupoAlimento',
    id:'SAN.form.GrupoAlimento',
    requires:['SAN.store.GrupoAlimento','SAN.window.GrupoAlimento'],
    checarPermissao:false,
    constructor: function() {
        this.storeGrupoAlimento = Ext.create('SAN.store.GrupoAlimento');
        this.callParent(arguments);
    }
});