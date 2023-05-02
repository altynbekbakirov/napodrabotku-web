<?php
namespace IshTapp\Recommendation\Factories;

use IshTapp\Recommendation\Creator\RecommendationCreator;
use IshTapp\Recommendation\Interfaces\RecommendationInterface;

class RecommendationFactory extends RecommendationCreator
{
    /**
     * @param RecommendationInterface $col
     * @param array $table
     * @param mixed $user
     * @param mixed $score
     * 
     * @return [type]
     */
    protected function factoryMethod(RecommendationInterface $col, $table, $user, $score)
    {
      return $col->recommend($table, $user, $score);
    }
}