window.tipoMoeda = (function ($) {
    var pub = {
        isActive: false,
        setMoeda: function () {
            let textoSelecionando = $("#item_ativo :selected").text();
            let myarr = textoSelecionando.split("|");
            let valorText = 'Valor($ Dollar)';
            if (myarr[2].trim() == 'BR') {
                valorText = 'Valor(R$ Real)';
            }
            $("#valor").text(valorText);

        },
    };
    return pub;
})(window.jQuery);