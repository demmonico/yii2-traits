<?php
/**
 * @author: dep
 * Date: 08.07.16
 */

namespace demmonico\traits;
use Yii;
use yii\widgets\ActiveForm;


/**
 * Trait add perform ajax validation to models and forms
 */
trait AjaxValidationTrait
{
    /**
     * Store results of ajax validation
     * @var array|null
     */
    protected $_performAjaxValidationResult;
    /**
     * Flag marks that request data already was loaded
     * @var bool
     */
    protected $_isDataLoaded = false;



    /**
     * Realizes perform ajax validation for related model
     * @param array|null $post Array of post data from Yii::$app->getRequest()->post()
     * @return array|mixed|null
     */
    public function performAjaxValidation($post=null)
    {
        $request = Yii::$app->getRequest();

        /**
         * @var $this \yii\base\Model
         */
        if ($request->isAjax && $this->load(isset($post) ? $post : $request->post())) {
            $response = Yii::$app->getResponse();
            $response->format = $response::FORMAT_JSON;
            if (is_null($this->_performAjaxValidationResult)){
                $this->_performAjaxValidationResult = ActiveForm::validate($this);
            }
            return $this->_performAjaxValidationResult;
        }
        return null;
    }

    /**
     * Overload Model's method [load] to avoid duplicate call of load at ajaxValidation and common case
     * @param $data
     * @param null $formName
     * @return bool
     */
    public function load($data, $formName = null)
    {
        return $this->_isDataLoaded ?: $this->_isDataLoaded=true && parent::load($data, $formName);
    }

}
