$("document").ready(function () {

    $("#acoes_id").click(function () {
        //alert('olaa');
        progressoProcesso();
    });

});

function progressoProcesso() {
    execBot();
    loadDados(5);
    //loadDados();
    showProgressBar();

    //disposeProgressBar();
}

function execBot() {
    $.ajax({
        url: '/index.php/financas/sincronizar/atualiza-acoes',
        type: 'get',
        success: function (data) {

        },
        error: function () {
            console.log('Server error, please try again later');
            return false;
        }
    });
}

function loadDados(porcentagem) {
    $.ajax({
        url: '/index.php/financas/sincronizar/get-status-acoes',
        type: 'get',
        success: function (data) {
            console.log(data)
            if(data['total'] =='erro'){
                $.growl.error({ message:"Erro ao atualizar ativos"});
                disposeProgressBar();

            }
            taxa = data['ativosAtualizados'] / data['total'] * 100
            if (data['total'] == 0 ) {
                setTimeout(function () {
                    porcentagem = taxa;
                    atualizaTaxa(porcentagem);

                }, 500);
            }
            if (taxa < 100) {
                setTimeout(function () {
                    porcentagem = taxa;
                    atualizaTaxa(porcentagem);

                }, 500);
            }
            if (data['total'] > 0 && taxa >= 100) {
                disposeProgressBar();
                window.location.href = '/index.php/financas/sincronizar/atualiza-dados';
                return;
            }
        },
        error: function () {
            console.log('Server error, please try again later');
            return false;
        }
    });
}

function atualizaTaxa(porcentagem) {
    loadDados(porcentagem);
    updateProgressBar(porcentagem);
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
function disposeProgressBar() {
    $('#progress-modal').modal('hide');

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