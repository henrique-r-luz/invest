/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var invest = {
    load: function(objJon){
       
    }
}


var modal = {
    titulo:null,
    url:null,
    
    init: function(param,url){
      console.log(param)
      this.titulo = param['titulo'];
      this.url = param['url'];
      this.setDados();
    },
    
    setDados:function(){
        
          // Limpa modal e mostra load.
          /*
            $('#modal').find("#conteudoModal").empty();
            $('#modal').find('#conteudoModal').html("<div style='text-align:center'><span class='fas fa-2x fa-sync-alt fa-spin'></span></div>");

            //Verifica se modal já esta aparente ou escondido para carregar o conteúdo.
            if ($("element").data('bs.modal') && $('#modal').data('bs.modal').isShown) {
                $('#modal').find('#conteudoModal').load($(this).attr('value'));
            } else {
                $('#modal').modal('show').find('#conteudoModal').load($(this).attr('value'));
            }

            //Define o titulo do modal dinamicamente
            document.getElementById('modal-title').innerHTML = '<h4 class="modal-title">' + $(this).attr('titulo-modal') + '</h4>';
        */
        $('#modal').find("#conteudol").empty();
        $('#modal').find('#conteudo').load(this.url);
         document.getElementById('modal-titulo').innerHTML = '<h4 class="modal-title">' + this.titulo + '</h4>';
      $('#modal').modal('show') ;   
    },
}

