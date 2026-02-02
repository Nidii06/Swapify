<?php

function getCategoryImage($categoryName)
{
    if (empty($categoryName)) {
        return 'img/technology.png';
    }
    
    $categoryName = strtolower(trim($categoryName));
    
    $imageMap = [
        'technology' => 'technology.png',
        'arts' => 'arts.png',
        'music' => 'music.png',
        'sports' => 'sports.png',
        'academic' => 'Academic.png',
        'languages' => 'languages.png',
        'business' => 'business.png',
        'cooking' => 'cooking.png',
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

