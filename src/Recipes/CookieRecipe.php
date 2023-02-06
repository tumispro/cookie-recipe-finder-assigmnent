<?php

namespace App\Recipes;

use App\Ingredients\Interfaces\Ingredient;
use App\Recipes\Interfaces\Recipe;

final class CookieRecipe implements Recipe
{

    /* @var array<string, Ingredient> */
    protected array $ingredientBag = [];

    /* @throws \Exception */
    public function getScoreForPotentialIngredient(Ingredient $ingredient, int $offset = 0): int {

        $this->addUnit($ingredient);
        $score = $this->getScore($offset);
        $this->removeUnit($ingredient);

        return $score;
    }

    /**
     * Calculates the score
     *
     * @param int $offset Calculate from a fictional offset
     * @return int
     */
    public function getScore(int $offset = 0): int {
        $capacity = array_reduce($this->ingredientBag, function(int $total, Ingredient $ingredient) {
            return $total + $ingredient->getCapacity() * $ingredient->getQuantity();
        }, 0);
        $durability = array_reduce($this->ingredientBag, function(int $total, Ingredient $ingredient) {
            return $total + $ingredient->getDurability() * $ingredient->getQuantity();
        }, 0);
        $flavor = array_reduce($this->ingredientBag, function(int $total, Ingredient $ingredient) {
            return $total + $ingredient->getFlavor() * $ingredient->getQuantity();
        }, 0);
        $texture = array_reduce($this->ingredientBag, function(int $total, Ingredient $ingredient) {
            return $total + $ingredient->getTexture() * $ingredient->getQuantity();
        }, 0);

        return
            max(0, $capacity + $offset) *
            max(0, $durability + $offset) *
            max(0, $flavor + $offset) *
            max(0, $texture + $offset)
        ;
    }

    public function getAddedUnits(): int {
        return array_reduce($this->ingredientBag, function(int $teaspoons, Ingredient $ingredient) {
            return $teaspoons + $ingredient->getQuantity();
        }, 0);
    }

    public function getCalories(): int {
        return array_reduce($this->ingredientBag, function(int $calories, Ingredient $ingredient) {
            return $calories + $ingredient->getCalories() * $ingredient->getQuantity();
        }, 0);
    }

    /* @return Ingredient[] */
    public function getIngredientBag(): array {
        return $this->ingredientBag;
    }

    public function addUnit(Ingredient $ingredient): void
    {
        if (!isset($this->ingredientBag[$ingredient->getName()])) {
            $this->ingredientBag[$ingredient->getName()] = $ingredient;
        }

        $this->ingredientBag[$ingredient->getName()]->addUnit();
    }

    /* @throws \Exception */
    public function removeUnit(Ingredient $ingredient): void
    {
        if (!isset($this->ingredientBag[$ingredient->getName()])) {
            throw new \Exception($ingredient->getName() . ' was never added to the recipe');
        }

        $this->ingredientBag[$ingredient->getName()]->removeUnit();
    }

}
