<?php

namespace spec\VictoriaPlum\MoneyMoneyMoney;

class MoneyImmutableSpec extends BulkMoneyParserSpec
{
    protected $initialValue = [];

    protected $output = [];

    function input()
    {
        $this->initialValue =
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
            ];
    }

    /**
     * @param      $priceWithoutTax
     * @param      $priceAdditionWithoutTax
     * @param bool $isPence
     *
     * @return float
     *
     */
    function calculate_price_without_tax(
        $priceWithoutTax,
        $priceAdditionWithoutTax,
        $isPence
    )
    {
        $poundsWithoutTax = bcadd($priceWithoutTax, $priceAdditionWithoutTax, 2);

        if ($isPence) {
            $penceWithoutTax = bcmul($poundsWithoutTax, 100, 2);
            return round($penceWithoutTax, 0);
        }
        return round($poundsWithoutTax, 2);
    }

    /**
     * @param      $priceWithoutTax
     * @param      $priceAdditionWithoutTax
     * @param      $taxRateAdjustment
     * @param bool $isPence
     *
     * @return float
     */
    function calculate_price_with_tax(
        $priceWithoutTax,
        $priceAdditionWithoutTax,
        $taxRateAdjustment,
        $isPence = false
    )
    {
        $poundsWithoutTax = $this->calculate_price_without_tax(
            $priceWithoutTax,
            $priceAdditionWithoutTax,
            $isPence
        );

        $poundsWithTax = bcmul($poundsWithoutTax, bcadd(1, $taxRateAdjustment, 2), 2);

        if ($isPence) {
            $penceWithTax = $poundsWithTax;
            return round($penceWithTax, 0);
        }
        return round($poundsWithTax, 2);
    }

    function process()
    {
        $this->input();

        foreach ($this->initialValue as $value)
        {
            $poundsWithoutTax = $this->calculate_price_without_tax(
                $value['price_without_tax'],
                $value['price_addition_without_tax'],
                false
            );
            $penceWithoutTax = $this->calculate_price_without_tax(
                $value['price_without_tax'],
                $value['price_addition_without_tax'],
                true
            );

            $poundsWithTax = $this->calculate_price_with_tax(
                $value['price_without_tax'],
                $value['price_addition_without_tax'],
                $value['tax_rate_adjustment'],
                false
            );
            $penceWithTax = $this->calculate_price_with_tax(
                $value['price_without_tax'],
                $value['price_addition_without_tax'],
                $value['tax_rate_adjustment'],
                true
            );

            $this->output[] = [
                'item_code'             => $value['item_code'],
                'pence_with_tax'        => $penceWithTax,
                'pence_without_tax'     => $penceWithoutTax,
                'pounds_with_tax'       => $poundsWithTax,
                'pounds_without_tax'    => $poundsWithoutTax,
            ];
        }
    }
}