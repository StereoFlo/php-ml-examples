<?php

declare(strict_types=1);

namespace App\Model;

use Phpml\CrossValidation\StratifiedRandomSplit;
use Phpml\Dataset\ArrayDataset;
use Phpml\Dataset\CsvDataset;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Metric\Accuracy;
use Phpml\Tokenization\WordTokenizer;

final class Classify
{
    public function getScore(): float
    {
        $dataset = new CsvDataset('/Users/evgen/Downloads/fann/data.csv', 1);
        $samples = $this->getSamples($dataset);

        $this->transformVictorizer($samples);

        $this->transformTfIdf($samples);

        $dataset = new ArrayDataset($samples, $dataset->getTargets());

        $anal = new Analysis();
        $randomSplit = new StratifiedRandomSplit($dataset, 0.1);
        $anal->train($randomSplit->getTrainSamples(), $randomSplit->getTrainLabels());

        $testSamples = $randomSplit->getTestSamples();
        $testLabels = $randomSplit->getTestLabels();
        $predictedLabels = $anal->predict($testSamples);

        return (float) Accuracy::score($testLabels, $predictedLabels);
    }

    public function getSearch(array $words)
    {
        $dataset = new CsvDataset('/Users/evgen/Downloads/fann/data.csv', 1);
        $samples = $this->getSamples($dataset);
        $dataset = new ArrayDataset($samples, $dataset->getTargets());

        $anal = new Analysis();

        return $anal->predict($words);
    }

    private function getSamples(CsvDataset $dataset): array
    {
        $samples = [];

        foreach ($dataset->getSamples() as $sample) {
            if (empty($sample[0])) {
                continue;
            }
            $samples[] = $sample[0];
        }

        return $samples;
    }

    private function transformVictorizer(array &$samples): void
    {
        $vectorizer = new TokenCountVectorizer(new WordTokenizer());

        $vectorizer->fit($samples);
        $vectorizer->transform($samples);
    }

    private function transformTfIdf(array &$samples): void
    {
        $tfIdfTransformer = new TfIdfTransformer();

        $tfIdfTransformer->fit($samples);
        $tfIdfTransformer->transform($samples);
    }
}
