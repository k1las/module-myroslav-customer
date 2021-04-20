<?php
declare(strict_types=1);

namespace Myroslav\Customer\Controller\Status;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Edit
 */
class Edit implements AccountInterface
{
    /**
     * @var ResultFactory $resultFactory
     */
    private $resultFactory;

    /**
     * AbstractStatus constructor.
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        ResultFactory $resultFactory
    ) {
        $this->resultFactory = $resultFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
