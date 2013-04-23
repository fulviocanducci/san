Ext.define('SAN.store.Profissao', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.Profissao',
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
        url: TCE.SAN.getUrlController('Profissao', 'getProfissoes'),
        reader: {
            type: 'json',
            total: 'totalCount',
            root: 'raiz'
        }
    }
});