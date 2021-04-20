<?php

declare(strict_types=1);

namespace Myroslav\Customer\Controller\Status;

use Exception;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Controller\AccountInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Message\ManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class EditPost
 */
class EditPost implements AccountInterface
{
    /**
     * @var ResultFactory $resultFactory
     */
    private $resultFactory;
    /**
     * @var Validator $validator
     */
    private $validator;
    /**
     * @var RequestInterface $request
     */
    private $request;
    /**
     * @var CustomerRepositoryInterface $customerRepository
     */
    private $customerRepository;
    /**
     * @var Session $session
     */
    private $session;
    /**
     * @var ManagerInterface $messageManager
     */
    private $messageManager;
    /**
     * @var LoggerInterface $logger
     */
    private $logger;

    /**
     * EditPost constructor.
     * @param ResultFactory $resultFactory
     * @param Validator $validator
     * @param RequestInterface $request
     * @param CustomerRepositoryInterface $customerRepository
     * @param Session $session
     * @param ManagerInterface $messageManager
     * @param LoggerInterface $logger
     */
    public function __construct(
        ResultFactory $resultFactory,
        Validator $validator,
        RequestInterface $request,
        CustomerRepositoryInterface $customerRepository,
        Session $session,
        ManagerInterface $messageManager,
        LoggerInterface $logger
    ) {
        $this->resultFactory = $resultFactory;
        $this->validator = $validator;
        $this->request = $request;
        $this->customerRepository = $customerRepository;
        $this->session = $session;
        $this->messageManager = $messageManager;
        $this->logger = $logger;
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $validFormKey = $this->validator->validate($this->request);

        if ($validFormKey && $this->request->isPost()) {
            $customerStatus = $this->request->getParam('customer_status');
            if ($customerStatus) {
                try {
                    $customer = $this->customerRepository->getById($this->session->getCustomerId());
                    $customer->setCustomAttribute('customer_status', $customerStatus);
                    $this->customerRepository->save($customer);
                    $this->messageManager->addSuccessMessage(__('Status was saved.'));
                } catch (Exception $exception) {
                    $this->messageManager->addErrorMessage(__('Something went wrong.'));
                    $this->logger->critical($exception);
                }
            }
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('myroslav_customer/status/edit');
    }
}
