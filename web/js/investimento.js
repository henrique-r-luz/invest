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
        
        $('#modal').find("#conteudol").empty();
        $('#modal').find('#conteudo').load(this.url);
         document.getElementById('modal-titulo').innerHTML = '<h4 class="modal-title">' + this.titulo + '</h4>';
      $('#modal').modal('show') ;   
    },
}

