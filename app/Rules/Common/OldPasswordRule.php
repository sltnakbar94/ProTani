<?php

namespace App\Rules\Common;

use Illuminate\Contracts\Validation\Rule;
use Hash;
use App\Customer;
use App\User;
use Auth;

class OldPasswordRule implements Rule
{
    protected $type;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($type = 'customer')
    {
        // only has two param: customer or merchant
        $this->type = $type;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Hash::check($value, Auth::guard($this->type)->user()->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Make sure you old password correct.';
    }
}
