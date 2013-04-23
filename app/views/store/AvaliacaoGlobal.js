Ext.define('SAN.store.AvaliacaoGlobal', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.AvaliacaoGlobal',
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
        url: TCE.SAN.getUrlController('AvaliacaoGlobal', 'getAvaliacoesGlobais'),
        reader: {
            type: 'json',
            root: 'raiz',
            total:'totalCount'
        }
    }
});