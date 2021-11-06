import pandas as pd
from selenium import webdriver
import json
import requests
import json
from selenium.common.exceptions import NoSuchElementException
import sys
import os
import os.path


filePath = '~/NetBeansProjects/dados/';


def getDados():
        if (os.path.exists("/tmp/atualiza_acao.log")):
            os.remove("/tmp/atualiza_acao.log");
        url = "http://localhost/index.php/financas/atualiza-acao/url";
        response = json.loads(requests.get(url).text);
        executa(response);
        print('true');
        return 'true';

def executa(discionarioAcoes):
    listaPreco = [];
    moeda = [];
    id = 0;
    for row in discionarioAcoes:
        #if(id==2):
            #break;
        browser.get(row['url']);
        preco = getPreco(browser);
        #print(str(row['ativo_id']) + ' - ' + str(preco.text));
        with open('/tmp/atualiza_acao.log', 'a') as log:
            log.write(str(row['ativo_id'])+' - '+str(preco.text)+';');
        listaPreco.append([row['ativo_id'], preco.text])
        id+=1
       
    browser.get('https://br.investing.com/currencies/usd-brl');
    preco = getPreco(browser);
   
        
    moeda.append(['dollar', preco.text]);
  
    df = pd.DataFrame(listaPreco, columns=['id', 'valor'])
    dfDollar = pd.DataFrame(moeda, columns=['moeda', 'valor'])
    #df.to_csv(filePath + 'preco_acao.csv', index=False)
    #dfDollar.to_csv(filePath + 'cambio.csv', index=False)
    browser.quit()
    #print(df);
    
 
def getPreco(browser):
    preco = getPrecoId(browser);
    if(preco!=False):
        return preco;
    preco = getPrecoClass(browser);
    if(preco!=False):
        return preco;
    
    
    
def getPrecoId(browser):
    try:
        return browser.find_element_by_id('last_last');
    except NoSuchElementException:
        return False;
    


def getPrecoClass(browser):
    try:
        return browser.find_element_by_class_name('instrument-price_last__KQzyA')
    except NoSuchElementException:
        return False;

try:
    browser = webdriver.Remote(command_executor='invest_bot:4444');
    getDados();
except BaseException as err:
    print('Erro', format(err));
    browser.quit();

