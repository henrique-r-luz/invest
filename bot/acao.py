import pandas as pd
from selenium import webdriver
import json
import requests
import json
from selenium.common.exceptions import NoSuchElementException
import sys
import os
import os.path
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By


# filePath = '~/NetBeansProjects/dados/';
logPath = "/var/www/dados/atualiza_acao.txt"
dir = "/var/www/dados"
webServer = 'apache'

def getDados():

        if (os.path.exists(logPath)):
            os.remove(logPath);
        url = "http://"+webServer+"/index.php/financas/atualiza-acao/url";
        response = json.loads(requests.get(url).text);
        executa(response);
        print(1);
        # return 'Deu certo';

def executa(discionarioAcoes):
    listaPreco = [];
    moeda = [];
    id = 0;
    for row in discionarioAcoes:
        browser.get(row['url']);
        preco = getPreco(browser);
        with open(logPath, 'a') as log:
             log.write('ativo@#:'+str(preco.text)+';');
        listaPreco.append([row['ativo_id'], preco.text])
        id+=1
       
    browser.get('https://br.investing.com/currencies/usd-brl');
    preco = getPreco(browser);
    with open(logPath, 'a') as log:
            log.write('ativo@#:'+str(preco.text)+';')
   
    moeda.append(['dollar', preco.text]);
  
    df = pd.DataFrame(listaPreco, columns=['id', 'valor'])
    dfDollar = pd.DataFrame(moeda, columns=['moeda', 'valor'])
    df.to_csv(dir + '/preco_acao.csv', index=False)
    dfDollar.to_csv(dir + '/cambio.csv', index=False)
    browser.quit()
    
def getPreco(browser):
    preco = getPrecoId(browser);
    if(preco!=False):
        return preco;
    preco = getPrecoClass(browser);
    if(preco!=False):
        return preco;
    preco = getPrecoAttribute(browser);
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
        

def getPrecoAttribute(browser):

    try:
        return browser.find_element(By.CSS_SELECTOR,'[data-test=instrument-price-last]')
    except NoSuchElementException:
        return False;

try:
    options = Options()
    options.page_load_strategy = 'eager'
    browser = webdriver.Remote(command_executor='invest_bot:4444',options=options);
    getDados();
except BaseException as err:
    with open(logPath, 'a') as log:
            log.write('erro@#:'+str(format(err))+';')
    print('Erro', format(err));
    browser.quit();

