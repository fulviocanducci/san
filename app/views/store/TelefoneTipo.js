Ext.define('SAN.store.TelefoneTipo', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.TelefoneTipo',
    fields: ['descricao', 'tipotelefone'],
    autoLoad:true,
    proxy: {
        type: 'ajax',
        actionMethods: {
            create: 'POST',
            read: 'POST',
            update: 'POST',
            destroy: 'POST'
        },
        url: TCE.SAN.getUrlController('TelefoneTipo', 'getTelefonesTipo'),
        reader: {
            type: 'json',
            root: 'raiz'
        }
    }
});