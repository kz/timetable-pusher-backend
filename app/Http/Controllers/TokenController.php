<?php

namespace TimetablePusher\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use TimetablePusher\Http\Requests;
use TimetablePusher\Http\Controllers\Controller;
use TimetablePusher\TimetablePusher\Token;

class TokenController extends Controller
{
    /**
     * Update the specified resource in storage.
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     * @internal param int $id
     */
    public function update()
    {
        // Generate new token
        $token = new Token();
        $apiToken = $token->generateUnique();

        $user = Auth::user();
        $user->api_token = $apiToken;
        $user->update();

        return redirect('dashboard')->with('success', ['Your API token has been regenerated.']);
    }
}
