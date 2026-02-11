<?php

use Carbon\Carbon;

if (! function_exists('formatNumber')) {
    function formatNumber($number, $returnDefault=0, $removeDecimal=false)
    {
        if($number){
            try {
                $decimalPrecision = $removeDecimal ? 0 : 2;
                return number_format(round($number, $decimalPrecision), $decimalPrecision, ',', '.');
            } catch (Throwable $t) {
                return $number;
            }
        }

        return $returnDefault;
    }
}

if (! function_exists('formatDate')) {
    function formatDate($date, $format='d.m.Y', $stringDateFormat='Y-m-d')
    {
        if(!$date){
            return "";
        }

        if($date instanceof Carbon){
            return $date->format($format);
        }

        try
        {
            return Carbon::createFromFormat($stringDateFormat,  $date)->format($format);
        }  catch (\Exception $ex){}

        return "";
    }
}

if (! function_exists('parseNumber')) {
    function parseNumber($number, $returnNull=true)
    {
        if(!$number && $returnNull){
            return null;
        }

        if(!$number){
            return $number;
        }

        $locale = App::currentLocale() == 'en' ? 'en_US' : 'de_DE';

        if(str_contains($number, ',')) {
            // php-int required on production server
            $fmt = numfmt_create( $locale, NumberFormatter::DECIMAL );
            $number = numfmt_parse($fmt, $number);

            // workaround
            //return floatval(str_replace(',', '.', str_replace('.', '', $number)));
        }

        return $number;
    }
}

/**
 * join all non-empty array indexes with separator
 * empty indexes will be replaced with placeholder if given
 */
if (! function_exists('joinValues')) {
    function joinValues(array $values, $separator=', ', $emptyPlaceHolder='', $onlyIfAll=false)
    {
        // if all values are empty
        if(!array_filter($values)){
            return '';
        }

        // if parameter enabled and any value is empty.
        if($onlyIfAll && count($values) != count(array_filter($values)))
        {
            return $emptyPlaceHolder;
        }

        if($emptyPlaceHolder){
            $values = array_map(fn ($value) => $value ?: $emptyPlaceHolder, $values);
        }

        return implode($separator, array_filter($values));
    }
}

/**
 * parse Emails string default separator is ';'
 * multiple emails to array
 */
if (! function_exists('parseEmailField')) {
    function parseEmailField($emails, $separator=';'): array
    {
        $emailList = array_filter(explode(trim($separator), trim($emails)));
        $emailList = array_map('trim', $emailList);

        if($emailList) {
            foreach ($emailList as $key => $email) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    unset($emailList[$key]);
                }
            }
        }

        return array_values($emailList);
    }
}

/**
 * convert empty string to null
 */
if (!function_exists('strTrimOrNull')) {
    function strTrimOrNull($value)
    {
        if (!is_string($value)) {
            return $value;
        }

        $value = trim($value);

        return $value === '' ? null : $value;
    }
}

if (!function_exists('isActive')) {
    function isActive($value, $compare, $class='active')
    {
        return $value === $compare ? $class : '';
    }
}

/**
 * append file prefix and translate
 */
if (!function_exists('transTwap')) {
    function transTwap($key, $prefix = null): string
    {
        $prefix = trim($prefix) ? trim($prefix).'.': '';
        $key = $key ? $prefix.$key : '';

        return $key ? trans($key) : $key;
    }
}

/**
 * append file prefix and translate
 */
if (!function_exists('getStringBetween')) {
    function getStringBetween($string, $start, $end): string
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return trim(substr($string, $ini, $len));
    }
}

if (!function_exists('excelToCarbon')) {
    function excelToCarbon($date): ?Carbon
    {
        try {
            $date = is_numeric($date) ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)) : null;
        } catch (\Exception) {
            $date = null;
        }

        return $date;
    }
}

/**
 * return formatted yadcf filter string for query
 * @param $query
 * @param string $type
 * @return array|false
 */
if (!function_exists('formatYadcfFilters')) {
    function formatYadcfFilters($query, string $type='date'): bool|array
    {
        if(!$query){
            return false;
        }

        $filters= [];

        if($type == 'date' && str_contains($query, '-yadcf_delim-'))
        {
            $keywords = explode('-yadcf_delim-', $query);
            if(array_filter($keywords))
            {
                $filters['start_date'] = formatDate($keywords[0], 'Y-m-d', 'd.m.Y');
                $filters['end_date'] = isset($keywords[1]) && $keywords[1] ? formatDate($keywords[1], 'Y-m-d', 'd.m.Y') : Carbon::now()->format('Y-m-d');
            }
        }

        return $filters;
    }
}
