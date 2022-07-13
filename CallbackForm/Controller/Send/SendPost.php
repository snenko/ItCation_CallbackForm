<?php

namespace ItCation\CallbackForm\Controller\Send;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;

class SendPost extends \Magento\Framework\App\Action\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    private $formKeyValidator;
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $request;
    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    private $redirectFactory;
    /**
     * @var \ItCation\CallbackForm\Model\MailInterface
     */
    private $mail;
    /**
     * @var \Magento\Framework\View\Element\Template
     */
    private $template;

    public function __construct(
        Context                                              $context,
        \Magento\Framework\Data\Form\FormKey\Validator       $formKeyValidator,
        \Magento\Framework\App\RequestInterface              $request,
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory,
        \ItCation\CallbackForm\Model\MailInterface           $mail,
        \Magento\Framework\View\Element\Template             $template
    ) {
        parent::__construct($context);
        $this->formKeyValidator = $formKeyValidator;
        $this->request = $request;
        $this->redirectFactory = $redirectFactory;
        $this->mail = $mail;
        $this->template = $template;
    }

    public function execute()
    {
        if (!$this->formKeyValidator->validate($this->request)) {
            $this->messageManager->addErrorMessage(__('Your session has expired'));

            return $this->redirectFactory->create()->setUrl($this->_redirect->getRefererUrl());
        }

        try {
            $this->validateFields();
            $this->sendEmail($this->request->getParams());
            $this->messageManager->addSuccessMessage(__('Message was send'));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $this->redirectFactory->create()->setUrl($this->_redirect->getRefererUrl());
    }

    private function sendEmail($post)
    {
        $telephone = $this->template->escapeHtml($post['telephone'] ?? '');
        $this->mail->send(['data' => new \Magento\Framework\DataObject(['telephone' => $telephone])]);
    }

    protected function validateFields()
    {
        if (trim($this->request->getParam('telephone')) === '') {
            throw new LocalizedException(__('Enter the Message and try again.'));
        }
    }
}
