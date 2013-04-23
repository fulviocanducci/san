Ext.define('SAN.form.SintomaGastrointestinal', {
    extend: 'SAN.form.ui.SintomaGastrointestinal',
    id:'SAN.form.SintomaGastrointestinal',
    requires:['SAN.store.SintomaGastrointestinal','SAN.window.SintomaGastrointestinal'],
    checarPermissao:false,
    constructor: function() {
        this.storeSintomaGastrointestinal = Ext.create('SAN.store.SintomaGastrointestinal');
        this.callParent(arguments);
    }
});