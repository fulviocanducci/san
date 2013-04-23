Ext.define('SAN.store.Cor', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.Cor',
    fields: ['descricao', 'id'],
    pageSize:15,
    autoLoad:true,
    proxy: {
        type: 'ajax',
        actionMethods: {
            create: 'POST',
            read: 'POST',
            update: 'POST',
            destroy: 'POST'
        },
        url: TCE.SAN.getUrlController('Cor', 'getCores'),
        reader: {
            type: 'json',
            root: 'raiz',
            total: 'totalCount'
        }
    }
});