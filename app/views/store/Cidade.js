Ext.define('SAN.store.Cidade', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.Cidade',
    fields: [ 'descricao', 'id', 'idestado', 'estadodescricao'],
    autoLoad:false,
    proxy: {
        type: 'ajax',
        actionMethods: {
            create: 'POST',
            read: 'POST',
            update: 'POST',
            destroy: 'POST'
        },
        url: TCE.SAN.getUrlController('Cidade', 'getCidades'),
        reader: {
            type: 'json',
            root: 'raiz'
        }
    }
});