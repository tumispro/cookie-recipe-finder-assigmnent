<?php

namespace App\Outputters;

use App\Ingredients\Interfaces\Ingredient;
use App\Recipes\Interfaces\Recipe;

final class RecipeOutputter
{

    protected Recipe $recipe;

    public function __construct(Recipe $recipe) {
        $this->recipe = $recipe;
    }

    public function cli(): string {

        $ingredients = array_map(function(Ingredient $ingredient) {
            return $this->generateLine("{$ingredient->getName()}: {$ingredient->getQuantity()} {$ingredient->getUnit()}");
        }, $this->recipe->getIngredientBag());

        $lines = implode(PHP_EOL, array_merge([
            $this->generateLine("Score: {$this->recipe->getScore()}"),
            $this->generateLine("Calories: {$this->recipe->getCalories()}"),
            $this->generateLine(''),
        ], [
           $this->generateLine('Ingredients:'),
           $this->generateLine(''),
        ], $ingredients));

        return <<<EOL
        ------= Cookie Recipe =------
        |                           |
        $lines
        |___________________________|
        EOL;
    }

    private function generateLine($text): string {
        return '|  ' . str_pad($text, 25) . '|';
    }

}
