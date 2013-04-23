Ext.define('SAN.store.Telefone', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.Telefone',
    autoLoad:false,
    autoSync:false,
    pageSize:4,
    fields: ['id','numero','tipotelefone'],
    proxy: {
        type: 'ajax',
        actionMethods: {
            create: 'POST',
            read: 'POST',
            update: 'POST',
            destroy: 'POST'
        },
        api: {
            read: TCE.SAN.getUrlController('Telefone', 'getTelefones'),
            update: TCE.SAN.getUrlController('Telefone', 'salvarTelefones'),
            create:TCE.SAN.getUrlController('Telefone', 'salvarTelefones'),
            destroy:TCE.SAN.getUrlController('Telefone', 'excluirTelefones')
        },
        writer: {
            type: 'json',
            root: 'raiz',
            allowSingle: false
        },
        reader: {
            type: 'json',
            root: 'raiz',
            allowSingle: false
        },
        listeners: {
            exception: function(proxy, response, operation){
                Ext.Msg.show({
                    closable: false,
                    modal: true,
                    title: 'Falha',
                    msg: 'Requisição falhou.',
                    buttons: Ext.Msg.OK,
                    icon: Ext.Msg.INFO
                });
                Ext.data.StoreManager.lookup('SAN.store.Telefone').load();
            }
        }
    },
    listeners: {
        write: function(proxy, operation){
            Ext.data.StoreManager.lookup('SAN.store.Telefone').load();
        }
    }
});