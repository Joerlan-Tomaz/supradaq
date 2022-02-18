

var app = new Vue({
  el: '#app',
  data: {
    entregas: null
  },
  methods: {
    getEntregas(){
      axios.get('Entregas/getAllEntregas')
        .then(response => {
          this.entregas = response.data;
          this.refreshData();
        })
        .catch(error => {
          $.notify('Não foi possível carregar os dados!', 'error');
        });
    },
    montaTabelaEntregas(){
      $('#tableEntrega').DataTable({
        "destroy": true,
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": true,
          "scrollX": true,
          "autoWidth": true,
          "scrollCollapse": true,
          "language": {
              "emptyTable": "Nenhum registro encontrado"
          },
          "oLanguage": {
              "sLengthMenu": "Mostrar _MENU_ registros por página",
              "sZeroRecords": "Nenhum registro encontrado",
              "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
              "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
              "sInfoFiltered": "(filtrado de _MAX_ registros)",
              "sSearch": "Pesquisar: ",
              "oPaginate": {
                  "sFirst": "Início",
                  "sPrevious": "Anterior",
                  "sNext": "Próximo",
                  "sLast": "Último"
              },
          }
      });
    },
    async refreshData() {
      $("#tableEntrega").DataTable().destroy();
      try {
        await this.$nextTick(this.montaTabelaEntregas);
      } catch (err) {
        console.error(err);
      } 
    }
  },
  created() {
    this.getEntregas();
  }
  
});

function listarRodovias() {
  window.location.href = base_url + "/BRLegal/BRLegal2/Entrega/Rodovia/index";
}