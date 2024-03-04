# Lightweight PHP Data Validator

Argus is a PHP package designed to simplify and streamline data validation tasks in your applications. It offers a comprehensive set of validation rules to ensure the integrity and accuracy of your data.

## Features

- **Common Validations:** Perform checks for required fields, email format, string values, numeric values, and length restrictions.
- **Range Validation:** Ensure numeric data falls within a specific range.
- **Customization:** Easily define custom validation rules to meet your specific needs.
- **Error Reporting:** Get clear and informative error messages to identify invalid data points.

## Installation

You can install the package using Composer:

```bash
composer require yi/argus
```

## Usage

The package provides a simple and intuitive API for data validation. Here's a basic example:

```php
<?php

require 'vendor/autoload.php';

use Yi\Argus\Validator;

$data = [
    'name'  => 'John Doe',
    'email' => 'invalid_email',
    'age'   => 30,
];

$rules = [
    'name'  => ['required', 'string', 'length:2:255'],
    'email' => ['required', 'email'],
    'age'   => ['required', 'numeric', 'between:18:120'],
];

$validator = new Validator();
$errors = $validator->validate($data, $rules);

if (empty($errors)) {
    echo 'Data is valid!';
} else {
    echo 'Validation errors:' . PHP_EOL;
    foreach ($errors as $field => $errorMessages) {
        echo "  * $field: " . implode(', ', $errorMessages) . PHP_EOL;
    }
}
```

## Supported Validations

- `required` Checks if a field is present and not empty.
- `string` Checks if a field value is a string.
- `numeric` Checks if a field value is numeric.
- `email` Checks if a field value is a valid email address.
- `length:min:max` Checks if the field value length falls within the specified range (min and max are integers).
- `between:min:max` Checks if a numeric field value falls within the specified range (min and max are integers).

## License

This project is licensed under the MIT License - see the [LICENSE](LICENCE) file for details.
