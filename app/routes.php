<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	//return View::make('hello');
    return View::make('index');
});

Route::get('/books', function() {
    return 'Here are all the books...';
}); 

Route::get('/books/{category}', function($category) {
        return 'Here are all the books in the category of '.$category;
}); 


Route::get('/new', function() {

    $view  = '<form method="POST">';
    $view .= 'Title: <input type="text" name="title">';
    $view .= '<input type="submit">';
    $view .= '</form>';
    return $view;

});

Route::post('/new', function() {

    $input =  Input::all();
    print_r($input);

});

Route::get('/practice', function() {
    echo App::environment();
});

use Paste\Pre;

Route::get('/practice', function() {

    $fruit = Array('Apples', 'Oranges', 'Pears');

    echo Pre::render($fruit,'Fruit');

});  

Route::get('/bobby', function() {
    $kid = new Bobby();
});

Route::get('/help', function() {
    return Helpers::doMessage();
});

Route::get('/get-environment',function() {

    echo "Environment: ".App::environment();

});

Route::get('/trigger-error',function() {

    # Class Foobar should not exist, so this should create an error
    $foo = new Foobar;

});

Route::get('mysql-test', function() {

    # Print environment
    echo 'Environment: '.App::environment().'<br>';

    # Use the DB component to select all the databases
    $results = DB::select('SHOW DATABASES;');

    # If the "Pre" package is not installed, you should output using print_r instead
    echo Pre::render($results);

});

Route::get('/debug', function() {

    echo '<pre>';

    echo '<h1>environment.php</h1>';
    $path   = base_path().'/environment.php';

    try {
        $contents = 'Contents: '.File::getRequire($path);
        $exists = 'Yes';
    }
    catch (Exception $e) {
        $exists = 'No. Defaulting to `production`';
        $contents = '';
    }

    echo "Checking for: ".$path.'<br>';
    echo 'Exists: '.$exists.'<br>';
    echo $contents;
    echo '<br>';

    echo '<h1>Environment</h1>';
    echo App::environment().'</h1>';

    echo '<h1>Debugging?</h1>';
    if(Config::get('app.debug')) echo "Yes"; else echo "No";

    echo '<h1>Database Config</h1>';
    print_r(Config::get('database.connections.mysql'));

    echo '<h1>Test Database Connection</h1>';
    try {
        $results = DB::select('SHOW DATABASES;');
        echo '<strong style="background-color:green; padding:5px;">Connection confirmed</strong>';
        echo "<br><br>Your Databases:<br><br>";
        print_r($results);
    } 
    catch (Exception $e) {
        echo '<strong style="background-color:crimson; padding:5px;">Caught exception: ', $e->getMessage(), "</strong>\n";
    }

    echo '</pre>';

});

Route::get('/practice-creating', function() {

    # Instantiate a new Book model class
    $book = new Book();

    # Set 
    $book->title = 'The Great Gatsby';
    $book->author = 'F. Scott Fiztgerald';
    $book->published = 1925;
    $book->cover = 'http://img2.imagesbn.com/p/9780743273565_p0_v4_s114x166.JPG';
    $book->purchase_link = 'http://www.barnesandnoble.com/w/the-great-gatsby-francis-scott-fitzgerald/1116668135?ean=9780743273565';

    # This is where the Eloquent ORM magic happens
    $book->save();

    $book = new Book();

    # Set 
    $book->title = 'The Bell Jar';
    $book->author = 'Sylvia Plath';
    $book->published = 1963;
    $book->cover = 'http://img1.imagesbn.com/p/9780061148514_p0_v2_s114x166.JPG';
    $book->purchase_link = 'http://www.barnesandnoble.com/w/bell-jar-sylvia-plath/1100550703?ean=9780061148514';

    # This is where the Eloquent ORM magic happens
    $book->save();

    $book = new Book();

    # Set 
    $book->title = 'I know why the caged bird sings';
    $book->author = 'Maya Angelou';
    $book->published = 1969;
    $book->cover = 'http://img1.imagesbn.com/p/9780345514400_p0_v1_s114x166.JPG';
    $book->purchase_link = 'http://www.barnesandnoble.com/w/i-know-why-the-caged-bird-sings-maya-angelou/1100392955?ean=9780345514400';

    # This is where the Eloquent ORM magic happens
    $book->save();    

    return 'A new book has been added! Check your database to see...';

});

Route::get('/practice-reading', function() {

    # The all() method will fetch all the rows from a Model/table
    $books = Book::all();

    # Make sure we have results before trying to print them...
    if($books->isEmpty() != TRUE) {

        # Typically we'd pass $books to a View, but for quick and dirty demonstration, let's just output here...
        foreach($books as $book) {
            echo $book->title.'<br>';
        }
    }
    else {
        return 'No books found';
    }

});

Route::get('/practice-reading-one-book', function() {

    $book = Book::where('author', 'LIKE', '%Scott%')->first();

    if($book) {
        return $book->title;
    }
    else {
        return 'Book not found.';
    }

});

Route::get('/practice-updating', function() {

    # First get a book to update
    $book = Book::where('author', 'LIKE', '%Scott%')->first();

    # If we found the book, update it
    if($book) {

        # Give it a different title
        $book->title = 'The Really Great Gatsby';

        # Save the changes
        $book->save();

        return "Update complete; check the database to see if your update worked...";
    }
    else {
        return "Book not found, can't update.";
    }

});

Route::get('/practice-deleting', function() {

    # First get a book to delete
    $book = Book::where('author', 'LIKE', '%Scott%')->first();

    # If we found the book, delete it
    if($book) {

        # Goodbye!
        $book->delete();

        return "Deletion complete; check the database to see if it worked...";

    }
    else {
        return "Can't delete - Book not found.";
    }

});

Route::get('/example_one', function() {
    $collection = Book::all();

    # This object is a wrapper for an Array called items which 
    # contains all the data of your query
    echo Pre::render($collection);  
});

Route::get('/example_two', function() {
    $collection = Book::all();
    
    # loop through the Collection and access just the data
    foreach($collection as $book) {
    echo $book['title']."<br>";
    }   
});

Route::get('/example_three', function() {
    $collection = Book::all();

    foreach($collection as $book) {
        echo $book->title."<br>";
    } 
});

Route::get('/example_four', function() {
    $collection = Book::all();
    var_dump($collection->toArray());
});

Route::get('/example_five', function() {
    $collection = Book::all();

    # This will output a JSON string
    echo $collection;  
});

//display the form for a new book
Route::get('/add', function() {
    return View::make('add');
});

//proces form for new book with token validation, watch the parens
Route::post('/add', array('before'=>'csrf', function() {
    //commented out the variable dump because it was showing before the Redirect
    //var_dump($_POST);

//below is the code that puts the user input into the table
    $book = new Book();
    $book->title = $_POST['title'];
    //same as $book->title = Input::get('title');
    $book->author = $_POST['author'];
    $book->save();
    //return 'Your book has been saved';
    //below assumes the get version of the page
    return Redirect::to('/add');
}));

// Display the form to edit a book
Route::get('/edit/{title}', function() {

});

// Process form for a edit book
Route::post('/edit/', function() {
    
});