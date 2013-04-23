Ext.define('SAN.form.TelefoneTipo', {
    extend: 'SAN.form.ui.TelefoneTipo',
    id:'SAN.form.TelefoneTipo',
    requires:['SAN.store.TelefoneTipo','SAN.window.TelefoneTipo'],
    checarPermissao:false,
    constructor: function() {
        this.storeTelefoneTipo = Ext.create('SAN.store.TelefoneTipo');
        this.callParent(arguments);
    }
});