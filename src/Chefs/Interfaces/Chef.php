<?php

namespace App\Chefs\Interfaces;

use App\Recipes\Interfaces\Recipe;

interface Chef
{

    public function getOptimalRecipe(): Recipe;

    public function setIngredients(array $ingredients): self;

    public function setUnits(?int $units): self;

    public function setCalories(?int $calories): self;

}
