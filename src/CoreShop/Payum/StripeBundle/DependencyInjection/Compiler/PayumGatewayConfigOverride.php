<?php
/*
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

namespace CoreShop\Payum\StripeBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class PayumGatewayConfigOverride implements CompilerPassInterface
{
    /** @var array */
    private $gatewayConfigs;

    public function __construct(array $gatewayConfigs)
    {
        $this->gatewayConfigs = $gatewayConfigs;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        $builder = $container->getDefinition('payum.builder');
        foreach ($this->gatewayConfigs as $gatewayName => $factoryConfig) {
            $builder->addMethodCall('addGatewayFactoryConfig', [$gatewayName, $factoryConfig]);
        }
    }
}
