<?php

use App\Foundation\Support\Interfaces\Validatable;
use App\Foundation\Support\Traits\Validating;

class ValidatingTest extends TestCase
{
    public function testValidating()
    {
        $dummy = new ValidatingDummy();
        $this->assertFalse($dummy->validate()->isValid());
    }
}

class ValidatingDummy implements Validatable
{
    use Validating;

    public function validate()
    {
        return $this->getValidation()->fail('key', 'message');
    }
}