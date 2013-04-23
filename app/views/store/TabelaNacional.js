Ext.define('SAN.store.TabelaNacional', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.TabelaNacional',
    autoLoad:true,
    autoSync:false,
    fields: ['id','descricao'],
    proxy: {
        type: 'ajax',
        actionMethods: {
            create: 'POST',
            read: 'POST',
            update: 'POST',
            destroy: 'POST'
        },
        api: {
            read: TCE.SAN.getUrlController('TabelaNacional', 'getTabelaNacional'),
            update: TCE.SAN.getUrlController('TabelaNacional', 'salvarTabelaNacional'),
            create:TCE.SAN.getUrlController('TabelaNacional', 'salvarTabelaNacional'),
            destroy:TCE.SAN.getUrlController('TabelaNacional', 'excluirTabelaNacional')
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
                Ext.data.StoreManager.lookup('SAN.store.TabelaNacional').load();
            }
        }
    },
    listeners: {
        write: function(proxy, operation){
            Ext.data.StoreManager.lookup('SAN.store.TabelaNacional').load();
        }
    }
});