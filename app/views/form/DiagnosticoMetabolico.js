Ext.define('SAN.form.DiagnosticoMetabolico', {
    extend: 'SAN.form.ui.DiagnosticoMetabolico',
    id:'SAN.form.DiagnosticoMetabolico',
    requires:['SAN.store.DiagnosticoMetabolico','SAN.window.DiagnosticoMetabolico'],
    checarPermissao:false,
    constructor: function() {
        this.storeDiagnosticoMetabolico = Ext.create('SAN.store.DiagnosticoMetabolico');
        this.callParent(arguments);
    }
});