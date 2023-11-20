<?php

namespace app\models\sincronizar\services;

use app\lib\CajuiHelper;
use app\lib\helpers\InvestException;
use app\models\sincronizar\XpathBot;
use app\models\sincronizar\XpathBotForm;

class XpathBotServices
{

    private XpathBot $xpathBot;

    public function __construct(
        private ?XpathBotForm $xpathBotForm
    ) {
    }

    public function load($post)
    {
        $this->xpathBotForm->load($post);
    }


    public function setModel($id)
    {

        $this->xpathBot =  XpathBot::findOne($id);
        $this->xpathBotForm->ativos = [$this->xpathBot->site_acao_id];
        $this->xpathBotForm->data = $this->xpathBot->data;
        $this->xpathBotForm->xpath = $this->xpathBot->xpath;
    }

    public function save()
    {

        foreach ($this->xpathBotForm->ativos as $ativo_id) {
            $xpathBot =  new XpathBot();
            $xpathBot->site_acao_id = $ativo_id;
            $xpathBot->data = $this->xpathBotForm->data;
            $xpathBot->xpath = $this->xpathBotForm->xpath;
            if (!$xpathBot->save()) {
                $erro = CajuiHelper::processaErros($xpathBot->getErrors());
                throw new InvestException($erro);
            }
        }
    }

    public function update()
    {
        $this->xpathBot->data = $this->xpathBotForm->data;
        $this->xpathBot->xpath = $this->xpathBotForm->xpath;
        if (!$this->xpathBot->save()) {
            $erro = CajuiHelper::processaErros($this->xpathBot->getErrors());
            throw new InvestException($erro);
        }
    }
}
