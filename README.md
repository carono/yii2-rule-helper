```markdown
# Yii2 Rule Helper

A lightweight helper module for Yii2 framework that provides utility methods for working with model validation rules and validators.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run:

```bash
composer require carono/yii2-rule-helper
```

or add:

```json
"carono/yii2-rule-helper": "*"
```

to the require section of your `composer.json` file.

## Requirements

- PHP 7.1 or higher
- Yii2 framework

## Usage

### `RuleHelper::getValidatorShortName($validator)`

Gets the short name of a validator from Yii2's built-in validators.

```php
use carono\yii2\helpers\RuleHelper;

// Returns 'required'
$shortName = RuleHelper::getValidatorShortName('yii\validators\RequiredValidator');

// Returns 'string'
$shortName = RuleHelper::getValidatorShortName('yii\validators\StringValidator');

// Returns null for non-built-in validators
$shortName = RuleHelper::getValidatorShortName('app\validators\CustomValidator');
```

### `RuleHelper::haveValidator($model, string $attribute, $validator)`

Checks if a model has a specific validator applied to a given attribute.

```php
use carono\yii2\helpers\RuleHelper;
use app\models\User;

// Using validator class name
$hasRequired = RuleHelper::haveValidator(User::class, 'username', 'yii\validators\RequiredValidator');

// Using validator short name
$hasString = RuleHelper::haveValidator($userModel, 'email', 'string');

// Using validator instance (for custom validators)
$customValidator = new CustomValidator();
$hasCustom = RuleHelper::haveValidator($userModel, 'custom_field', $customValidator);
```

#### Parameters

- `$model`: Can be either a Model instance or a class name that extends `yii\base\Model`
- `$attribute`: The attribute name to check
- `$validator`: Can be:
    - Validator class name (e.g., `'yii\validators\RequiredValidator'`)
    - Validator short name (e.g., `'required'`, `'string'`)
    - Validator instance

#### Return Value

Returns `true` if the specified validator is applied to the given attribute, `false` otherwise.

## Examples

### Checking for specific validators

```php
class User extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            ['email', 'email'],
            ['username', 'string', 'max' => 255],
        ];
    }
}

// Check validators
$hasRequired = RuleHelper::haveValidator(User::class, 'username', 'required'); // true
$hasEmailValidator = RuleHelper::haveValidator(User::class, 'email', 'email'); // true
$hasNumberValidator = RuleHelper::haveValidator(User::class, 'username', 'number'); // false
```

### Using in controller or component

```php
public function actionCheckValidators($id)
{
    $user = User::findOne($id);
    
    if (RuleHelper::haveValidator($user, 'email', 'required')) {
        // Handle required email field
    }
    
    if (RuleHelper::haveValidator($user, 'username', 'string')) {
        // Handle string validation for username
    }
}
```

## License

MIT

## Support

If you have any questions or issues, please create an issue on GitHub.

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.
```