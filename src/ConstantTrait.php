<?php
/**
 * @author: dep
 * Date: 08.07.16
 */

namespace demmonico\traits;

use demmonico\helpers\ReflectionHelper;
use Yii;
use yii\base\Exception;


/**
 * Trait generates array of class constant labels or one label by constant value
 */
trait ConstantTrait
{
    private $useCacheConstantNames = false;

    // can be set here or in implements class to use custom labels
    //public $statusLabels = [];
    //public function $statusLabels(){ return []; };



    public function __call( $name, $arguments )
    {
        $class = get_called_class();
        $constPrefix = ReflectionHelper::parseGetterName($name);

        $constArr = ($this->useCacheConstantNames) ? Yii::$app->cache->get($class.$constPrefix) : false;
        if (false === $constArr){

            // get const labels
            $constArr = ReflectionHelper::getConstants($class, $constPrefix);

            // get overwritten labels
            $labelsArrName = $constPrefix.'Labels';
            if (property_exists($class, $labelsArrName) && ($labelsArr = $this->$labelsArrName)
                || method_exists($class, $labelsArrName) && ($labelsArr = $this->$labelsArrName())
                AND is_array($labelsArr)
            ){
                foreach($labelsArr as $k=>$v) $constArr[$k] = $v;
            }

            // remember array
            if ($this->useCacheConstantNames)
                Yii::$app->cache->set($class.$constPrefix, $constArr);
        }

        // return key label or labels array
        if (!empty($constArr) && !empty($arguments) && is_array($arguments)){
            $key = array_shift($arguments);
            if (isset($constArr[$key]))
                return $constArr[$key];
            else
                throw new Exception('Invalid key');
        }
        return $constArr;
    }



    public static function __callStatic( $name, $arguments )
    {
        $class = get_called_class();
        $constPrefix = ReflectionHelper::parseGetterName($name);

        // get const labels
        $constArr = ReflectionHelper::getConstants($class, $constPrefix);

        // return key label or labels array
        if (!empty($constArr) && !empty($arguments) && is_array($arguments)){
            $key = array_shift($arguments);
            if (isset($constArr[$key]))
                return $constArr[$key];
            else
                throw new Exception('Invalid key');
        }
        return $constArr;
    }

}