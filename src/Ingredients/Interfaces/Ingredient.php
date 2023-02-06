<?php

namespace App\Ingredients\Interfaces;

interface Ingredient
{

    public function getUnit(): string;

    public function getQuantity(): int;

    public function getCalories(): int;

}
