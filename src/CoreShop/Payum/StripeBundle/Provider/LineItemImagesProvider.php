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

use CoreShop\Component\Core\Model\OrderItemInterface;
use CoreShop\Component\Core\Model\ProductInterface;
use Pimcore\Model\Asset\Image;
use Pimcore\Tool;

final class LineItemImagesProvider implements LineItemImagesProviderInterface
{
    /** @var string */
    private $thumbnailName;

    /** @var string */
    private $fallbackImage;

    public function __construct(
        string $thumbnailName,
        string $fallbackImage
    ) {
        $this->thumbnailName = $thumbnailName;
        $this->fallbackImage = $fallbackImage;
    }

    public function getImageUrls(OrderItemInterface $orderItem): array
    {
        $product = $orderItem->getProduct();

        if (!$product instanceof ProductInterface) {
            return [];
        }
        
        return [
            $this->getImageUrlFromProduct($product),
        ];
    }

    public function getImageUrlFromProduct(ProductInterface $product): string
    {
        $path = $this->fallbackImage;

        if (null !== $image = $product->getImage()) {
            /** @var Image $image */
            $imageThumbnail = $image->getThumbnail($this->thumbnailName);
            $path = Tool::getHostUrl() . $imageThumbnail->getPath();
        }

        return $this->getUrlFromPath($path);
    }

    private function getUrlFromPath(string $path): string
    {
        // Relative images are not displayed by Stripe because they cache it on a CDN
        if(null === parse_url($path, PHP_URL_SCHEME)) {
            $path = $this->fallbackImage;
        }

        return $path;
    }
}
