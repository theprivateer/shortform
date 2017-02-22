<?php

namespace App\Http\Controllers\Communities;

use App\Community\Client;
use App\Community\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PublishingController extends Controller
{
    public function edit()
    {
        $client = Auth::user()->client ?: new Client;

        return view('communities.publishing.edit', compact('client'));
    }

    public function update(Request $request)
    {
        if($id = $request->get('id'))
        {
            $client = Client::findOrFail($id);

            $client->fill($request->all());
        } else
        {
            $client = new Client($request->all());
        }

        Auth::user()->client()->save($client);

        return redirect()->back();
    }

    public function redirect()
    {
        $client = Auth::user()->client;

        $query = http_build_query([
            'client_id'     => $client->client_id,
            'redirect_uri'  => route('community.callback'),
            'response_type' => 'code',
            'scope'         => '*',
        ]);

        return redirect($client->base_url . '/oauth/authorize?' . $query);
    }

    public function callback(Request $request)
    {
        $client = Auth::user()->client;

        $http = new \GuzzleHttp\Client;

        $response = $http->post($client->base_url . '/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => $client->client_id,
                'client_secret' => $client->secret,
                'redirect_uri' => route('community.callback'),
                'code' => $request->code,
            ],
        ]);

        $credentials = json_decode((string) $response->getBody(), true);

        if($token = Auth::user()->token)
        {
            $token->fill($credentials);
        } else
        {
            $token = new Token($credentials);
        }

        $token->client_id = $client->id;

        Auth::user()->token()->save($token);

        return redirect()->route('community.publishing.edit');
    }

    public function delete(Request $request)
    {
        $token = Token::where('id', $request->get('id'))
                        ->where('user_id', Auth::user()->id)
                        ->firstOrFail();

        $token->delete();

        return redirect()->back();
    }
}
