<?php

namespace carono\yii2\helpers;

use yii\base\Model;
use yii\validators\Validator;

class RuleHelper
{

    public static function getValidatorShortName($validator)
    {
        foreach (Validator::$builtInValidators as $name => $item) {
            if ((is_array($item) && $item['class'] == $validator) || $item == $validator || $name == $validator) {
                return $name;
            }
        }
        return null;
    }

    public static function haveValidator($model, string $attribute, $validator): bool
    {
        if (is_string($model) && is_subclass_of($model, Model::class)) {
            $model = new $model();
        }

        if (!$model instanceof Model) {
            throw new \InvalidArgumentException('First argument must be a Model instance or class name');
        }

        $isValidatorString = is_string($validator);
        $validatorClassName = $isValidatorString ? $validator : get_class($validator);
        $validatorShortName = $isValidatorString ? $validator : self::getValidatorShortName($validator);

        foreach ($model->getValidators() as $validatorInstance) {
            if (!in_array($attribute, $validatorInstance->attributes, true)) {
                continue;
            }

            $currentValidatorClass = get_class($validatorInstance);
            $currentShortName = self::getValidatorShortName($currentValidatorClass);

            $matchesByFullClass = $currentValidatorClass === $validatorClassName;
            $matchesByShortName = $currentShortName === $validatorShortName;
            $matchesByBuiltInName = $currentShortName === $validator;

            if ($matchesByFullClass || $matchesByShortName || $matchesByBuiltInName) {
                return true;
            }
        }

        return false;
    }
}