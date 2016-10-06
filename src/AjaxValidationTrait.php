<?php
/**
 * @author: dep
 * Date: 08.07.16
 */

namespace demmonico\traits;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;


/**
 * Trait add perform ajax validation to models and forms
 */
trait AjaxValidationTrait
{
    protected $_performAjaxValidationResult;



    public function performAjaxValidation()
    {
        /**
         * @var $this \yii\base\Model
         */
        if (Yii::$app->request->isAjax && $this->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (is_null($this->_performAjaxValidationResult)){
                $this->_performAjaxValidationResult = ActiveForm::validate($this);
            }
            return $this->_performAjaxValidationResult;
        }
        return null;
    }

}
