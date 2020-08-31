<?php

class ReviewScore {

    public static function score() {
        $title = array("Graphics","Story", "Level Design", "Engine");
        $title = $title[array_rand($title)];
        $score = rand(1,10);
        return "{\"title\": \"$title\", \"score\": $score}";

    }

    public static function scores(int $count){
        $result = '[';
        for($i=0; $i < $count; $i++)
        {
            $result .= ReviewScore::score() . ',';
        }
        $result = rtrim($result, ",");
        $result .=']';
        return $result;
    }

}
