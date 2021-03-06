<?php

declare(strict_types=1);

/*
 * This file is part of the IOTA PHP package.
 *
 * (c) Benjamin Ansbach <benjaminansbach@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IOTA\ClientApi\Actions\StoreAndBroadcast;

use IOTA\AbstractFactory;
use IOTA\ClientApi\FactoryInterface;
use IOTA\Node;
use IOTA\RemoteApi\Actions\BroadcastTransactions;
use IOTA\RemoteApi\Actions\StoreTransactions;

/**
 * Class ActionFactory.
 *
 * Creates a new Action instance.
 */
class ActionFactory extends AbstractFactory implements FactoryInterface
{
    /**
     * Creates a new action instance.
     *
     * @param Node $node
     *
     * @return Action
     */
    public function factory(Node $node): Action
    {
        return new Action(
            $node,
            $this->container->get(StoreTransactions\ActionFactory::class),
            $this->container->get(BroadcastTransactions\ActionFactory::class)
        );
    }
}
