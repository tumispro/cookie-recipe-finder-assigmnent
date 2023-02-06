<?php

use App\Ingredients\CookieIngredient;
use App\Recipes\CookieRecipe;
use App\Chefs\CookieChef;
use PHPUnit\Framework\TestCase;

/* @covers \App\Chefs\CookieChef() */
final class CookieChefTest extends TestCase
{

    private CookieChef $cookieChef;

    protected function setUp(): void {
        parent::setUp();

        $ingredients = [
            new CookieIngredient(CookieIngredient::TYPE_BUTTERSCOTCH, -1, -2, 6, 3, 8),
            new CookieIngredient(CookieIngredient::TYPE_CINNAMON, 2, 3 , -2 , -1, 3),
        ];

        $cookieRecipe = new CookieRecipe();

        $this->cookieChef = (new CookieChef($cookieRecipe))
            ->setIngredients($ingredients)
            ->setUnits(100)
        ;
    }

    protected function tearDown(): void {
        parent::tearDown();

        unset($this->cookieChef);
    }

    public function testCookieRecipeExample(): void {
        $optimalRecipe = $this->cookieChef->getOptimalRecipe();
        $ingredients = $optimalRecipe->getIngredientBag();
        $butterscotch = $ingredients[CookieIngredient::TYPE_BUTTERSCOTCH] ?? NULL;
        $cinnamon = $ingredients[CookieIngredient::TYPE_CINNAMON] ?? NULL;

        $this->assertSame($optimalRecipe->getScore(), 62842880);
        $this->assertNotEmpty($butterscotch, 'Missing butterscotch ingredient');
        $this->assertNotEmpty($cinnamon, 'Missing cinnamon ingredient');
        $this->assertSame($butterscotch->getQuantity(), 44);
        $this->assertSame($cinnamon->getQuantity(), 56);
    }

    public function testCookieRecipeWithCalories(): void {
        $optimalRecipe = $this->cookieChef
            ->setCalories(500)
            ->getOptimalRecipe()
        ;

        $this->assertSame($optimalRecipe->getCalories(), 500);
    }

}
