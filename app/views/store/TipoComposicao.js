Ext.define('SAN.store.TipoComposicao', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.TipoComposicao',
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
        url: TCE.SAN.getUrlController('TipoComposicao', 'getTiposComposicoes'),
        reader: {
            type: 'json',
            root: 'raiz',
            total:'totalCount'
        }
    }
});