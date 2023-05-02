<?php
namespace IshTapp\Recommendation;

use IshTapp\Training\EuclideanRecommendation;
use IshTapp\Training\RankingRecommendation;
use IshTapp\Training\SlopeOneRecommendation;
use IshTapp\Interference\RecommendationFactory; 

/**
 * [class Recommend]
 * 
 * @package recommendation
 *  
 */
class Recommend
{

   protected $method;

   public function __construct()
   {
       $this->method = new RecommendationFactory();
   }

   /**
    * Get ranking | Recommendation filtering algorithm.
    * @param array $table
    * @param mixed $user
    * @param mixed $score
    *
    * @return array
    */
   public function train_ranking($table, $user, $score = 0)
   { 
      return $this->method->doFactory(new RankingRecommendation(), $table, $user, $score);   
   }

   /**
    * Get euclidean | Recommendation filtering algorithm.
    * @param array $table
    * @param mixed $user
    * @param mixed $score
    * 
    * @return array
    */
   public function train_euclidean($table, $user, $score = 0)
   { 
      return $this->method->doFactory(new EuclideanRecommendation(), $table, $user, $score);   
   }

   /**
    * Get slope one | Recommendation filtering algorithm.
    * @param array $table
    * @param mixed $user
    * @param mixed $score
    * 
    * @return [type]
    */
   public function train_slopeOne($table, $user, $score = 0)
   {
      return $this->method->doFactory(new SlopeOneRecommendation(), $table, $user, $score);
   }

}