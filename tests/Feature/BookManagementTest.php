<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookManagementTest extends TestCase
{

    use RefreshDatabase; // run migratio and tears down DB after every test


    protected function setUp(): void
    {
        parent::setUp();

        // $this->post('/author', [
        //     'name' => 'The name',
        //     'dob' => '12/09/1990'
        // ]);
    }

    /**
     * A basic feature  example.
     *
     * @test
     */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

       $response = $this->post('/books', $this->data());

        $book = Book::first();

        //$response->assertOk();

        $this->assertCount(1, Book::all());

        $response->assertRedirect($book->path());
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

        $response = $this->post('/books', array_merge($this->data(),['author_id' => '']));


         $response->assertSessionHasErrors('author_id');

    }


    /** @test */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', $this->data());


        $book = Book::first();

        //dd($book);

        $response = $this->patch('/book/'.$book->id,[
            'title' => 'My books',
            'author_id' => 1
        ] );

        $this->assertEquals('My books', Book::first()->title);
        $this->assertEquals(1, Book::first()->author_id);

        $response->assertRedirect($book->path());

    }


    /** @test */
    public function a_book_can_be_deleted()
    {
       $this->post('/books', $this->data());


        $book = Book::first();
        $this->assertCount(1, Book::all());


        $result = $this->delete('/delete/'.$book->id);

        $this->assertCount(0, Book::all());
        $result->assertRedirect('/books');
    }


    /** @test */
    public function a_new_author_is_authomatically_added()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'cool book title',
            'author_id' => 'charles'
        ]);

        $author = Author::first();
        $book = Book::first();


        //dd($author);

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());

    }


    private function data():array
    {
        return [
            'title' => 'cool book title',
            'author_id' => '1'
        ];
    }
}
