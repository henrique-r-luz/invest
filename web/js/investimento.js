/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var invest = {
    load: function(objJon){

    }
}

var investidorFiltro = {

    reloadUrl: null,

    init: function(reloadUrl){
        this.reloadUrl = reloadUrl;
        this.moverParaNavbar();
        this.bindChange();
    },

    moverParaNavbar: function(){
        var $item = $('#investidor-nav-item').detach();
        var $navLeft = $('.main-header .navbar-nav').not('.ml-auto').first();
        $navLeft.css('flex', '1 1 auto');
        $item.show().appendTo($navLeft);
    },

    bindChange: function(){
        var self = this;
        $('#investidor-id-select').on('change', function() {
            var investidorId = $(this).val();
            var url = self.reloadUrl;
            if (investidorId) {
                url += '?investidor_id=' + encodeURIComponent(investidorId);
            }
            window.location.href = url;
        });
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

