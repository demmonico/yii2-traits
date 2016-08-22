#Yii2 traits library
##Description
Yii2 traits library which used in web-application development.



##Composition
###AjaxValidationTrait

Trait add perform ajax validation to models and forms. 

#####Usage:

use [demmonico\models\Model](https://github.com/demmonico/yii2-models) as parent or set in you model

```php
use AjaxValidationTrait;
```

in controller

```php
if (!is_null($validate = $model->performAjaxValidation()))
            return $validate;
```
