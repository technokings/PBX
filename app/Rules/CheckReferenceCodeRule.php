<?php

namespace App\Rules;

use App\Models\DefaultSetting;
use App\Services\CGRTService;
use Illuminate\Contracts\Validation\Rule;

class CheckReferenceCodeRule implements Rule
{
    /**
     * @var CGRTService
     */
    private $cGRTService;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->cGRTService = app(CGRTService::class);
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
        $isFound = false;
        if (config('fpbx.resellerCode.checkInDefaultSettings')) {
            $reference_codes = DefaultSetting::where([
                [ 'default_setting_value' , $value],
                [ 'default_setting_category', 'billing'],
                [ 'default_setting_subcategory', 'reseller_code'],
            ])->first();

            if ($reference_codes) {
                $isFound = true;
            }
        }

        if ($isFound) {
            return $isFound;
        }

        if (config('fpbx.cgrt.enabled') && config('fpbx.resellerCode.checkInCGRT')) {
            $reference_codes = $this->cGRTService->getReferenceCodes();
            $isFound = in_array($value, $reference_codes);
        }

        return $isFound;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The selected reseller reference code is invalid.');
    }
}