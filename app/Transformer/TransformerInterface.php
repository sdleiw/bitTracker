<?php

namespace App\Transformer;

use App\Struct\BalanceInterface;

/**
 * Interface TransformerInterface
 * @package App\Transformer
 */
interface TransformerInterface
{
    /**
     * @param array $prices
     * @return BalanceInterface
     */
    public function transform(array $prices): BalanceInterface;
}
