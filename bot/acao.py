import pandas as pd
from selenium import webdriver
import json
import requests
import json
#import urllib.request, json 

#código para o servidor, deve ser comentado pra teste local
'''from pyvirtualdisplay import Display
import sys
display = Display(visible=0, size=(1366, 768))
display.start()'''

filePath = '~/NetBeansProjects/investimento/invest/bot/dados/';


#url = sys.argv[1];
#browser = webdriver.Firefox(executable_path="/home/vagrant/anaconda3/bin/geckodriver",log_path="/tmp/geckodriver.log")

def getDados():
    url = "http://192.168.200.10/index.php/financas/atualiza-acao/url"
    response = json.loads(requests.get(url).text)
    executa(response)


def executa(discionarioAcoes):
    browser = webdriver.Firefox();
    listaPreco = [];
    moeda = [];
    for row in discionarioAcoes:
        
        browser.get(row['url']);
        preco = browser.find_element_by_id("last_last");
        listaPreco.append([row['ativo_id'],preco.text])
       
    browser.get('https://br.investing.com/currencies/usd-brl');
    preco = browser.find_element_by_id("last_last");
    moeda.append(['dollar',preco.text]);
    df = pd.DataFrame(listaPreco, columns =['id', 'valor'])
    dfDollar = pd.DataFrame(moeda, columns =['moeda', 'valor'])
    df.to_csv(filePath+'preco_acao.csv',index=False)
    dfDollar.to_csv(filePath+'cambio.csv',index=False)
    browser.quit()
    print(df);
    

getDados();

