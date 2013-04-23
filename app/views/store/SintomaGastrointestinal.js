Ext.define('SAN.store.SintomaGastrointestinal', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.SintomaGastrointestinal',
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
        url: TCE.SAN.getUrlController('SintomaGastrointestinal', 'getSintomasGastrointestinais'),
        reader: {
            type: 'json',
            root: 'raiz',
            total:'totalCount'
        }
    }
});