Ext.define('SAN.form.Prontuario', {
    extend: 'SAN.form.ui.Prontuario',
    id:'SAN.form.Prontuario',
    requires:['SAN.store.TabelaNacional','SAN.store.Patologia','SAN.store.AlimentosAlergicos','SAN.store.AvaliacaoGlobal','SAN.store.SintomaGastrointestinal','SAN.store.DiagnosticoMetabolico'],
    checarPermissao:false,
    constructor: function() {
        this.storeProntuario = Ext.create('SAN.store.Patologia');
        this.storeAvaliacaoGlobal = Ext.create('SAN.store.AvaliacaoGlobal');
        this.storeDiagnosticoMetabolico = Ext.create('SAN.store.DiagnosticoMetabolico');
        this.storeSintomaGastrointestinal = Ext.create('SAN.store.SintomaGastrointestinal');
        this.storeAlimentosAlergicos = Ext.create('SAN.store.AlimentosAlergicos');
        this.storeTabelaNacional = Ext.create('SAN.store.TabelaNacional');
        this.storeAguaDia = new Ext.data.ArrayStore({
                                autoLoad:true,
                                fields: ['id', 'descricao'],
                                data: [
                                [1, 'Menos de 1 litro'],
                                [2, 'Até 1,5 litros'],
                                [3, 'Até 2 litros'],
                                [4, 'Até 3 litros'],
                                [5, 'Mais de 3 litros']
                                ]
                            });
        this.callParent(arguments);
    },
    listeners:{
        afterrender:function(component){
            this.down('hiddenfield[name=cpfpaciente]').setValue(this.cpfpaciente);
            if(!Ext.isEmpty(this.idprontuario)){
                this.down('hiddenfield[name=idprontuario]').setValue(this.idprontuario);
                Ext.Ajax.request({
                    params:{
                        id:this.idprontuario
                    },
                    url:TCE.SAN.getUrlController('Prontuario','getProntuario'),
                    scope:this,
                    success:function(response){
                        var resposta = Ext.decode(response.responseText);
                        if(resposta.success){
                            this.down('form[name=formAnamneseNutricional]').getForm().setValues(resposta.dados);
                            this.storeAlimentosAlergicos.getProxy().extraParams.idprontuario = this.idprontuario;
                            this.storeAlimentosAlergicos.load();
                        } else {
                            Ext.Msg.show({
                                title: resposta.title,
                                msg: resposta.msg,
                                buttons: Ext.Msg.OK,
                                icon: Ext.Msg.INFO
                            });
                        }
                    },
                    failure:function(response){
                        Ext.Msg.show({
                            title: 'Falha',
                            msg: 'Requisição falhou.',
                            buttons: Ext.Msg.OK,
                            icon: Ext.Msg.WARNING
                        });
                    }
                });
            }
        }
    }
});