<?php
declare(strict_types=1);
namespace Myroslav\Customer\Plugin\CustomerData;

use Magento\Customer\CustomerData\Customer;
use Magento\Customer\Helper\Session\CurrentCustomer;

/**
 * Class CustomerStatus
 */
class CustomerStatus
{
    /**
     * @var CurrentCustomer $currentCustomer
     */
    private $currentCustomer;

    /**
     * CustomerStatus constructor.
     * @param CurrentCustomer $currentCustomer
     */
    public function __construct(CurrentCustomer $currentCustomer)
    {
        $this->currentCustomer = $currentCustomer;
    }

    /**
     * @param Customer $subject
     * @param $result
     * @return mixed
     */
    public function afterGetSectionData(Customer $subject, $result)
    {
        $customer = $this->currentCustomer->getCustomer();
        $result['customer_status'] = $customer
            ->getCustomAttribute('customer_status')
            ->getValue();
        return $result;
    }
}
