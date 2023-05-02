<?php
namespace IshTapp\Recommendation\Recommendation;

use IshTapp\Recommendation\Configuration\StandardKey;
use IshTapp\Recommendation\Interfaces\RecommendationInterface;

/**
 * [Base]
 * 
 * 
 */
abstract class Base extends StandardKey implements RecommendationInterface
{

    /**
     * User rated product.
     * @var array
     */
    protected $product = []; 

    /**
     * Product rated by other users. 
     * @var array
     */
    protected $other = []; 
      
   /**
    * Get rated product.
    * @param array $table
    * @param mixed $user
    * 
    * @return [type]
    */
    protected function ratedProduct($table, $user) 
    { 
        foreach($table as $item){
            $item[self::USER_ID] == $user ?  $this->product[] = $item : $this->other[] = $item;   
        }  
    }

   
    /**
     * Get filter rating.
     * Remove product that the user has rated.
     * @param array $data
     * 
     * @return array
     */
    protected function filterRating($data)
    {
        $myRank = $data;  
        $rank = $myRank;  
        for($i = 0; $i < count($myRank); $i++){    
            foreach($this->product as $item){           
                if($item[self::vacancy_id] == key($myRank))
                    unset($rank[key($myRank)]); // remove product
            } 
            next($myRank);
        }  
        arsort($rank);
        return $rank;  
    } 

}