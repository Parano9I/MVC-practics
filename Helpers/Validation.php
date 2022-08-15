<?php

namespace Shop\Helpers;

use Exception;

class Validation
{
    public static function validate(array $postData, array $rules): void
    {
        $errorsMsg = [];

        foreach ($rules as $field => $rules) {
            $postValue = $postData[$field];
            $errorsMsg = [...$errorsMsg, ...self::verifyField($postValue, $field, $rules)];
        }
        if (!empty($errorsMsg)) throw new Exception(json_encode($errorsMsg));
    }

    private static function verifyField(mixed $value, string $fieldName, array $rules): array
    {
        $errorsMsg = [];

        foreach ($rules as $ruleName => $ruleParam) {

            switch ($ruleName) {
                case ('require'):
                    if (empty($value)) {
                        self::setErrorMsg(
                            $errorsMsg,
                            $fieldName,
                            ucfirst($fieldName) . ' is reqire'
                        );
                        break 2;
                    }
                    break;
                case ('minLength'):
                    if (strlen($value) < $ruleParam) {
                        self::setErrorMsg(
                            $errorsMsg,
                            $fieldName,
                            "Length must be greater than {$ruleParam} characters"
                        );
                        break 2;
                    }
                    break;
                case ('maxLength'):
                    if (strlen($value) > $ruleParam) {
                        self::setErrorMsg(
                            $errorsMsg,
                            $fieldName,
                            "Length must be less than {$ruleParam} characters"
                        );
                        break 2;
                    }
                    break;
                case ('pattern'):
                    if (!preg_match($ruleParam, $value)) {
                        self::setErrorMsg(
                            $errorsMsg,
                            $fieldName,
                            "Value doesn't look like {$fieldName}"
                        );
                        break 2;
                    }
                    break;
            }
        }

        return $errorsMsg;
    }

    private static function setErrorMsg(array &$msgArr, string $fieldName, string $msg): void
    {
        // if (empty($msgArr[$fieldName])) {
        //     $msgArr[$fieldName] = [$msg];
        // } else array_push($msgArr[$fieldName], $msg);
        $msgArr[$fieldName] = $msg;
    }
}