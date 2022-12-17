var urlBase = '/index.php/sincronizar/sincronizar';
$("document").ready(function () {

    $("#acoes_id").click(function () {
        progressoProcesso();
    });

});

function progressoProcesso() {
    showProgressBar();
    execBot();
    loadDados(5);
}

function execBot() {
    $.ajax({
        url: urlBase + '/atualiza-acoes',
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
        url: urlBase + '/get-status-acoes',
        type: 'get',
        success: function (data) {
            if (data['total'] == 'erro') {
                $.growl.error({ message: data['msg'] });
                disposeProgressBar();

            }
            taxa = data['ativosAtualizados'] / data['total'] * 100
            if (data['total'] == 0) {
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
                window.location.href = urlBase + '/atualiza-dados';
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
    if (percentage == 0) {
        percentage = 1
    }
    atualizaBarra(percentage);
}
//desabilita o porgressBras
function disposeProgressBar() {
    $('#progress-modal').modal('hide');

}
//mostra o porgressBar
function showProgressBar() {
    var percentage = 0;
    if (percentage == 0) {
        percentage = 1
    }
    atualizaBarra(percentage);
    $('#progress-modal').modal('show');
}

function atualizaBarra(percentage) {
    if (isNaN(percentage)) {
        percentage = 1
    }
    var perc_string = 'Total de Ativos Atualizados: ' + Math.round(percentage) + '%';
    $('.progress-bar').attr('aria-valuenow', percentage);
    $('.progress-bar').css('width', percentage + '%');
    $('#pb-small').text(perc_string);
    $('#progress').text(perc_string);
}