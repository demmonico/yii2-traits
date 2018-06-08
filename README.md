# Yii2 traits library

## Description

Yii2 traits library which used in web-application development.



## Composition

### AjaxValidationTrait

Trait add perform ajax validation to models and forms. 

##### Usage:

use [demmonico\models\Model](https://github.com/demmonico/yii2-models) as parent or set in you model

```php
use AjaxValidationTrait;
```

in controller

```php
if (!is_null($validate = $model->performAjaxValidation()))
            return $validate;
```

### ConstantTrait

***!!! This trait is DEPRECATED*** Use [demmonico/reflection](https://github.com/demmonico/reflection) instead!!!

Trait generates array of class constant labels or one label by constant value 

##### Usage:

set in your model

```php
use ConstantTrait;

const NAME_FIRST = 1;
const NAME_SECOND = 2;
```

then anywhere get array values and names of constants:

```php
ModelName::getName();   // returns array(1 => 'First', 2 => 'Second');
```
or
```php
$model->getName();      // returns array(1 => 'First', 2 => 'Second');
```
Whether get name by constant value: 
```php
ModelName::getName(ModelName::NAME_FIRST);   // returns 'First';
```
