<?php

namespace app\lib\widget;

use kartik\growl\Growl;
use kartik\growl\GrowlAsset;
use kartik\base\AnimateAsset;
use yii\helpers\Json;

class GrowlInvest extends Growl
{
    public $nomeTemplate = '';

    protected function registerAssets()
    {
        $view = $this->getView();
        if (in_array($this->type, self::$_themes)) {
            GrowlAsset::register($view)->addTheme($this->type);
        } else {
            GrowlAsset::register($view);
        }
        if ($this->useAnimation) {
            AnimateAsset::register($view);
        }
        $this->registerPluginOptions('notify');
        $js = '$.notify(' . Json::encode($this->_settings) . ', ' . $this->_hashVar . ');';
        if (!empty($this->delay) && $this->delay > 0) {
            $js = 'setTimeout(function () {' . $js . '}, ' . $this->delay . ');';
        }
    }

    protected function hashPluginOptions($name)
    {
        $this->_encOptions = empty($this->pluginOptions) ? '' : Json::htmlEncode($this->pluginOptions);
        $this->_hashVar = $name . '_' . $this->nomeTemplate;
        $this->options['data-krajee-' . $name] = $this->_hashVar;
    }
}
