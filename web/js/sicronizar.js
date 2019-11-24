/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//console.log('Hello, world!');
//phantom.exit();




//fazer requisição em lote para as mastriculas
function batchSend(links, iter, take, processed) {
    var set = links.length
    var group = iter + take < set ? iter + take : set;
    var progress = Math.round((group / set) * 100);
    var linksObj = [];
    
    for (var i = iter; i < group; i++) {
        linksObj.push(links[i]);
    }
    
    
    iter += take;
    $.ajax({
        url: '/index.php/sicronizar/inserir-acoes', ///?r=country/process
        type: 'post',
        data: {'acoes':  JSON.stringify(linksObj)},
        success: function (data) {
            if (data.result) {
                updateProgressBar(progress);
                 processed += data.processed;
                if (progress < 100) {
                    
                    batchSend(links, iter, take, processed);
                } else {
                    disposeProgressBar(progress + '% de todas as solicitações foram analisadas, no entanto esse processo não garante que todas as matrículas foram feitas. ');
                }
                return true;
            }
            console.log('ok '+processed);
            disposeProgressBar(data.error);
            return false;
        },
        error: function () {
            disposeProgressBar('Server error, please try again later');
            return false;
        }
    });
}


//atualiza o porgressBar
function updateProgressBar(percentage) {
    var perc_string = percentage + '%  dos registros analisados';
    $('.progress-bar').attr('aria-valuenow', percentage);
    $('.progress-bar').css('width', percentage + '%');
    $('#pb-small').text(perc_string);
    $('#progress').text(perc_string);
}
//desabilita o porgressBras
function disposeProgressBar(message) {
    //alert(message);
     $('#progress-modal').modal('hide');
    //$('#form-resultado-matricula').yiiActiveForm('submitForm');
   // getDadosForm();

}
//mostra o porgressBar
function showProgressBar() {
    var perc = 0;
    var perc_string = perc + '% dos registros analisados';
    $('.progress-bar').attr('aria-valuenow', perc);
    $('.progress-bar').css('width', perc + '%');
    $('#pb-small').text(perc_string);
    $('#progress').text(perc_string);
    $('#progress-modal').modal('show');
}

