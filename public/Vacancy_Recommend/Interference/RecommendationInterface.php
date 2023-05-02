<?php
namespace IshTapp\Recommendation\Interfaces;

interface RecommendationInterface
{
   
    public function recommend($table, $user, $score = 0);
    
}