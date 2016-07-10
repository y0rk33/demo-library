<?php

namespace App\Http\Controllers;

use App\BorrowTransaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Book;
use App\Http\Requests\BookRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Yajra\Datatables\Facades\Datatables;

class BooksController extends Controller
{
	public function __construct() {
		$this->middleware('admin', ['except' => ['index', 'search', 'show']]);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function index() {
		$search_text = '';
		$books = [];

		Log::info('User '.Auth::user()->doc_id.' went to /book');
		return view ('book.index', compact('books', 'search_text'));
	}

	public function search(Request $request) {
		$books = [];
		$search_text = trim($request->search_text);

		// search by isbn, title or author
		if (!empty($search_text)) {
			$books = Book::whereNull('deleted_at')
				->where(function($q) use ($search_text) {
					$q->where('isbn', $search_text)
						->orWhere('title', 'like', '%'.$search_text.'%')
						->orWhere('author', 'like', '%'.$search_text.'%');
				})
				->orderBy('isbn', 'asc')
				->get();
		}

		if (count($books) <= 0) {
			flash()->error('No results. You may try to search isbn, title or author');

			Log::info('User '.Auth::user()->doc_id.' used search : no results');
			return redirect('/book');
		}

		Log::info('User '.Auth::user()->doc_id.' used search : '.$request->search_text);
		return view ('book.index', compact('books', 'search_text'));
	}

	public function show_all() {
		$books = Book::all();

		return Datatables::collection($books)
					->editColumn('isbn', '<a href="{{ url(\'book/\'.$id) }}">{{ $isbn }}</a>')
					->make(true);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		Log::info('User '.Auth::user()->doc_id.' went to /book -> create');
        return view ('book.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request) {
		// check if book was been previously in the library, restore
		$book = Book::onlyTrashed()
			->where('isbn', $request->isbn)
			->first();

		if (empty($book)) {
			$book = Book::create($request->all());
		} else {
			$book->restore();
			$book->update($request->all());
		}

		$book->current_qty = $book->total_qty;
		$book->save();

		// updating a cover if there is one
		$this->cover_update($request, $book->id);

		flash()->success('A new book has been added');

		Log::info('User '.Auth::user()->doc_id.' went to /book -> created : '.$book->isbn);
		return redirect('book/'.$book->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        try {
            $book = Book::findOrFail($id);

			Log::info('User '.Auth::user()->doc_id.' went to /book -> show : '.$book->isbn);
            return view ('book.show', compact('book'));
        } catch (ModelNotFoundException $e) {
            flash()->error('Such book does not exist');
			Log::error('User '.Auth::user()->doc_id.' went to /book -> show : fail to get a book with id : '.$id);
            return redirect('book');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		try {
			$book = Book::findOrFail($id);

			Log::info('User '.Auth::user()->doc_id.' went to /book -> edit : '.$book->isbn);
			return view ('book.edit', compact('book'));
		} catch (ModelNotFoundException $e) {
			flash()->error('Such book does not exist');
			Log::error('User '.Auth::user()->doc_id.' went to /book -> edit : fail to edit a book with id : '.$id);
			return redirect('book');
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BookRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, $id)
    {
		try {
			$book = Book::findOrFail($id);
			$book->update($request->all());

			$book->total_qty = $book->total_qty + $request->add_qty;
			$book->current_qty = $book->current_qty + $request->add_qty;
			$book->save();

			flash()->success('The changes have been successfully saved');
			Log::info('User '.Auth::user()->doc_id.' went to /book -> update : '.$book->isbn);
			return redirect ('book/'.$book->id);
		} catch (ModelNotFoundException $e) {
			flash()->error('Such book does not exist');
			Log::error('User '.Auth::user()->doc_id.' went to /book -> update : fail to update a book with id : '.$id);
			return redirect('book');
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // check if there are no current loans with the book, only then delete
		try {
			$book = Book::findOrFail($id);

			$transactions = BorrowTransaction::where('book_id', $book->id)
				->where(function($q) {
					$q->where('status', 'Requested')
						->orWhere('status', 'On Loan');
				})
				->get();

			if (count($transactions) <= 0) {
				$book->delete();
				flash()->success('A book has been deleted');
				Log::info('User '.Auth::user()->doc_id.' went to /book -> destroy : '.$book->isbn);

				return 'success';
			} else {
				flash()->warning('The book is currently being requested or on loan');
				Log::info('User '.Auth::user()->doc_id.' went to /book -> destroy : fail, book on loan or transaction'.$book->isbn);

				return 'fail';
			}
		} catch(ModelNotFoundException $e) {
			flash()->error('Such book does not exist');
			Log::error('User '.Auth::user()->doc_id.' went to /book -> destroy : cannot find book with id : '.$id);

			return 'fail';
		}

    }

    public function cover_update(Request $request, $id) {
		$this->validate($request, [
			'book_cover' => 'max:500|mimes:jpg,png,jpeg'
		]);

		$book = Book::findOrFail($id);

		if ($request->hasFile('book_cover')) {
			$book_cover = $request->file('book_cover');
			$filename = $book->isbn.'.'.$book_cover->getClientOriginalExtension();
			Image::make($book_cover)->save(public_path('/uploads/book_covers/' . $filename));

			$book->book_cover = $filename;
			$book->save();

			flash()->success('Picture has been successfully updated');
			Log::info('User '.Auth::user()->doc_id.' went to /book -> cover_update : '.$book->isbn);
		} else {
			flash()->warning('Please select an image');
			Log::info('User '.Auth::user()->doc_id.' went to /book -> cover_update : fail, no image selected for book id : '.$book->isbn);
		}

		return redirect ('book/'.$id);
    }

}
