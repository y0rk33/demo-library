<?php

namespace App\Http\Controllers\Admin;

use App\Book;
use App\BorrowTransaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{
	public function __construct() {
		$this->middleware('admin');
	}

	public function index() {
//		$search_text = '';
//		$borrow_transactions = [];
//
//		return view('admin.return', compact('borrow_transactions', 'search_text'));

		/*
		 * This chunk of code is almost the same as the method show_all
		 * Initially the requests were not displayed straight away (a button on demand to display all, similar to book management page
		 * (if there are a lot of records, it will cause the page to load very slow)
		 */

		$search_text = '';
		$borrow_transactions = BorrowTransaction::where('status', 'On Loan')
			->orderBy('to_be_returned_at', 'asc')
			->get();

		Log::info('User '.Auth::user()->doc_id.' return -> index');
		return view('admin.return', compact('borrow_transactions', 'search_text'));
	}

	public function search(Request $request) {
		$borrow_transactions = [];
		$search_text = $request->search_parameter;

		// search by isbn, first name, last name, request number
		if(!empty($search_text)) {
			// search by request number
			$borrow_transactions = BorrowTransaction::where('request_number', $search_text)
				->where('status', 'On Loan')
				->orderBy('created_at', 'desc')
				->get();

			// search by doc id
			if (count($borrow_transactions) <= 0) {
				$user = User::where('doc_id', $search_text)->first();

				if (count($user) > 0) {
					$borrow_transactions = BorrowTransaction::where('user_id', $user->id)
						->where('status', 'On Loan')
						->orderBy('created_at', 'desc')
						->get();
				}
			}

			// search by isbn
			if (count($borrow_transactions) <= 0) {
				$book = Book::where('isbn', $search_text)->first();

				if (count($book) > 0) {
					$borrow_transactions = BorrowTransaction::where('book_id', $book->id)
						->where('status', 'On Loan')
						->orderBy('created_at', 'desc')
						->get();
				}
			}

			if (count($borrow_transactions) <= 0) {
				flash()->error('Could not find the record(s)');
				return redirect('/book_return');
			}

		}

		Log::info('User '.Auth::user()->doc_id.' return -> search : '.$search_text);
		return view('admin.return', compact('borrow_transactions', 'search_text'));
	}

	public function show_all() {
		$search_text = '';
		$borrow_transactions = BorrowTransaction::where('status', 'On Loan')
			->orderBy('to_be_returned_at', 'asc')
			->get();

		if (count($borrow_transactions) <= 0) {
			flash()->error('No books on loan');
			return redirect('/book_return');
		}

		return view('admin.return', compact('borrow_transactions', 'search_text'));
	}

	public function returned($id) {
		try {
			$borrow_transaction = BorrowTransaction::findOrFail($id);

			DB::transaction(function($borrow_transaction) use ($borrow_transaction) {
				$borrow_transaction->status = 'Returned';
				$borrow_transaction->returned_at = Carbon::now();
				$borrow_transaction->save();

				$book = $borrow_transaction->book;
				$book->current_qty += 1;
				$book->save();

				if (!empty($borrow_transaction->fine)) {
					$fine = $borrow_transaction->fine;
					$fine->status = 'Payed';
					$fine->save();
				}
			});

			flash()->success('Book has been successfully returned');
			Log::info('User '.Auth::user()->doc_id.' return -> returned : sucess, '.$borrow_transaction->id);
		} catch (ModelNotFoundException $e) {
			flash()->error('Such loan cannot be found');
			Log::error('User '.Auth::user()->doc_id.' return -> returned : fail, no such id '.$id);
		}


		return redirect('/book_return');
	}
}
