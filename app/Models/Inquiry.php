<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'category',
        'message',
        'status',
    ];

    public const CATEGORY_TRADING = 'trading';
    public const CATEGORY_MARKET_DATA = 'market_data';
    public const CATEGORY_TECHNICAL_ISSUE = 'technical_issue';
    public const CATEGORY_GENERAL = 'general';

    public static function categories(): array
    {
        return [
            self::CATEGORY_TRADING,
            self::CATEGORY_MARKET_DATA,
            self::CATEGORY_TECHNICAL_ISSUE,
            self::CATEGORY_GENERAL,
        ];
    }
}