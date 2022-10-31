<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationTest extends TestCase
{

    use RefreshDatabase; // run migratio and tears down DB after every test

    /**
     * A basic feature  example.
     *
     * @test
     */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

       $response = $this->post('/books', [
            'title' => 'cool book title',
            'author' => 'Charles'
        ]);

        $response->assertOk();

        $this->assertCount(1, Book::all());
    }

    /** @test */
    public function a_title_is_required()
    {
        //$this->withoutExceptionHandling();

        $response = $this->post('/books', [
             'title' => '',
             'author' => 'Charles'
         ]);

         $response->assertSessionHasErrors('title');

    }


    /** @test */
    public function a_author_is_required()
    {
        //$this->withoutExceptionHandling();

        $response = $this->post('/books', [
             'title' => 'Charles',
             'author' => ''
         ]);

         $response->assertSessionHasErrors('author');

    }


    /** @test */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'cool book title',
            'author' => 'Charles'
        ]);


        $book = Book::first();


        $this->patch('/book/'.$book->id, [
            'title' => 'My books',
            'author' => 'john lengend'
        ]);

        $this->assertEquals('My books', Book::first()->title);
        $this->assertEquals('john lengend', Book::first()->author);

    }
}
