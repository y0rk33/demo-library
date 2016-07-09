<?php

namespace App\Http\Controllers\Admin;

use App\BorrowTransaction;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }

    public function index() {
//        $search_text_doc_id = '';
//        $users = [];
//
//        return view('member.index', compact('users', 'search_text_doc_id'));

        $search_text_doc_id = '';
        $users = User::all();
        Log::info('User '.Auth::user()->doc_id.' went to member management page');
        return view('member.index', compact('users', 'search_text_doc_id'));
    }

    public function search(Request $request) {
        $search_text_doc_id = $request->search_text_doc_id;
        $users = User::where('doc_id', $search_text_doc_id)->get();

        Log::info('User '.Auth::user()->doc_id.' used search ' . $search_text_doc_id);
        return view('member.index', compact('users', 'search_text_doc_id'));
    }

    public function show_all() {
        $search_text_doc_id = '';
        $users = User::all();

        return view('member.index', compact('users', 'search_text_doc_id'));
    }

    public function create() {
        Log::info('User '.Auth::user()->doc_id.' create new member');
        return view ('member.register');
    }

    public function store(UserRequest $request) {
        // if the member was previously registered, restore and update with new information
        $user = User::onlyTrashed()
            ->where('doc_id', $request->doc_id)->first();

        $temp_password = str_random(8);

        if (empty($user)) {
            $user = User::create($request->all());

        } else {
            $user->restore();
            $user->update($request->all());
        }

        $user->password = Hash::make($temp_password);
        $user->save();

        flash()->info('This is a temp password for '. $user->doc_id .' : <strong>'.$temp_password.'</strong>');

        Log::info('User '.Auth::user()->doc_id.' member created : '.$user->doc_id);
        return redirect('member');
    }

    // there is no separate page for each of the members
    public function show($id) {
        return redirect('member');
    }

    public function edit($id) {
        try {
            $user = User::findOrFail($id);

            Log::info('User '.Auth::user()->doc_id.' member -> edit : success '.$user->doc_id);
            return view('member.edit', compact('user'));
        } catch(ModelNotFoundException $e) {
            flash()->error('Such member does not exist');
            Log::error('User '.Auth::user()->doc_id.' member updated -> cannot find : '.$id);
            return redirect('member');
        }
    }

    public function update(UserRequest $request, $id) {
        try {
            $user = User::findOrFail($id);
            $user->update($request->all());

            if (empty($request->is_admin)) {
                $user->is_admin = 0;
                $user->save();
            }

            flash()->success('Changes have been saved');

            Log::info('User '.Auth::user()->doc_id.' member updated : '.$user->doc_id);
            return redirect('member/'.$user->id.'/edit');
        } catch (ModelNotFoundException $e) {
            flash()->error('Such memeber does not exist');

            Log::error('User '.Auth::user()->doc_id.' member updated -> cannot find : '.$id);
            return redirect('member');
        }
    }

    public function destroy($id) {
        // check if there are no current loans / requests with the user, only then delete
        try {
            $user = User::findOrFail($id);

            $transactions = BorrowTransaction::where('user_id', $user->id)
                ->where(function($q) {
                    $q->where('status', 'Requested')
                        ->orWhere('status', 'On Loan');
                })
                ->get();

            if (count($transactions) <= 0) {
                $user->delete();

                Log::info('User '.Auth::user()->doc_id.' member delete -> success : '.$user->doc_id);
                flash()->success('A user has been deleted');
            } else {
                Log::info('User '.Auth::user()->doc_id.' member delete -> fail (pending items) : '.$user->doc_id);
                flash()->warning('A user is currently requesting and / or has books on loan');
            }
        } catch(ModelNotFoundException $e) {
            Log::error('User '.Auth::user()->doc_id.' member delete -> cannot find : '.$id);
            flash()->error('Such user does not exist');
        }
    }

    public function password_reset($id) {
        try {
            $temp_password = str_random(8);
            $user = User::findOrFail($id);

            $user->password = Hash::make($temp_password);
            $user->save();

            flash()->info('This is a temp password for '. $user->doc_id .' : <strong>'.$temp_password.'</strong>');

            Log::info('User '.Auth::user()->doc_id.' member password_reset -> success : '.$user->doc_id);
        } catch (ModelNotFoundException $e) {
            Log::error('User '.Auth::user()->doc_id.' member password_reset -> cannot find : '.$id);
            flash()->error('Such member does not exist');
        }

        return redirect('member');
    }


}
