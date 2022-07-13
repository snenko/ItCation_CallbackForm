<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ItCation\CallbackForm\Model;

/**
 * Email from contact form
 *
 * @api
 * @since 100.2.0
 */
interface MailInterface
{
    /**
     * Send email from Callback form
     *
     * @param array $variables Email template variables
     * @return void
     * @since 100.2.0
     */
    public function send(array $variables);
}
