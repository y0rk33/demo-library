<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Book;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\BorrowTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }

    public function index(){
//        $search_text = '';
//        $borrow_transactions = [];
//
//        return view('admin.request', compact('borrow_transactions', 'search_text'));

        /*
		 * This chunk of code is almost the same as the method show_all
		 * Initially the requests were not displayed straight away (a button on demand to display all, similar to book management page
		 * (if there are a lot of records, it will cause the page to load very slow)
		 */

        $search_text = '';
        $borrow_transactions = BorrowTransaction::where('status', 'Requested')
            ->orderBy('created_at', 'desc')
            ->get();

        Log::info('User '.Auth::user()->doc_id.' pending_request -> index');
        return view('admin.request', compact('borrow_transactions', 'search_text'));
    }

    public function show_all() {
        $search_text = '';
        $borrow_transactions = BorrowTransaction::where('status', 'Requested')
            ->orderBy('created_at', 'desc')
            ->get();

        if (count($borrow_transactions) <= 0) {
            flash()->error('No pending requests');
            return redirect('/pending_request');
        }

        return view('admin.request', compact('borrow_transactions', 'search_text'));
    }

    public function search(Request $request) {
        $borrow_transactions = [];
        $search_text = $request->search_parameter;

        // search by isbn, first name, last name, request number
        if(!empty($search_text)) {
            // search by request number
            $borrow_transactions = BorrowTransaction::where('request_number', $search_text)
                ->where('status', 'Requested')
                ->orderBy('created_at', 'desc')
                ->get();

            // search by doc id
            if (count($borrow_transactions) <= 0) {
                $user = User::where('doc_id', $search_text)->first();

                if (count($user) > 0) {
                    $borrow_transactions = BorrowTransaction::where('user_id', $user->id)
                        ->where('status', 'Requested')
                        ->orderBy('created_at', 'desc')
                        ->get();
                }
            }

            // search by isbn
            if (count($borrow_transactions) <= 0) {
                $book = Book::where('isbn', $search_text)->first();

                if (count($book) > 0) {
                    $borrow_transactions = BorrowTransaction::where('book_id', $book->id)
                        ->where('status', 'Requested')
                        ->orderBy('created_at', 'desc')
                        ->get();
                }
            }

            if (count($borrow_transactions) <= 0) {
                flash()->error('Could not find the record(s)');
                return redirect('/pending_request');
            }

        }

        Log::info('User '.Auth::user()->doc_id.' pending_request -> search : '.$search_text);
        return view('admin.request', compact('borrow_transactions', 'search_text'));
    }

    public function lend($id) {
        try {
            $borrow_transactions = BorrowTransaction::findOrFail($id);
            $borrow_transactions->status = 'On Loan';
            $borrow_transactions->save();

            flash()->success('The book is now on loan');
            Log::info('User '.Auth::user()->doc_id.' pending_request -> lend : ');
        } catch(ModelNotFoundException $e) {
            flash()->error('Such request does not exist');
            Log::info('User '.Auth::user()->doc_id.' pending_request -> lend : fail, no such request'.$id);
        }

        return redirect('/pending_request');
    }

    public function cancel($id) {
        try {
            $borrow_transactions = BorrowTransaction::findOrFail($id);
            DB::transaction(function($borrow_transactions) use ($borrow_transactions) {
                $borrow_transactions->status = 'Cancelled';
                $borrow_transactions->save();

                // add the qty back
                $book = $borrow_transactions->book;
                $book->current_qty += 1;
                $book->save();
            });

            flash()->success('The Request has been successfully cancelled');
            Log::info('User '.Auth::user()->doc_id.' pending_request -> cancel : success');
        } catch(ModelNotFoundException $e) {
            flash()->error('Such request does not exist');
            Log::info('User '.Auth::user()->doc_id.' pending_request -> lend : fail, no such request'.$id);
        }

        return redirect('/pending_request');
    }
}
