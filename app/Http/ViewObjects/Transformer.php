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

    /**
     * Transformer constructor.
     */
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
     * @return array
     */
    protected function activeTransformers(): array
    {
        $activeTransformers = [];
        $config = config('api');
        foreach ($config as $name => $platform) {
            if ($platform['active'] && $platform['api-key'] && $platform['api-secret']) {
                $activeTransformers[] = $platform['transformer'];
            }
        }

        return $activeTransformers;
    }
}
