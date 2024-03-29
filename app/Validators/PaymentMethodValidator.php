<?php

namespace App\Validators;

use App\Helpers\ValidationHelper;
use Illuminate\Support\Facades\Validator;

class PaymentMethodValidator
{
    private ValidationHelper $validationHelper;

    public function __construct(ValidationHelper $validationHelper)
    {
        $this->validationHelper = $validationHelper;
    }

    public function validateAddPaymentMethodInput($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:payment_methods,name',
            'fee' => 'required|numeric',
            'code' => 'required|string|max:10|unique:payment_methods,code',
            'account_number' => 'required|string|max:45',
            'type' => 'nullable|string|max:45',
            'description' => 'nullable|string|max:255',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }

    public function validateEditPaymentMethodInput($request): bool|array
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'fee' => 'required|numeric',
            'code' => 'required|string|max:10',
            'account_number' => 'required|string|max:45',
            'type' => 'nullable|string|max:45',
            'description' => 'nullable|string|max:255',
        ], ValidationHelper::VALIDATION_MESSAGES);

        return $this->validationHelper->getValidationResponse($validator);
    }
}
