<?php

function getCategoryImage($categoryName)
{
    if (empty($categoryName)) {
        return 'img/technology.png';
    }
    
    $categoryName = strtolower(trim($categoryName));
    
    $imageMap = [
        'technology' => 'technology.png',
        'tech' => 'technology.png',
        'web' => 'technology.png',
        'development' => 'technology.png',
        'dev' => 'technology.png',
        'arts' => 'arts.png',
        'art' => 'arts.png',
        'craft' => 'arts.png',
        'crafts' => 'arts.png',
        'music' => 'music.png',
        'guitar' => 'guitar.png',
        'sports' => 'sports.png',
        'sport' => 'sports.png',
        'academic' => 'Academic.png',
        'academics' => 'Academic.png',
        'languages' => 'english.jpg',
        'language' => 'english.jpg',
        'english' => 'english.jpg'
    ];
    
    foreach ($imageMap as $key => $image) {
        if (strpos($categoryName, $key) !== false) {
            return 'img/' . $image;
        }
    }
    
    return 'img/technology.png';
}

function getUserAvatar($userName)
{
    $initials = strtoupper(substr($userName, 0, 2));
    return $initials;
}

