<?php

namespace app\lib\config\atualizaAtivos;

use app\lib\config\atualizaAtivos\AtivosOperacoesInterface;

class FormOperacoes
{

    public  AtivosOperacoesInterface $compra;
    public  AtivosOperacoesInterface $venda;
    public  AtivosOperacoesInterface $desdobraMais;
    public  AtivosOperacoesInterface $desdobraMenos;
}
