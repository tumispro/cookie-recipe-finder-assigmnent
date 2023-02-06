<?php

use App\Recipes\CookieRecipe;
use App\Chefs\CookieChef;
use App\Ingredients\CookieIngredient;
use App\Outputters\RecipeOutputter;

require __DIR__ . '/../vendor/autoload.php';

$ingredients = [
    new CookieIngredient(CookieIngredient::TYPE_SPRINKLES, 2, 0 , -2 , 0, 3),
    new CookieIngredient(CookieIngredient::TYPE_BUTTERSCOTCH, 0, 5, -3, 0, 3),
    new CookieIngredient(CookieIngredient::TYPE_CHOCOLATE, 0, 0 , 5 , -1, 8),
    new CookieIngredient(CookieIngredient::TYPE_CANDY, 0, -1, 0, 5, 8),
];

try {

    $cookieRecipe = new CookieRecipe();
    $optimalRecipe = (new CookieChef($cookieRecipe))
        ->setIngredients($ingredients)
        ->setUnits(100)
        ->getOptimalRecipe()
    ;

    $recipeOutputter = new RecipeOutputter($optimalRecipe);
    echo $recipeOutputter->cli();

} catch (Exception $e) {
    echo 'There\'s a problem with your recipe: ' . $e->getMessage();
}
