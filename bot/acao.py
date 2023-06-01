import json
import os
import os.path
import sys

import pandas as pd
import requests
from selenium import webdriver
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By

# filePath = '~/NetBeansProjects/dados/';
logPath = "/var/www/dados/atualiza_acao.txt"
dir = "/var/www/dados"
webServer = 'apache'


def getDados():

    if (os.path.exists(logPath)):
        os.remove(logPath)
    url = "http://"+webServer+"/index.php/sincronizar/site-acoes/url"

    response = json.loads(requests.get(url).text)
    executa(response)
    print(1)
    # return 'Deu certo';


def executa(discionarioAcoes):
    try:
        listaPreco = []
        id = 0
        for row in discionarioAcoes:
            browser.get(row['url'])
            preco = getPreco(browser)
            valor = addPreco(preco, row)
            listaPreco.append([row['ativo_id'], valor])
            id += 1

        df = pd.DataFrame(listaPreco, columns=['id', 'valor'])
        df.to_csv(dir + '/preco_acao.csv', index=False)
        browser.quit()
    except Exception as err:
        print("Erro "+str(err))
        browser.quit()


def getPreco(browser):
    preco = getPrecoId(browser)
    if (preco != False):
        return preco
    preco = getPrecoClass(browser)
    if (preco != False):
        return preco
    preco = getPrecoAttribute(browser)
    if (preco != False):
        return preco
    return 'null'


def addPreco(preco, row):
    valor = '-1'
    if preco != 'null':
        valor = str(preco.text)
    with open(logPath, 'a') as log:
        log.write('ativo@#'+valor+'-'+str(row['ativo_id'])+';')
    return valor


def getPrecoId(browser):
    try:
        return browser.find_element("id", 'last_last')
    except NoSuchElementException:
        return False


def getPrecoClass(browser):
    try:
        return browser.find_element(By.CLASS_NAME, "instrument-price_last__KQzyA")
    except NoSuchElementException:
        return False


def getPrecoAttribute(browser):

    try:
        return browser.find_element(By.CSS_SELECTOR, '[data-test=instrument-price-last]')
    except NoSuchElementException:
        return False


try:
    options = Options()
    options.page_load_strategy = 'eager'
    browser = webdriver.Remote(
        command_executor='invest_bot:4444', options=options)
    getDados()
except BaseException as err:
    with open(logPath, 'a') as log:
        log.write('erro@#:'+str(format(err))+';')
    print('Erro', format(err))
    browser.quit()
