Ext.define('SAN.store.TipoDieta', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.TipoDieta',
    fields: ['descricao', 'id', 'observacao'],
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
        url: TCE.SAN.getUrlController('TipoDieta', 'getTipoDietas'),
        reader: {
            type: 'json',
            root: 'raiz',
            total:'totalCount'
        }
    }
});