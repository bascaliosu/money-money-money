<?php

namespace spec\VictoriaPlum\MoneyMoneyMoney;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BulkMoneyParserSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            [
                [
                    'item_code' => 'TAP135',
                    'price_without_tax' => 12.87,
                    'price_addition_without_tax' => 3.67,
                    'tax_rate_adjustment' => 0.34
                ],
                [
                    'item_code' => 'BATH123',
                    'price_without_tax' => 256.78,
                    'price_addition_without_tax' => 30.12,
                    'tax_rate_adjustment' => 0.27
                ],
                [
                    'item_code' => 'BASIN678',
                    'price_without_tax' => 89.99,
                    'price_addition_without_tax' => 20.00,
                    'tax_rate_adjustment' => 0.50
                ],
                [
                    'item_code' => 'SHOWER897',
                    'price_without_tax' => 200.00,
                    'price_addition_without_tax' => 12.50,
                    'tax_rate_adjustment' => 0.02
                ],
                [
                    'item_code' => 'TOILET321',
                    'price_without_tax' => 95.00,
                    'price_addition_without_tax' => 7.80,
                    'tax_rate_adjustment' => 0.05
                ]
            ]
        );
    }

    function it_can_output_prices_for_a_batch_of_products()
    {
        $this->process()->shouldReturn(
            [
                [
                    'item_code' => 'TAP135',
                    'pence_with_tax' => 2216,
                    'pence_without_tax' => 1654,
                    'pounds_with_tax' => 22.16,
                    'pounds_without_tax' => 16.54,
                ],
                [
                    'item_code' => 'BATH123',
                    'pence_with_tax' => 36436,
                    'pence_without_tax' => 28690,
                    'pounds_with_tax' => 364.36,
                    'pounds_without_tax' => 286.9,
                ],
                [
                    'item_code' => 'BASIN678',
                    'pence_with_tax' => 16499,
                    'pence_without_tax' => 10999,
                    'pounds_with_tax' => 164.99,
                    'pounds_without_tax' => 109.99,
                ],
                [
                    'item_code' => 'SHOWER897',
                    'pence_with_tax' => 21675,
                    'pence_without_tax' => 21250,
                    'pounds_with_tax' => 216.75,
                    'pounds_without_tax' => 212.5,
                ],
                [
                    'item_code' => 'TOILET321',
                    'pence_with_tax' => 10794,
                    'pence_without_tax' => 10280,
                    'pounds_with_tax' => 107.94,
                    'pounds_without_tax' => 102.8,
                ]
            ]
        );
    }
}