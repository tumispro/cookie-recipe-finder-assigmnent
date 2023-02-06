<?php

use App\Ingredients\CookieIngredient;
use App\Recipes\CookieRecipe;
use PHPUnit\Framework\TestCase;

/* @covers \App\Recipes\CookieRecipe() */
final class CookieRecipeTest extends TestCase
{

    private CookieRecipe $cookieRecipe;

    protected function setUp(): void {
        parent::setUp();

        $this->cookieRecipe = new CookieRecipe();
    }

    protected function tearDown(): void {
        parent::tearDown();

        unset($this->cookieRecipe);
    }

    public function testCookieRecipeScoreExample(): void {
        $butterscotch = new CookieIngredient(CookieIngredient::TYPE_BUTTERSCOTCH, -1, -2, 6, 3, 8);
        $cinnamon = new CookieIngredient(CookieIngredient::TYPE_CINNAMON, 2, 3 , -2 , -1, 3);

        $this->cookieRecipe->addUnit($butterscotch);
        $this->cookieRecipe->addUnit($cinnamon);
        $this->assertSame($this->cookieRecipe->getScore(), 8);

        $this->cookieRecipe->addUnit($cinnamon);
        $this->assertSame($this->cookieRecipe->getScore(), 24);

        $this->cookieRecipe->removeUnit($cinnamon);
        $this->assertSame($this->cookieRecipe->getScore(), 8);
    }

}
