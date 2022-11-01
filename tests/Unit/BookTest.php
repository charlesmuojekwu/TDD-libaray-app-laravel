<?php

namespace Tests\Unit;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function PHPUnit\Framework\assertCount;

class BookTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @test
     */
    public function an_author_id_id_added()
    {
        Book::create([
            'title' => fake()->title(),
            'author_id' => 1
        ]);

        assertCount(1, Book::all());
    }
}
