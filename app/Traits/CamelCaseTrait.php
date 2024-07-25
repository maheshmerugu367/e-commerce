<?php

namespace App\Traits;

trait camelCaseTrait
{
    /**
     * Convert array keys to camel case.
     *
     * @param array $array
     * @return array
     */
    public function arrayKeysToCamelCase($array)
    {
        $camelCaseArray = [];
        foreach ($array as $key => $value) {
            $camelCaseKey = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
            if (is_array($value)) {
                $value = $this->arrayKeysToCamelCase($value);
            }
            $camelCaseArray[$camelCaseKey] = $value;
        }
        return $camelCaseArray;
    }
}
