<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2021 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

declare(strict_types=1);

namespace CoreShop\Payum\StripeBundle\Provider;

use CoreShop\Component\Core\Model\OrderInterface;

final class DetailsProvider implements DetailsProviderInterface
{
    /** @var CustomerEmailProviderInterface */
    private $customerEmailProvider;

    /** @var LineItemsProviderInterface */
    private $lineItemsProvider;

    /** @var PaymentMethodTypesProviderInterface */
    private $paymentMethodTypesProvider;

    /** @var LocaleProviderInterface */
    private $localeProvider;

    public function __construct(
        CustomerEmailProviderInterface $customerEmailProvider,
        LineItemsProviderInterface $lineItemsProvider,
        PaymentMethodTypesProviderInterface $paymentMethodTypesProvider,
        LocaleProviderInterface $localeProvider
    ) {
        $this->customerEmailProvider = $customerEmailProvider;
        $this->paymentMethodTypesProvider = $paymentMethodTypesProvider;
        $this->lineItemsProvider = $lineItemsProvider;
        $this->localeProvider = $localeProvider;
    }

    public function getDetails(OrderInterface $order): array
    {
        $details = [];

        $customerEmail = $this->customerEmailProvider->getCustomerEmail($order);
        if (null !== $customerEmail) {
            $details['customer_email'] = $customerEmail;
        }

        $lineItems = $this->lineItemsProvider->getLineItems($order);
        if (null !== $lineItems) {
            $details['line_items'] = $lineItems;
            $details['mode'] = 'payment';
        }

        $details['payment_method_types'] = $this->paymentMethodTypesProvider->getPaymentMethodTypes($order);

        $locale = $this->localeProvider->getLocale($order);
        if (null !== $locale) {
            $details['locale'] = $locale;
        }

        return $details;
    }
}
