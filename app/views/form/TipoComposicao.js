Ext.define('SAN.form.TipoComposicao', {
    extend: 'SAN.form.ui.TipoComposicao',
    id:'SAN.form.TipoComposicao',
    requires:['SAN.store.TipoComposicao','SAN.window.TipoComposicao'],
    checarPermissao:false,
    constructor: function() {
        this.storeTipoComposicao = Ext.create('SAN.store.TipoComposicao');
        this.callParent(arguments);
    }
});