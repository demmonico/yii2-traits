<?php
/**
 * @author: dep
 * Date: 08.07.16
 */

namespace common\traits;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;


/**
 * Trait add perform ajax validation to models and forms
 */
trait AjaxValidationTrait
{
    private $_performAjaxValidation;



    public function performAjaxValidation()
    {
        /**
         * @var $this \yii\base\Model
         */
        if (Yii::$app->request->isAjax && $this->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (is_null($this->_performAjaxValidation)){
                return $this->_performAjaxValidation = ActiveForm::validate($this);
            } else {
                return $this->_performAjaxValidation;
            }
        }
        return null;
    }

}