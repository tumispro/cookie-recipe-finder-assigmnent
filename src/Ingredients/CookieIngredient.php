<?php

namespace App\Ingredients;

use App\Ingredients\Interfaces\Ingredient;

final class CookieIngredient implements Ingredient
{

    public const TYPE_CINNAMON = 'Cinnamon';
    public const TYPE_SPRINKLES = 'Sprinkles';
    public const TYPE_BUTTERSCOTCH = 'Butterscotch';
    public const TYPE_CHOCOLATE = 'Chocolate';
    public const TYPE_CANDY = 'Candy';

    protected string $name;

    protected int $capacity;
    protected int $durability;
    protected int $flavor;
    protected int $texture;
    protected int $calories;

    protected int $teaspoons = 0;

    public function __construct(string $name, int $capacity = 0, int $durability = 0, int $flavor = 0, int $texture = 0, int $calories = 0) {
        $this->name = $name;
        $this->capacity = $capacity;
        $this->durability = $durability;
        $this->flavor = $flavor;
        $this->texture = $texture;
        $this->calories = $calories;
    }

    public function getUnit(): string {
        return 'tsp';
    }

    public function addUnit() {
        $this->teaspoons++;
    }

    public function removeUnit() {
        $this->teaspoons--;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getCapacity(): int {
        return $this->capacity;
    }

    public function getDurability(): int {
        return $this->durability;
    }

    public function getFlavor(): int {
        return $this->flavor;
    }

    public function getCalories(): int {
        return $this->calories;
    }

    public function getTexture(): int {
        return $this->texture;
    }

    public function getQuantity(): int {
        return $this->teaspoons;
    }

}
