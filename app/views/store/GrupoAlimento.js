Ext.define('SAN.store.GrupoAlimento', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.GrupoAlimento',
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
        url: TCE.SAN.getUrlController('GrupoAlimento', 'getGrupoAlimentos'),
        reader: {
            type: 'json',
            root: 'raiz',
            total:'totalCount'
        }
    }
});