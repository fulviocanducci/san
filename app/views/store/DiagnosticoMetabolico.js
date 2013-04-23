Ext.define('SAN.store.DiagnosticoMetabolico', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.DiagnosticoMetabolico',
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
        url: TCE.SAN.getUrlController('DiagnosticoMetabolico', 'getDiagnosticosMetabolicos'),
        reader: {
            type: 'json',
            root: 'raiz',
            total:'totalCount'
        }
    }
});