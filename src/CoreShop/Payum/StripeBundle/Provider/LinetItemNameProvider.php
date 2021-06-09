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

use LogicException;
use CoreShop\Component\Core\Model\OrderItemInterface;

class LinetItemNameProvider implements LinetItemNameProviderInterface
{
    public function getItemName(OrderItemInterface $orderItem): string
    {
        $itemName = $orderItem->getName();

        if (null === $itemName || '' === $itemName) {
            throw new LogicException(
                'The line item name is null or empty, please provide an "$orderItem" with a `name` !'
            );
        }

        return sprintf('%sx - %s', $orderItem->getQuantity(), $itemName);
    }
}
