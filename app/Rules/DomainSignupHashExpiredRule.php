<?php

namespace App\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;
use App\Models\PostponedAction;

class DomainSignupHashExpiredRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $model = PostponedAction::where('hash', $value)->first();

        if (empty($model)) {
            return false;
        }

        $expireDate = $model->created_at->add(config('fpbx.default.domain.activation_expire'));
        $now = \Carbon\Carbon::now();

        if ($now > $expireDate) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Domain activation link expired';
    }
}
