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

final class LineItemsProvider implements LineItemsProviderInterface
{
    /** @var LineItemProviderInterface */
    private $lineItemProvider;

    /** @var ShippingLineItemProviderInterface */
    private $shippingLineItemProvider;

    public function __construct(
        LineItemProviderInterface $lineItemProvider,
        ShippingLineItemProviderInterface $shippingLineItemProvider
    ) {
        $this->lineItemProvider = $lineItemProvider;
        $this->shippingLineItemProvider = $shippingLineItemProvider;
    }

    public function getLineItems(OrderInterface $order): ?array
    {
        $lineItems = [];
        foreach ($order->getItems() as $orderItem) {
            $lineItem = $this->lineItemProvider->getLineItem($orderItem);
            if (null !== $lineItem) {
                $lineItems[] = $lineItem;
            }
        }

        $lineItem = $this->shippingLineItemProvider->getLineItem($order);
        if (null !== $lineItem) {
            $lineItems[] = $lineItem;
        }

        return $lineItems;
    }
}
