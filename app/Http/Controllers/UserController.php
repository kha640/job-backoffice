<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\EditUserValidationRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::latest();

        if ( $request->input('archived') == 'true' ) {
            $query->onlyTrashed();
        }

        $users = $query->paginate(10)->onEachSide(1);

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        $user = User::findOrFail( $id );

        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditUserValidationRequest $request, string $id){
        $user = User::findOrFail( $id );
        $user->update([
            'password' => $request->input('password')
        ]);

        return redirect()->route('users.index')->with(['success' => 'Your change has saved successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){
        $user = User::findOrFail( $id );
        $user->delete();

        return redirect()->route('users.index')->with([ 'success' => 'User archived successfully.' ]);;
    }

    public function restore(string $id) {
        $user = User::onlyTrashed()->findOrFail( $id );
        $user->restore();

        return redirect()->route('users.index', ['archived' => 'true'])->with([ 'success' => 'User archived successfully.' ]);;
    }

}
