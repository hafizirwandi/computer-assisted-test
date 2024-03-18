<?php

use Illuminate\Support\Str;

if (!function_exists('statusUser')) {
    function statusUser($status)
    {
        switch ($status) {
            case 1:
                return '<span class="badge bg-label-success" text-capitalized="">Active</span>';

            case 0:
                return '<span class="badge bg-label-warning" text-capitalized="">Pending</span>';

            case 2:
                return '<span class="badge bg-label-secondary" text-capitalized="">Inactive</span>';

            default:
                return '';
        }
    }
}
