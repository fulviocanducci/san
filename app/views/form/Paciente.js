Ext.define('SAN.form.Paciente', {
    extend: 'SAN.form.ui.Paciente',
    id:'SAN.form.Paciente',
    requires:['SAN.store.Endereco','SAN.store.TelefoneTipo','SAN.store.Telefone','SAN.store.Profissao','SAN.store.Estado','SAN.store.Cidade','SAN.store.Sexo','SAN.store.EstadoCivil','SAN.store.Cor'],
    checarPermissao:false,
    constructor: function() {
        this.storeProfissoes = Ext.create('SAN.store.Profissao',{
            pageSize:1
        });
        this.storeEstado = Ext.create('SAN.store.Estado');
        this.storeCidade = Ext.create('SAN.store.Cidade');
        this.storeSexo = Ext.create('SAN.store.Sexo');
        this.storeEstadoCivil = Ext.create('SAN.store.EstadoCivil');
        this.storeCor = Ext.create('SAN.store.Cor');
        this.storeTelefoneTipo = Ext.create('SAN.store.TelefoneTipo');
        this.storeEndereco = Ext.create('SAN.store.Endereco');
        this.storeTelefone = Ext.create('SAN.store.Telefone');
        this.callParent(arguments);
    },
    listeners:{
        afterrender:function(component){
            component.desativarTodosOsCampos();
        }
    }
});