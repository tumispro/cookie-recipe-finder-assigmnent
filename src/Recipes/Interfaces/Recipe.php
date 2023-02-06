<?php

namespace App\Recipes\Interfaces;

use App\Ingredients\Interfaces\Ingredient;

interface Recipe
{

    public function addUnit(Ingredient $ingredient): void;

    public function removeUnit(Ingredient $ingredient): void;

    public function getScoreForPotentialIngredient(Ingredient $ingredient, int $offset = 0): int;

    public function getScore(int $offset = 0): int;

    public function getAddedUnits(): int;

    public function getCalories(): int;

    public function getIngredientBag(): array;

}
