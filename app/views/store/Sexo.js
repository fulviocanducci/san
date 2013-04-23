Ext.define('SAN.store.Sexo', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.Sexo',
    fields: ['descricao', 'id'],
    autoLoad:true,
    pageSize:15,
    proxy: {
        type: 'ajax',
        actionMethods: {
            create: 'POST',
            read: 'POST',
            update: 'POST',
            destroy: 'POST'
        },
        url: TCE.SAN.getUrlController('Sexo', 'getSexos'),
        reader: {
            type: 'json',
            root: 'raiz',
            total: 'totalCount'
        }
    }
});