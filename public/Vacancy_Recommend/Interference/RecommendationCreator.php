<?php
namespace IshTapp\Recommendation\Creator;

use IshTapp\Recommendation\Interfaces\RecommendationInterface;

abstract class RecommendationCreator
{
    
 /**
  * @param RecommendationInterface $col
  * @param array $table
  * @param mixed $user
  * @param mixed $score
  * 
  * @return [type]
  */
    protected abstract function factoryMethod(RecommendationInterface $col, $table, $user, $score);

    /**
     * @param RecommendationInterface $method
     * @param array $table
     * @param mixed $user
     * @param mixed $score
     * 
     * @return [type]
     */
    public function doFactory($method, $table, $user, $score)
    {
       return $this->factoryMethod($method, $table, $user, $score); 
    }

}