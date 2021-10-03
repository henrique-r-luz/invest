//robo de acesso ao site da easynvest
var system = require('system');

//var login = system.args[1];
//var senha = system.args[2];
var page = require('webpage').create();
        //acessa o site 
        server = 'https://www.easynvest.com.br/api/auth/v2/security/token';
        //define os parâmetros de autenticação
        //data = 'AssinaturaEletronica='+senha+'&Conta='+login+'&PrimeiroAcesso=false';
        data = 'username=5224629&password=@Luz067315';
        
       /* page.onResourceError = function(resourceError) {
            page.reason = resourceError.errorString;
            page.reason_url = resourceError.url;
        };*/        
        
//realiza a requisição post
page.open(server, 'post', data, function (status) {
    if (status !== 'success') {
        console.log('Unable to post! ');
        phantom.exit();    
    } else {  
         return 'acessou';
         phantom.exit();
    	//após a requisição acessa o site de custodia 
        /*page.open('https://portal.easynvest.com.br/financas/custodia/', function (status) { 
            if (status === "success") {
            	// define um time out para dar tempo da pagina carregar
                setTimeout(function () {
                	//inporta a biblioteca java script
                    page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js", function () {
                        //obtém os titulos de renda fixa
                        console.log(page.evaluate(function () {
                            var text = ']@[';
                            $("#div_rendafixa > table > tbody > tr").each(function() {
                                   text=text+'!@'//caracter que define os diferentes títulos;
                                   $(this).find('td').each(function(){
                                       text=text+$(this).html()+'#&'//caracter  que define o atributo de cada título;
                                })
                            });
                             text = text+ ']@[';
                             $("#div_fundosdeinvestimento > table > tbody > tr").each(function() {
                                   text=text+'!@'//caracter que define os diferentes títulos;
                                   $(this).find('td').each(function(){
                                       text=text+$(this).html()+'#&'//caracter  que define o atributo de cada título;
                                })
                            });
                            //acessa a página de nota de negociação;
                            //recupera a data de compra;
                            //acessa a página de extrato;
                            //recupera o valor de compra
                            return text;
                           
                        }));
                     phantom.exit();    
                    });
                   
                }, 10);
            } else {
                console.log('erro ao abrir custódia')
                phantom.exit();    
            }
        });*/
    }

});


