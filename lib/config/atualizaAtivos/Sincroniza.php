<?php


namespace  app\lib\config\atualizaAtivos;


class Sincroniza
{

    public static function atualizaAtivos()
    {

        SincronizaFactory::sincroniza('acao')->atualiza();
        SincronizaFactory::sincroniza('easy')->atualiza();
    }
}
