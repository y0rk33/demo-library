<?php

namespace App\Http\Controllers;

use App\Parameter;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\BorrowTransaction;
use App\Book;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $borrow_transactions = BorrowTransaction::where('status', 'Requested')
            ->where('user_id', Auth::user()->id)
            ->get();

        Log::info('User '.Auth::user()->doc_id.' my_request -> index');
        return view('my_book.request', compact('borrow_transactions'));
    }

    /**
     * to process a book request
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function request($id) {
        try {
            $book = Book::findOrFail($id);

            // check if the book quantity is enough
            if ($book->current_qty > 0) {
                $user_requests = BorrowTransaction::where('user_id', Auth::user()->id)
                    ->where(function($q) {
                        $q->where('status', 'Requested')
                            ->orWhere('status', 'On Loan');
                    })
                    ->get();

                // get the age of the member to determine the a book limit
                $age = Carbon::now()->diffInYears(Auth::user()->date_of_birth);
                if ($age <= 12) {
                    $book_limit = Parameter::where('name', 'ageLimit')->first()->value;;
                } else {
                    $book_limit = Parameter::where('name', 'maxLoan')->first()->value;;
                }

                // check if the member hit the borrow limit
                if (count($user_requests) < $book_limit) {
                    $is_already_requested = BorrowTransaction::where('user_id', Auth::user()->id)
                        ->where('book_id', $book->id)
                        ->where('status', 'Requested')
                        ->get();

                    // check if the book being requested already
                    if (count($is_already_requested) === 0)  {

                        DB::transaction(function ($book) use ($book) {
                            // simple token generation to be used when borrowing and returning a book
                            // current date time (with mili seconds) + random number from 1 to 100
                            $token = strtotime(Carbon::now()->format('d-M-Y H:m:s.mi')) * 1000 + rand(1, 100);

                            $borrow_transaction = new BorrowTransaction();
                            $borrow_transaction->request_number = $token;
                            $borrow_transaction->user_id = Auth::user()->id;
                            $borrow_transaction->book_id = $book->id;
                            $borrow_transaction->borrowed_at = Carbon::now();
                            $borrow_transaction->to_be_returned_at = Carbon::now()->addWeeks(2);
                            $borrow_transaction->status = 'Requested';
                            $borrow_transaction->save();

                            // reduce current book qty by one
                            $book->current_qty -= 1;
                            $book->save();
                        });

                        flash()->success('Book has been successfully requested');
                        Log::info('User '.Auth::user()->doc_id.' my_request -> request : success '.$book->id);

                    } else {
                        flash()->warning('You have already requested / loan this book');
                        Log::info('User '.Auth::user()->doc_id.' my_request -> request : already requested / on loan '.$book->id);
                    } // book already requested or already on loan

                } else {
                    flash()->error('You can only request up to '.$book_limit.' books');
                    Log::info('User '.Auth::user()->doc_id.' my_request -> request : hit limit'.$book->id);
                } // hit the limit of book requests

            } else {
                flash()->error('Sorry, the book is currently not available');
                Log::info('User '.Auth::user()->doc_id.' my_request -> request : not enough quantity'.$book->id);
            } // book is not available

            return redirect('/book/'.$book->id);

        } catch (ModelNotFoundException $e) {
            flash()->error('Such book does not exist');
            Log::error('User '.Auth::user()->doc_id.' my_request -> request : book not exist '.$id);
            return redirect('/book');
        }
    }

    /**
     * user decides to cancel the request
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function cancel($id) {

        // check if request exist
        try {
            $borrow_transaction = BorrowTransaction::findOrFail($id);

            // if admin, can cancel everybodies transaction, member only his own
            if (Auth::user()->is_admin() || $borrow_transaction->user->id === Auth::user()->id) {
                $borrow_transaction->status = 'Cancelled';
                $borrow_transaction->save();

                // return the book to current qty (+1)
                $book = $borrow_transaction->book;
                $book->current_qty += 1;
                $book->save();

                flash()->success('You have successfully cancelled a request');
                Log::info('User '.Auth::user()->doc_id.' my_request -> cancel : success'.$book->id);
            } else {
                flash()->error('You did not request such book');
                Log::info('User '.Auth::user()->doc_id.' my_request -> cancel : fail, not requested the book'.$book->id);
            }

        } catch (ModelNotFoundException $e) {
            flash()->error('You did not request such book');
            Log::error('User '.Auth::user()->doc_id.' my_request -> request : book not exist '.$id);
        }

        return redirect('book_request');
    }

    public function on_loan() {
        $borrow_transactions = BorrowTransaction::where('user_id', Auth::user()->id)
            ->where('status', 'On Loan')
            ->orderBy('created_at', 'desc')
            ->get();

        Log::info('User '.Auth::user()->doc_id.' my_on_loan -> index');
        return view('my_book.on_loan', compact('borrow_transactions'));
    }

}
