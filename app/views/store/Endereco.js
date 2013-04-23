Ext.define('SAN.store.Endereco', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.Endereco',
    autoLoad:false,
    autoSync:false,
    pageSize:4,
    fields: ['id','logradouro','numero','cep','complemento','referencia','cidade'],
    proxy: {
        type: 'ajax',
        actionMethods: {
            create: 'POST',
            read: 'POST',
            update: 'POST',
            destroy: 'POST'
        },
        api: {
            read: TCE.SAN.getUrlController('Endereco', 'getEnderecos'),
            update: TCE.SAN.getUrlController('Endereco', 'salvarEnderecos'),
            create:TCE.SAN.getUrlController('Endereco', 'salvarEnderecos'),
            destroy:TCE.SAN.getUrlController('Endereco', 'excluirEnderecos')
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
                Ext.data.StoreManager.lookup('SAN.store.Endereco').load();
            }
        }
    },
    listeners: {
        write: function(proxy, operation){
            Ext.data.StoreManager.lookup('SAN.store.Endereco').load();
        }
    }
});