<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ItCation\CallbackForm\Model;

use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Area;

class Mail implements MailInterface
{
    /**
     * @var ConfigInterface
     */
    private $contactsConfig;

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var StateInterface
     */
    private $inlineTranslation;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Initialize dependencies.
     *
     * @param ConfigInterface $contactsConfig
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param StoreManagerInterface|null $storeManager
     */
    public function __construct(
        ConfigInterface       $contactsConfig,
        TransportBuilder      $transportBuilder,
        StateInterface        $inlineTranslation,
        StoreManagerInterface $storeManager = null
    ) {
        $this->contactsConfig = $contactsConfig;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManager = $storeManager ?: ObjectManager::getInstance()->get(StoreManagerInterface::class);
    }

    /**
     * Send email from contact form
     *
     * @param array $variables
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\MailException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function send(array $variables)
    {

        $this->inlineTranslation->suspend();
        try {
            $this->transportBuilder->setTemplateIdentifier($this->contactsConfig->emailTemplate());
            $this->transportBuilder->setTemplateOptions(
                [
                    'area' => Area::AREA_FRONTEND,
                    'store' => $this->storeManager->getStore()->getId()
                ]
            );
            $this->transportBuilder->setTemplateVars($variables);
            $this->transportBuilder->setFromByScope(
                [
                    'name' => $this->contactsConfig->nameSender(),
                    'email' => $this->contactsConfig->emailSender()
                ]
            );
            $this->transportBuilder->addTo(
                $this->contactsConfig->emailSender(),
                $this->contactsConfig->nameSender()
            );
            $transport = $this->transportBuilder->getTransport();

            $transport->sendMessage();
        } finally {
            $this->inlineTranslation->resume();
        }
    }
}
