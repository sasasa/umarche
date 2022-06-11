<?php

namespace App\Enums;

enum SortOrder: string
{
    // 基本情報
    case RECOMMEND = '0';
    case HIGHER = '1';
    case LOWER = '2';
    case LATER = '3';
    case OLDER = '4';

    // 日本語を追加
    public function label(): string
    {
        return match($this)
        {
            SortOrder::RECOMMEND => 'おすすめ順',
            SortOrder::HIGHER => '料金の高い順',
            SortOrder::LOWER => '料金の安い順',
            SortOrder::LATER => '新しい順',
            SortOrder::OLDER => '古い順',
        };
    }
}