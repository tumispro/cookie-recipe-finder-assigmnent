<?php

use App\Ingredients\CookieIngredient;
use PHPUnit\Framework\TestCase;

/* @covers \App\Ingredients\CookieIngredient() */
final class CookieIngredientTest extends TestCase
{

    private CookieIngredient $cookieIngredient;

    protected function setUp(): void {
        parent::setUp();

        $this->cookieIngredient = new CookieIngredient(CookieIngredient::TYPE_BUTTERSCOTCH, -1, -2, 6, 3, 8);
    }

    protected function tearDown(): void {
        parent::tearDown();

        unset($this->cookieIngredient);
    }

    public function testCookieIngredientsAddRemoveUnit(): void {
        $this->cookieIngredient->addUnit();

        $this->assertSame($this->cookieIngredient->getQuantity(), 1);

        $this->cookieIngredient->removeUnit();

        $this->assertSame($this->cookieIngredient->getQuantity(), 0);
    }

}
