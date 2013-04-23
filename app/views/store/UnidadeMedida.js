Ext.define('SAN.store.UnidadeMedida', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.UnidadeMedida',
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
        url: TCE.SAN.getUrlController('UnidadeMedida', 'getUnidadesMedidas'),
        reader: {
            type: 'json',
            root: 'raiz',
            total:'totalCount'
        }
    }
});