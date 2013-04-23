Ext.define('SAN.store.Prontuario', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.Prontuario',
    fields: ['dtcadastro', 'id'],
    pageSize:5,
    proxy: {
        type: 'ajax',
        actionMethods: {
            create: 'POST',
            read: 'POST',
            update: 'POST',
            destroy: 'POST'
        },
        url: TCE.SAN.getUrlController('Prontuario', 'getProntuarios'),
        reader: {
            type: 'json',
            root: 'raiz',
            total:'totalCount'
        }
    }
});