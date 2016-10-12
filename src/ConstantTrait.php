<?php

namespace demmonico\traits;

use demmonico\helpers\ReflectionHelper;
use Yii;


/**
 * Trait generates array of class constant labels or one label by constant value
 *
 * @use
 * cached constant array: to use Yii::$app->cache class-owner of trait should has static property [className::useCacheConstantNames] and set it to true
 * use custom constant names: class-owner of trait should has static property or method with labels array which will be merged with stock,
 *                              for example, [className::statusConstantLabels] or [className::statusConstantLabels()] to get labels of STATUS constants
 *
 * @author: dep
 * Date: 08.07.16
 */
trait ConstantTrait
{
    public function __call($name, $arguments)
    {
        return static::getConstantNames($name, $arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return static::getConstantNames($name, $arguments);
    }

    private static function getConstantNames($name, $arguments)
    {
        $class = get_called_class();
        $constPrefix = ReflectionHelper::parseGetterName($name);

        // try to get from cache
        $isUseCache = property_exists($class, 'useCacheConstantNames') && $class::useCacheConstantNames;
        $constArr = $isUseCache ? Yii::$app->getCache()->get($class.$constPrefix) : false;

        // else load from class
        if (false === $constArr){

            // get const labels
            $constArr = ReflectionHelper::getConstants($class, $constPrefix);

            // get overwritten labels
            $customLabelsName = $constPrefix.'ConstantLabels';
            if (property_exists($class, $customLabelsName) && ($customLabels = $class::$customLabelsName)
                || method_exists($class, $customLabelsName) && ($customLabels = $class::$customLabelsName())
                AND is_array($customLabels)
            ){
                $constArr = array_merge($constArr, $customLabels);
            }

            // remember array
            if ($isUseCache)
                Yii::$app->cache->set($class.$constPrefix, $constArr);
        }

        // return key label or labels array
        if (!empty($constArr) && !empty($arguments) && is_array($arguments)){
            $key = array_shift($arguments);
            return isset($constArr[$key]) ? $constArr[$key] : '<unknoun>';
        }

        return $constArr;
    }

}
