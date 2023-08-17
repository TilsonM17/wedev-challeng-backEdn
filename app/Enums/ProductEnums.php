<?php

namespace App\Enums;

enum ProductEnums: string
{
    case OUT_OF_STOCK = 'out_of_stock';
    case IN_STOCK = 'in_stock';
    case RUNNING_LOW = 'less_than_20';
}
