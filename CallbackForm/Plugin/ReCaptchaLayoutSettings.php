<?php

namespace ItCation\CallbackForm\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use MSP\ReCaptcha\Model\LayoutSettings;

class ReCaptchaLayoutSettings
{
    const XML_PATH_ENABLED_FRONTEND_VPN = 'msp_securitysuite_recaptcha/frontend/enabled_callback_form';
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * ReCaptchaLayoutSettings constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     *
     * @param LayoutSettings $subject
     * @param array $result
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetCaptchaSettings(
        LayoutSettings $subject,
        array          $result
    ) {
        $result['enabled']['callback'] = $this->scopeConfig->getValue(self::XML_PATH_ENABLED_FRONTEND_VPN);

        return $result;
    }
}
