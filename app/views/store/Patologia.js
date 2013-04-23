Ext.define('SAN.store.Patologia', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.Patologia',
    fields: ['descricao', 'id','observacao'],
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
        url: TCE.SAN.getUrlController('Patologia', 'getPatologias'),
        reader: {
            type: 'json',
            root: 'raiz',
            total: 'totalCount'
        }
    }
});