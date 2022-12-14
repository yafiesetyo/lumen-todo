<?php

namespace App\Constants;

const SORT_ASC = 'asc';
const SORT_DESC = 'desc';

class OrderBy
{
    public static string $sort = SORT_ASC;

    public static function defaultSort(string $sort): string
    {
        if ($sort == '') {
            return self::$sort;
        }
        if (strtoupper($sort) !== SORT_ASC && strtoupper($sort) !== SORT_DESC) {
            return self::$sort;
        }

        return strtolower($sort);
    }
}
