<?php

namespace App\Chefs;

use App\Ingredients\CookieIngredient;
use App\Recipes\Interfaces\Recipe;
use App\Chefs\Interfaces\Chef;

/**
 * CookieChef finds the most delicious recipe given a set of ingredients and limitations
 */
final class CookieChef implements Chef
{

    protected ?int $teaspoons = NULL;
    protected ?int $calories = NULL;

    protected Recipe $recipe;

    /* @var array|CookieIngredient[] */
    protected array $ingredients;

    public function __construct(Recipe $recipe) {
        $this->recipe = $recipe;
    }

    /**
     * Adds units of ingredients until either the requested amount of units is reached or the set calorie goal
     * is reached.
     *
     * @throws \Exception
     */
    public function getOptimalRecipe(): Recipe {

        while ($this->recipe->getAddedUnits() < $this->teaspoons) {
            $this->recipe->addUnit($this->getNextOptimalIngredient());

            if ($this->calories !== NULL && $this->recipe->getCalories() === $this->calories) {
                // Calorie goal is reached
                break;
            }
        }

        return $this->recipe;
    }

    public function setIngredients(array $ingredients): self {
        $this->ingredients = $ingredients;
        return $this;
    }

    public function setUnits(?int $units): self {
        $this->teaspoons = $units;
        return $this;
    }

    public function setCalories(?int $calories): self {
        $this->calories = $calories;
        return $this;
    }

    /**
     * Find the optimal ingredient for the current ingredient bag. Recursively increases an offset if all scores are 0
     * to find the highest scoring ingredient regardless.
     *
     * @param int $offset
     * @return CookieIngredient
     * @throws \Exception
     */
    private function getNextOptimalIngredient(int $offset = 0): CookieIngredient {
        $optimalIngredient = NULL;
        $highestIngredientScore = NULL;

        foreach ($this->ingredients as $ingredient) {
            $ingredientScore = $this->recipe->getScoreForPotentialIngredient($ingredient, $offset);

            // Skip to next if the calorie goal can't be achieved (anymore)
            if (!$this->canPotentiallyAchieveCalorieGoal($ingredient)) {
                continue;
            }

            // Check if ingredient scores better than the previous one
            if ($ingredientScore > $highestIngredientScore || $highestIngredientScore === NULL) {
                $optimalIngredient = $ingredient;
                $highestIngredientScore = $ingredientScore;
            }
        }

        // Calorie goal unreachable
        if ($optimalIngredient === NULL) {
            throw new \Exception('Calorie goal can\'t be reached with the given ingredients');
        }

        // When there's no optimal ingredient for the current score, find one based on a fictional offset
        if ($highestIngredientScore === 0) {
            $optimalIngredient = $this->getNextOptimalIngredient($offset + 100);
        }

        return $optimalIngredient;
    }

    /**
     * Checks whether the calorie goal can still be reached after a certain ingredient is added
     *
     * @throws \Exception
     */
    private function canPotentiallyAchieveCalorieGoal(CookieIngredient $ingredient): bool {
        $this->recipe->addUnit($ingredient);
        $canAchieve = $this->canAchieveCalorieGoal();
        $this->recipe->removeUnit($ingredient);
        return $canAchieve;
    }

    /**
     * Checks if there's any ingredient left that can reach the calorie goal
     *
     * @Limitations: only checks if 1 ingredient can reach the goal by using modulo, which would fail if it can only
     * reach the calorie goal using a combination of different ingredients. For this assessment this suffices, but it
     * would need improvement for more complex recipes.
     */
    private function canAchieveCalorieGoal(): bool {
        if ($this->calories === NULL) {
            return TRUE;
        }

        $caloriesLeft = $this->calories - $this->recipe->getCalories();
        foreach ($this->ingredients as $ingredient) {
            if ($caloriesLeft % $ingredient->getCalories() === 0) {
                return TRUE;
            }
        }

        return FALSE;
    }

}
