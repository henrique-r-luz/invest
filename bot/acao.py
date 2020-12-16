from selenium import webdriver #esse comando importa a biblioteca
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
import pandas as pd
import json
import sys

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
];



#url = sys.argv[1];
#browser = webdriver.Firefox(executable_path="/home/vagrant/anaconda3/bin/geckodriver",log_path="/tmp/geckodriver.log")


browser = webdriver.Firefox();
listaPreco = [];
for row in discionarioAcoes:
    browser.get(row[1]);
    preco = browser.find_element_by_id("last_last");
    listaPreco.append([row[0],preco.text])

#print(listaPreco);
df = pd.DataFrame(listaPreco, columns =['id', 'valor'])
df.to_csv(filePath+'preco_acao.csv',index=False)
browser.quit()
print(df);

