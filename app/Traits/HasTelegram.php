<?php

namespace App\Traits;

use App\Models\User;
use Telegram\Bot\Laravel\Facades\Telegram;

trait HasTelegram
{
    /**
     * Get Telegram ID of Specific Parent Unit.
     *
     * @param $model
     * @return string telegram_id
     */
    public function getParentTelegramId($model) : ?string
    {
        return User::where('unit_id', $model->userRelationship->unitRelationship->parent)
                -> first('telegram_id')
                -> telegram_id ?? null;
    }

    /**
     * Get Telegram ID From Specific User
     *
     * @param int $userId
     * @return string telegram_id
     */
    public function getTelegramId(int $userId) : ?string
    {
        return User::where('id', $userId)
                -> first('telegram_id')
                -> telegram_id ?? null;
    }
}
