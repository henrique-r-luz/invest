window.tipoMoeda = (function ($) {
    var pub = {
        isActive: false,
        setMoeda: function () {
            let textoSelecionando = $("#item_ativo :selected").text();
            let myarr = textoSelecionando.split("|");
            console.log(myarr);
            let valorText = 'Valor(R$ Real)';
            if (myarr[2].trim() === 'US') {
                valorText = 'Valor($ Dollar)';
            }
            $("#valor").text(valorText);

        },
    };
    return pub;
})(window.jQuery);