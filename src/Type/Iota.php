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

namespace IOTA\Type;

use IOTA\SerializeInterface;

/**
 * Class Iota.
 *
 * A value object to handle iota units and calculation with big numbers.
 */
class Iota implements SerializeInterface
{
    public const UNIT_IOTA = '1';
    public const UNIT_KILO = '1000';
    public const UNIT_MEGA = '1000000';
    public const UNIT_GIGA = '1000000000';
    public const UNIT_TERA = '1000000000000';
    public const UNIT_PETA = '1000000000000000';

    public const IOTA_MAX = '2779530283277761';

    /**
     * The amount of iota (smallest unit).
     *
     * @var string
     */
    private $amount;

    /**
     * Iota constructor.
     *
     * @param int|string $amount
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($amount)
    {
        if (\gmp_cmp(self::IOTA_MAX, (string) $amount) < 0) {
            throw new \InvalidArgumentException(
                'Impossible iota amount given. The maximum supply is '.self::IOTA_MAX
            );
        }

        $this->amount = (string) $amount;
    }

    /**
     * toString implementation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->amount;
    }

    /**
     * Gets the iota amount as a string.
     *use IOTA\Base\Cryptography\Kerl;.
     *
     * @return string
     */
    public function getAmount(): string
    {
        return $this->__toString();
    }

    /**
     * Adds the given amount to the current amount.
     *
     * @param Iota $iota
     *
     * @throws \InvalidArgumentException
     *
     * @return Iota
     */
    public function plus(self $iota): self
    {
        return new self(\gmp_add($this->amount, $iota->getAmount()));
    }

    /**
     * Subtracts the given iota amount from the current amount.
     *
     * @param Iota $iota
     *
     * @throws \InvalidArgumentException
     *
     * @return Iota
     */
    public function minus(self $iota): self
    {
        return new self(\gmp_sub($this->amount, $iota->getAmount()));
    }

    /**
     * Multiplies the current iota amount with the given amount.
     *
     * @param int|string $multiplier
     *
     * @throws \InvalidArgumentException
     *
     * @return Iota
     */
    public function multiplyBy($multiplier): self
    {
        return new self(\gmp_mul($this->amount, (string) $multiplier));
    }

    /**
     * Divides the current iota value and returns a new one.
     *
     * @param int|string $divisor
     *
     * @throws \InvalidArgumentException
     *
     * @return Iota
     */
    public function divideBy($divisor): self
    {
        return new self(\gmp_div_q($this->amount, (string) $divisor));
    }

    /**
     * Gets the Kilo Iota amount.
     *
     * @return string
     */
    public function getKiloIota(): string
    {
        return \gmp_div_q($this->amount, self::UNIT_KILO, 15);
    }

    /**
     * Gets the Mega Iota amount.
     *
     * @return string
     */
    public function getMegaIota(): string
    {
        return \gmp_div_q($this->amount, self::UNIT_MEGA, 15);
    }

    /**
     * Gets the Giga Iota amount.
     *
     * @return string
     */
    public function getGigaIota(): string
    {
        return \gmp_div_q($this->amount, self::UNIT_GIGA, 15);
    }

    /**
     * Gets the Tera Iota amount.
     *
     * @return string
     */
    public function getTeraIota(): string
    {
        return \gmp_div_q($this->amount, self::UNIT_TERA, 15);
    }

    /**
     * Gets the Peta Iota amount.
     *
     * @return string
     */
    public function getPetaIota(): string
    {
        return \gmp_div_q($this->amount, self::UNIT_PETA, 15);
    }

    /**
     * @param string $petaIota
     *
     * @throws \InvalidArgumentException
     *
     * @return Iota
     */
    public static function fromPetaIota(string $petaIota): self
    {
        return new self(\gmp_mul($petaIota, self::UNIT_PETA));
    }

    /**
     * @param string $teraIota
     *
     * @throws \InvalidArgumentException
     *
     * @return Iota
     */
    public static function fromTeraIota(string $teraIota): self
    {
        return new self(\gmp_mul($teraIota, self::UNIT_TERA));
    }

    /**
     * @param string $gigaIota
     *
     * @throws \InvalidArgumentException
     *
     * @return Iota
     */
    public static function fromGigaIota(string $gigaIota): self
    {
        return new self(\gmp_mul($gigaIota, self::UNIT_GIGA));
    }

    /**
     * @param string $megaIota
     *
     * @throws \InvalidArgumentException
     *
     * @return Iota
     */
    public static function fromMegaIota(string $megaIota): self
    {
        return new self(\gmp_mul($megaIota, self::UNIT_MEGA));
    }

    /**
     * @param string $kiloIota
     *
     * @throws \InvalidArgumentException
     *
     * @return Iota
     */
    public static function fromKiloIota(string $kiloIota): self
    {
        return new self(\gmp_mul($kiloIota, self::UNIT_KILO));
    }

    /**
     * Gets a value indicating whether the given Iota value is lower than
     * the current value.
     *
     * @param Iota $value
     *
     * @return bool
     */
    public function lt(self $value): bool
    {
        return \gmp_cmp($this->getAmount(), $value->getAmount()) < 0;
    }

    /**
     * Gets a value indicating whether the given Iota value is greater than
     * the current value.
     *
     * @param Iota $value
     *
     * @return bool
     */
    public function gt(self $value): bool
    {
        return \gmp_cmp($this->getAmount(), $value->getAmount()) > 0;
    }

    /**
     * Gets a value indicating whether the given Iota value is greater than or
     * equal the current value.
     *
     * @param Iota $value
     *
     * @return bool
     */
    public function gteq(self $value): bool
    {
        return \gmp_cmp($this->getAmount(), $value->getAmount()) >= 0;
    }

    /**
     * Gets a value indicating whether the given Iota value is lower than or
     * equal the current value.
     *
     * @param Iota $value
     *
     * @return bool
     */
    public function lteq(self $value): bool
    {
        return \gmp_cmp($this->getAmount(), $value->getAmount()) <= 0;
    }

    /**
     * Gets a value indicating whether the given Iota value equals the current
     * value.
     *
     * @param Iota $value
     *
     * @return bool
     */
    public function eq(self $value): bool
    {
        return 0 === \gmp_cmp($this->getAmount(), $value->getAmount());
    }

    /**
     * Gets a value indicating whether the given Iota value does not equal the
     * current value.
     *
     * @param Iota $value
     *
     * @return bool
     */
    public function neq(self $value): bool
    {
        return 0 !== \gmp_cmp($this->getAmount(), $value->getAmount());
    }

    /**
     * Gets a 0 Iota instance.
     *
     * @throws \InvalidArgumentException
     *
     * @return Iota
     */
    public static function ZERO(): self
    {
        return new self(0);
    }

    /**
     * Gets a value indicating whether the value is negative.
     *
     * @return bool
     */
    public function isNeg(): bool
    {
        return $this->lt(self::ZERO());
    }

    /**
     * Gets a value indicating whether the value is positive.
     *
     * @return bool
     */
    public function isPos(): bool
    {
        return $this->gt(self::ZERO());
    }

    /**
     * Gets a value indicating whether the value equals 0.
     *
     * @return bool
     */
    public function isZero(): bool
    {
        return $this->eq(self::ZERO());
    }

    /**
     * Gets the string representation.
     *
     * @return string
     */
    public function serialize(): string
    {
        return $this->__toString();
    }
}
