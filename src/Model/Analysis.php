<?php

declare(strict_types=1);

namespace App\Model;

use Phpml\Classification\NaiveBayes;

final class Analysis
{
    protected NaiveBayes $classifier;

    public function __construct()
    {
        $this->classifier = new NaiveBayes();
    }

    public function train(array $samples, array $labels): void
    {
        $this->classifier->train($samples, $labels);
    }

    public function predict(array $samples)
    {
        return $this->classifier->predict($samples);
    }
}
