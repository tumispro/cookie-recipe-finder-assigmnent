<?php

use App\Recipes\CookieRecipe;
use App\Chefs\CookieChef;
use App\Ingredients\CookieIngredient;
use App\Outputters\RecipeOutputter;

require __DIR__ . '/../vendor/autoload.php';

$ingredients = [
    new CookieIngredient(CookieIngredient::TYPE_BUTTERSCOTCH, -1, -2, 6, 3, 8),
    new CookieIngredient(CookieIngredient::TYPE_CINNAMON, 2, 3 , -2 , -1, 3),
];

try {

    $cookieRecipe = new CookieRecipe();
    $optimalRecipe = (new CookieChef($cookieRecipe))
        ->setIngredients($ingredients)
        ->setUnits(100)
        ->setCalories(500)
        ->getOptimalRecipe()
    ;

    $recipeOutputter = new RecipeOutputter($optimalRecipe);
    echo $recipeOutputter->cli();

} catch (Exception $e) {
    echo 'There\'s a problem with your recipe: ' . $e->getMessage();
}
