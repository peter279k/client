<?php
/**
 * This file is part of the IOTA PHP package.
 *
 * (c) Benjamin Ansbach <benjaminansbach@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Techworker\IOTA\ClientApi\Actions\GetNewAddress;

use Techworker\IOTA\Node;
use Techworker\IOTA\Type\SecurityLevel;
use Techworker\IOTA\Type\Seed;

/**
 * Replays a transfer by doing Proof of Work again.
 */
trait ActionTrait
{
    /**
     * The action factory.
     *
     * @var ActionFactory
     */
    private $getNewAddressFactory;

    /**
     * @param ActionFactory $getNewAddressFactory
     *
     * @return ActionTrait
     */
    protected function setGetNewAddressFactory(ActionFactory $getNewAddressFactory): self
    {
        $this->getNewAddressFactory = $getNewAddressFactory;

        return $this;
    }

    /** @noinspection MoreThanThreeArgumentsInspection */
    /**
     * @param Node               $node
     * @param Seed               $seed
     * @param int                $startIndex
     * @param bool               $addChecksum
     * @param SecurityLevel|null $security
     *
     * @return Result
     */
    protected function getNewAddress(
        Node $node,
                                     Seed $seed,
                                     int $startIndex = 0,
                                     bool $addChecksum = false,
                                     SecurityLevel $security = null
    ): Result {
        $action = $this->getNewAddressFactory->factory($node);
        $action->setSeed($seed);
        $action->setStartIndex($startIndex);
        $action->setAddChecksum($addChecksum);
        if (null !== $security) {
            $action->setSecurity($security);
        }

        return $action->execute();
    }
}