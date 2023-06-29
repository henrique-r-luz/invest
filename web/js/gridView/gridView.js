window.grid = (function ($) {
    var pub = {
        // isActive indica que o modulo ativo. 
        // Se for falso, o método init() não será chamado para este módulo e seus modulos filhos.
        isActive: false,
        delete: function (url) {
            yii.confirm('Deseja apagar o Registro?',
                function () {
                    $.ajax({
                        url: url,
                        method: "POST",

                    })
                        .done(function (resp) {
                            $.pjax.reload({ container: '#grid_pjax', async: false });
                            if (resp.resp == true) {
                                setTimeout(function () { $.notify({ "message": "Registro removido com sucesso! ", "icon": "fa fa-check-circle", "title": "<b>Sucesso</b>", "url": "", "target": "_blank" }, notify_hash_Grow_invest_sucesso); }, 1);
                            } else {
                                setTimeout(function () { $.notify({ "message": resp.msg, "title": "<b>Erro</b>", "icon": "fa fa-times-circle", "url": "", "target": "_blank" }, notify_hash_Grow_invest); }, 1);

                            }
                        })
                        .fail(function (jqXHR, textStatus) {
                            alert("Request failed: " + textStatus);
                        });
                }
            );

        },
    };
    return pub;
})(window.jQuery);