<?php

declare(strict_types=1);

namespace App\Application\Validation;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationErrorsParser
{
    public static function getMessage(ConstraintViolationListInterface $violationList): string
    {
        $errorMessages = [];
        foreach ($violationList as $violation) {
            $errorMessages[] = $violation instanceof ConstraintViolation
                ? (string) $violation
                : (string) $violation->getMessage();
        }

        return implode(' ', $errorMessages);
    }
}
