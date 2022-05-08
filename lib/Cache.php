<?php
/**
 * Este arquivo é parte do
 *    ___       _       _
 *   / __\__ _ (_)_   _(_)
 *  / /  / _` || | | | | |
 * / /__| (_| || | |_| | |
 * \____/\__,_|/ |\__,_|_|
 *           |__/
 *                 Um sistema integrado do IFNMG
 * PHP version 8
 *
 * @copyright Copyright (c) 2016, IFNMG
 * @license   http://cajui.ifnmg.edu.br/license/ MIT License
 * @link      http://cajui.ifnmg.edu.br/
 */

namespace app\lib;

use Yii;
use yii\base\InvalidConfigException;

/**
 * Classe com funções estaticas para manipular do componente cache
 * @author Christopher Mota
 * @since  1.1.19
 */
abstract class Cache
{
    /**
     * @param $id
     * @return \yii\caching\Cache|null
     * @throws InvalidConfigException
     * @throws \yii\base\InvalidConfigException
     */
    public static function getCache($id)
    {
        if (!in_array($id, array_keys(self::findCaches()))) {
            throw new InvalidConfigException('O nome do componente de cache fornecido não é válido');
        }

        return Yii::$app->get($id);
    }

    /**
     * Returns array of caches in the system, keys are cache components names, values are class names.
     *
     * @param array $cachesNames caches to be found
     * @return array
     */
    public static function findCaches(array $cachesNames = [])
    {
        $caches = [];
        $components = Yii::$app->getComponents();
        $findAll = ($cachesNames == []);

        foreach ($components as $name => $component) {
            if (!$findAll && !in_array($name, $cachesNames)) {
                continue;
            }

            if ($component instanceof Cache) {
                $caches[$name] = ['name' => $name, 'class' => get_class($component)];
            } elseif (is_array($component) && isset($component['class']) && self::isCacheClass($component['class'])) {
                $caches[$name] = ['name' => $name, 'class' => $component['class']];
            } elseif (is_string($component) && self::isCacheClass($component)) {
                $caches[$name] = ['name' => $name, 'class' => $component];
            }
        }

        return $caches;
    }

    /**
     * Checks if given class is a Cache class.
     *
     * @param string $className class name.
     * @return bool
     */
    public static function isCacheClass($className)
    {
        return is_subclass_of($className, yii\caching\Cache::class);
    }
}
