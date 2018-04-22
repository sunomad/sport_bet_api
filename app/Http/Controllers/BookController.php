<?php

namespace App\Http\Controllers;

use Log;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BookRepository;


class BookController extends Controller
{
    /**
     * Place a bet for a user on a match
     */
    public function placeBet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'match_date'         => 'required|date',
            'home_team_name'     => 'required',
            'visiting_team_name' => 'required',
            'bet_amount'         => 'required',
            'predicted_winner'   => 'required',
            'username'           => 'required',
        ]);

        if ($validator->fails()) {
            $result = ['success' => false, 'errors' => $validator->errors()->all()];
            return response()->json($result, 422);
        }
        
        $repository = new BookRepository();        
        if(!$repository->saveBet($request->all())) {
            Log::error('Unable to save bet');
            $result = ['success' => false, 'errors' => ['Unable to save bet']];
            return response()->json($result, 500);
        }
        
        return response()->json(['success' => true], 200);
    }
    
    /**
     * Get a book
     * 
     * @param Request $request
     * @return Response
     */
    public function getBook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'match_date'         => 'required|date',
            'home_team_name'     => 'required',
            'visiting_team_name' => 'required'
        ]);

        if ($validator->fails()) {
            $result = ['success' => false, 'errors' => $validator->errors()->all()];
            return response()->json($result, 422);
        }
        
        $repository = new BookRepository();
        $book = $repository->getBook($request->get('match_date'), $request->get('home_team_name'), $request->get('visiting_team_name'));
        
        return response()->json($book, 200);
    }
    
}
