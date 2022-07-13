<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ItCation\CallbackForm\Model;

/**
 * Contact module configuration
 *
 * @api
 * @since 100.2.0
 */
interface ConfigInterface
{
    /**
     * Recipient email config path
     */
    const XML_PATH_EMAIL_SENDER_NAME = 'trans_email/ident_itcation_callback/name';

    /**
     * Sender email config path
     */
    const XML_PATH_EMAIL_SENDER_EMAIL = 'trans_email/ident_itcation_callback/email';

    /**
     * Email template config path
     */
    const XML_PATH_EMAIL_TEMPLATE = 'itcation_callback_email_template';

    /**
     * Return email template identifier
     *
     * @return string
     * @since 100.2.0
     */
    public function emailTemplate(): string;

    /**
     *
     * @return string
     * @since 100.2.0
     */
    public function emailSender(): string;

    /**
     *
     * @return string
     * @since 100.2.0
     */
    public function nameSender(): string;
}
