<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2020 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

declare(strict_types=1);

namespace CoreShop\Payum\StripeBundle;

use CoreShop\Payum\StripeBundle\DependencyInjection\Compiler\PayumGatewayConfigOverride;
use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class StripeBundle extends AbstractPimcoreBundle
{
    use PackageVersionTrait;

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new PayumGatewayConfigOverride([
            'stripe_js' => [
                'payum.template.layout' => '@CoreShopPayum/layout.html.twig',
            ],
        ]));

        parent::build($container);
    }

    /**
     * @inheritDoc
     */
    protected function getComposerPackageName(): string
    {
        return 'coreshop/payum-stripe-bundle';
    }
}
