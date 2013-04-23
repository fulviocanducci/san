Ext.define('SAN.store.Estado', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.Estado',
    fields: ['descricao', 'id'],
    autoLoad:true,
    proxy: {
        type: 'ajax',
        actionMethods: {
            create: 'POST',
            read: 'POST',
            update: 'POST',
            destroy: 'POST'
        },
        url: TCE.SAN.getUrlController('Estado', 'getEstados'),
        reader: {
            type: 'json',
            root: 'raiz'
        }
    }
});