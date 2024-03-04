<?php

namespace Tests\Unit;

use Yi\Argus\Validator;
use Tests\TestCase;

class ValidatorTest extends TestCase
{
    public function testRequiredValidation()
    {
        $validator = new Validator();

        $data = ['name' => ''];
        $rules = ['name' => ['required']];

        $errors = $validator->validate($data, $rules);

        $this->assertArrayHasKey('name', $errors);
        $this->assertContains('Required validation failed.', $errors['name']);
    }

    public function testEmailValidation()
    {
        $validator = new Validator();

        $data = ['email' => 'invalid_email'];
        $rules = ['email' => ['required', 'email']];

        $errors = $validator->validate($data, $rules);

        $this->assertArrayHasKey('email', $errors);
        $this->assertContains('Email validation failed.', $errors['email']);
    }

    public function testStringValidation()
    {
        $validator = new Validator();

        $data = ['age' => 30];
        $rules = ['age' => ['required', 'string']]; // This should fail as age is numeric

        $errors = $validator->validate($data, $rules);

        $this->assertArrayHasKey('age', $errors);
        $this->assertContains('String validation failed.', $errors['age']);
    }

    public function testNumericValidation()
    {
        $validator = new Validator();

        $data = ['age' => 'thirty'];
        $rules = ['age' => ['required', 'numeric']];

        $errors = $validator->validate($data, $rules);

        $this->assertArrayHasKey('age', $errors);
        $this->assertContains('Numeric validation failed.', $errors['age']);
    }

    public function testLengthValidation()
    {
        $validator = new Validator();

        $data = ['name' => 'John Doe'];
        $rules = ['name' => ['required', 'string', 'length:5:255']];

        $errors = $validator->validate($data, $rules);

        $this->assertEmpty($errors); // Name is valid with this length

        $data = ['name' => 'John'];
        $errors = $validator->validate($data, $rules);

        $this->assertArrayHasKey('name', $errors);
        $this->assertContains('Length validation failed.', $errors['name']);
    }

    public function testBetweenValidation()
    {
        $validator = new Validator();

        $data = ['age' => 150];
        $rules = ['age' => ['required', 'numeric', 'between:18:120']];

        $errors = $validator->validate($data, $rules);

        $this->assertArrayHasKey('age', $errors);
        $this->assertContains('Between validation failed.', $errors['age']);

        $data = ['age' => 25];
        $errors = $validator->validate($data, $rules);

        $this->assertEmpty($errors); // Age is within the range
    }
}
