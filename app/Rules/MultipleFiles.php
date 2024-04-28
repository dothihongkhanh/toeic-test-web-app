<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MultipleFiles implements ValidationRule
{
    protected $count;

    public function __construct($count)
    {
        $this->count = $count;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (count($value) !== $this->count) {
            $fail("The :attribute must have exactly {$this->count} files.");
        }
    }
}
