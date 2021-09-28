<?php

if (!function_exists('csv_to_array')) {
    /**
     * @link http://gist.github.com/385876
     */
    function csv_to_array($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return FALSE;

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }
}

if (!function_exists('class_from_annotation')) {
    function class_from_annotation(string $className, string $propertyName): ?string
    {
        $rp = new \ReflectionProperty($className, $propertyName);
        if (preg_match('/@var\s+([^\s]+)/', $rp->getDocComment(), $matches)) {
            return $matches[1];
        }

        return null;
    }
}

if (!function_exists('translate')) {
    function translate(string $key, array $replace = [], string $locale = null)
    {
        if ($key[0] == '@') {
            $key = preg_replace('/^@(.+$)/', 'validation.attributes.$1', $key);
        }

        return trans($key, $replace, $locale);
    }
}
