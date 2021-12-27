<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\GiftCard;

class Constants
{
    const OPTION_RECIPIENT_NAME = 'recipient_name';

    const OPTION_RECIPIENT_EMAIL = 'recipient_email';

    const OPTION_AMOUNT = 'amount';

    const OPTION_LIST = [
        self::OPTION_RECIPIENT_NAME,
        self::OPTION_RECIPIENT_EMAIL,
        self::OPTION_AMOUNT
    ];

}
