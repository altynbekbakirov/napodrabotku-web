<?php
namespace IshTapp\Recommendation\Recommendation;

use IshTapp\Recommendation\Recommendation\Base;
  
/**
 * Recommendation filtering [recommendation algorithm RankingRecommendation].
 * The algorithm checks for similar ratings compared to other users,
 * and adds a weight score and generate a rating for each product.
 * Example: user1 liked [A, B, C, D] and user2 liked [A, B] 
 * recommend product [C, D] to user2 (product score = [C = 2 ; D = 2]).  
 * 
 * 
 */
class RankingRecommendation extends Base
{
     
    /**
     * Get Recommend.  
     * @param array $table
     * @param mixed $user
     * @param mixed $score
     * 
     * @return array
     */
    public function recommend($table, $user, $score = 0)
    {  
        $data = $this->addRating($table, $user, $score);
        return $this->filterRating($data);     
    }

    /**
     * Find similar users (Add weight score).
     * @param array $table
     * @param mixed $user
     * 
     * @return array
     */ 
    private function similarUser($table, $user)
    {
        $this->ratedProduct($table, $user); //get [product, other]    
        $similar = []; //get users with similar tastes
        $rank = [];
        foreach($this->product as $myProduct){
            foreach($this->other as $item){ 
               if($myProduct[self::vacancy_id] == $item[self::vacancy_id]){
                   if($myProduct[self::SCORE] == $item[self::SCORE]){
                      if(!isset($similar[$item[self::USER_ID]])) 
                          $similar[$item[self::USER_ID]] = 0; //
                      $similar[$item[self::USER_ID]] += 1; //assigning weight     
                   }     
               }
            }
        }
        return $similar;  
    }

   
    /**
     * Add Rating | Add a score (+value) for each recommended product.
     * @param array $table
     * @param mixed $user
     * @param mixed $score
     * 
     * @return array
     */
    private function addRating($table, $user, $score) 
    {
        $similar =  $this->similarUser($table, $user);
        $rank = [];
        foreach($this->other as $item){
            foreach($similar as $value){
               if($item[self::USER_ID] == key($similar) && $item[self::SCORE] > $score){
                   if(!isset($rank[$item[self::vacancy_id]]) )
                       $rank[$item[self::vacancy_id]] = 0; //assign value for calculation
                   $rank[$item[self::vacancy_id]] += $value; //add   
               }
               next($similar);
            }
            reset($similar);     
        }
        return $rank;
    }

}
