Ext.define('SAN.store.EstadoCivil', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.EstadoCivil',
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
        url: TCE.SAN.getUrlController('EstadoCivil', 'getEstadosCivis'),
        reader: {
            type: 'json',
            root: 'raiz',
            total: 'totalCount'
        }
    }
});