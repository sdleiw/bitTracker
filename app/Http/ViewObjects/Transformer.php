<?php

namespace App\Http\ViewObjects;

use App\Transformer\TransformerInterface;

/**
 * Class Transformer
 * @package App\Http\ViewObjects
 */
class Transformer
{
    /** @var array $transformers */
    public $transformers;

    public function __construct()
    {
        $this->init();
    }

    /**
     * init
     */
    protected function init(): void
    {
        foreach ($this->activeTransformers() as $transformer) {
            $this->addTransformers(app($transformer));
        }
    }

    /**
     * @param TransformerInterface $transformer
     */
    protected function addTransformers(TransformerInterface $transformer): void
    {
        $this->transformers[] = $transformer;
    }

    /**
     * @todo: add active flag in the config or env
     * @return array
     */
    protected function activeTransformers(): array
    {
        return [
            \App\Transformer\Binance::class,
            \App\Transformer\Bitfinex::class,
            \App\Transformer\HitBtc::class,
        ];
    }
}
