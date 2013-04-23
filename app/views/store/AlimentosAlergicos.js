Ext.define('SAN.store.AlimentosAlergicos', {
    extend: 'Champion.store.Base',
    storeId: 'SAN.store.AlimentosAlergicos',
    autoLoad:false,
    autoSync:false,
    pageSize:5,
    fields: ['id','nome','grupoalimento'],
    proxy: {
        type: 'ajax',
        actionMethods: {
            create: 'POST',
            read: 'POST',
            update: 'POST',
            destroy: 'POST'
        },
        api: {
            read: TCE.SAN.getUrlController('AlimentosAlergicos', 'getAlimentosAlergicos'),
            update: TCE.SAN.getUrlController('AlimentosAlergicos', 'salvarAlimentosAlergicos'),
            create:TCE.SAN.getUrlController('AlimentosAlergicos', 'salvarAlimentosAlergicos'),
            destroy:TCE.SAN.getUrlController('AlimentosAlergicos', 'excluirAlimentosAlergicos')
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
                Ext.data.StoreManager.lookup('SAN.store.AlimentosAlergicos').load();
            }
        }
    },
    listeners: {
        write: function(proxy, operation){
            Ext.data.StoreManager.lookup('SAN.store.AlimentosAlergicos').load();
        }
    }
});