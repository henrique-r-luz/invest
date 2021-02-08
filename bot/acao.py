import pandas as pd
from selenium import webdriver

#código para o servidor, deve ser comentado pra teste local
'''from pyvirtualdisplay import Display
import sys
display = Display(visible=0, size=(1366, 768))
display.start()'''

filePath = '~/NetBeansProjects/investimento/invest/bot/dados/';


discionarioAcoes = [
    [14 , "https://br.investing.com/equities/banco-inter-sa"], # inter
    [16 , "https://br.investing.com/equities/itausa-on-ej-n1"], # itausa on
    [21 , "https://br.investing.com/equities/weg-on-ej-nm"], # weg on
    [20 , "https://br.investing.com/equities/fleury-on-nm"], # fleury on
    [17 , "https://br.investing.com/equities/ambev-pn"], # ambev
    [18 , "https://br.investing.com/equities/bmfbovespa-on-nm"], # b3
    [19 , "https://br.investing.com/equities/tractebel-on-nm"], # engie
    [23 , "https://br.investing.com/equities/grendene-on-nm"], # grendene
    [24 , "https://br.investing.com/equities/m.diasbranco-on-ej-nm"], # m. dias branco
    [25 , "https://br.investing.com/equities/odontoprev-on-ej-nm"], # odonto prev
    
    [31 , "https://br.investing.com/equities/visa-inc"], # visa
    [29,"https://br.investing.com/equities/amazon-com-inc"], #amazon
    [30,"https://br.investing.com/equities/google-inc"], # google
    [32,"https://br.investing.com/equities/microsoft-corp"],#macosoft
    [34,"https://br.investing.com/equities/accenture-ltd"],#accenture
    [35,"https://br.investing.com/equities/novo-nordis"],#novo nordisk
    ['dollar','https://br.investing.com/currencies/usd-brl'],
];



#url = sys.argv[1];
#browser = webdriver.Firefox(executable_path="/home/vagrant/anaconda3/bin/geckodriver",log_path="/tmp/geckodriver.log")


browser = webdriver.Firefox();
listaPreco = [];
moeda = [];
for row in discionarioAcoes:
    
    if row[0]=='dollar':
        browser.get(row[1]);
        preco = browser.find_element_by_id("last_last");
        moeda.append([row[0],preco.text])
    else:
        browser.get(row[1]);
        preco = browser.find_element_by_id("last_last");
        listaPreco.append([row[0],preco.text])

#print(listaPreco);
df = pd.DataFrame(listaPreco, columns =['id', 'valor'])
dfDollar = pd.DataFrame(moeda, columns =['moeda', 'valor'])
df.to_csv(filePath+'preco_acao.csv',index=False)
dfDollar.to_csv(filePath+'cambio.csv',index=False)
browser.quit()
print(df);

