<?php

namespace Flowframe\Trend\Adapters;

use Error;
use Illuminate\Database\Query\Grammars\MySqlGrammar;

class MySqlAdapter extends AbstractAdapter
{
    public function format(string $column, string $interval): string
    {
        $format = match ($interval) {
            'minute' => '%Y-%m-%d %H:%i:00',
            'hour' => '%Y-%m-%d %H:00',
            'day' => '%Y-%m-%d',
            'week' => '%Y-%u',
            'month' => '%Y-%m',
            'year' => '%Y',
            default => throw new Error('Invalid interval.'),
        };
        
        $wrappedColumn = (new MySqlGrammar)->wrap($column);
        return "date_format({$wrappedColumn}, '{$format}')";
    }
}
