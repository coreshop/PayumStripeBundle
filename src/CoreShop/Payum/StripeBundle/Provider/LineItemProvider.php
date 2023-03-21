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
use CoreShop\Component\Core\Model\OrderItemInterface;
use CoreShop\Component\Order\Model\AdjustmentInterface;

final class LineItemProvider implements LineItemProviderInterface
{
    /** @var LineItemImagesProviderInterface */
    private $lineItemImagesProvider;

    /** @var LinetItemNameProviderInterface */
    private $lineItemNameProvider;

    public function __construct(
        LineItemImagesProviderInterface $lineItemImagesProvider,
        LinetItemNameProviderInterface $lineItemNameProvider
    ) {
        $this->lineItemImagesProvider = $lineItemImagesProvider;
        $this->lineItemNameProvider = $lineItemNameProvider;
    }

    public function getLineItem(OrderItemInterface $orderItem): ?array
    {
        /** @var OrderInterface|null $order */
        $order = $orderItem->getOrder();

        if (null === $order) {
            return null;
        }

        $itemAmount = $this->getLineItemAmount($orderItem);

        if ($itemAmount < 1) {
            return null;
        }

        return [
            'quantity' => 1,
            'price_data' => [
                'currency' => $order->getCurrency()->getIsoCode(),
                'unit_amount' => $itemAmount,
                'product_data' => [
                    'name' => $this->lineItemNameProvider->getItemName($orderItem),
                    'images' => $this->lineItemImagesProvider->getImageUrls($orderItem),
                ],
            ],
        ];
    }

    private function getLineItemAmount(OrderItemInterface $orderItem): int
    {
        $totalCartPriceRuleAdjustments = 0;
        foreach ($orderItem->getAdjustments(AdjustmentInterface::CART_PRICE_RULE) as $adjustment) {
            if ($adjustment->getNeutral()) {
                $totalCartPriceRuleAdjustments += $adjustment->getAmount();
            }
        }

        return $orderItem->getTotal() + $totalCartPriceRuleAdjustments;
    }
}
