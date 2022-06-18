<?php


namespace app\models\financas\service\sincroniza;


class Sincroniza
{

    public static function atualizaAtivos()
    {

        SincronizaFactory::sincroniza('acao')->atualiza();
        SincronizaFactory::sincroniza('easy')->atualiza();
        SincronizaFactory::sincroniza('banco_inter')->atualiza();
    }
}
