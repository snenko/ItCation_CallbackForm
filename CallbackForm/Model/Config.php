<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ItCation\CallbackForm\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Contact module configuration
 */
class Config implements ConfigInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function emailTemplate(): string
    {
        return ConfigInterface::XML_PATH_EMAIL_TEMPLATE;

    }

    /**
     * {@inheritdoc}
     */
    public function emailSender(): string
    {
        return $this->scopeConfig->getValue(
            ConfigInterface::XML_PATH_EMAIL_SENDER_EMAIL,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * {@inheritDoc}
     */
    public function nameSender(): string
    {
        return $this->scopeConfig->getValue(
            ConfigInterface::XML_PATH_EMAIL_SENDER_NAME,
            ScopeInterface::SCOPE_STORE
        );
    }
}
