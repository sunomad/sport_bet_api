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
     * Place a batch of bets from multiple users on multiple matches. 
     * Each bet is validated individually. Valid bets will be saved, 
     * and for invalid bets errors will be returned. 
     * 
     * @param Request $request
     * @return Response
     */
    public function placeBets(Request $request)
    {
        $errors  = [];
        $success = false;
        $bets    = $request->all();
        foreach ($bets as $key => $bet) {
            $validator = Validator::make($bet, [
                'transaction_id'     => 'required|unique:bets',
                'match_date'         => 'required|date',
                'home_team_name'     => 'required',
                'visiting_team_name' => 'required',
                'bet_amount'         => 'required',
                'predicted_winner'   => 'required',
                'username'           => 'required',
            ]);

            if ($validator->fails()) {
                $errors["bet_$key"] = $validator->errors()->all();
                
                // remove invalid bet from the array
                unset($bets[$key]);
            } else {
                $success = true;
            }
            unset($validator);
        }
        
        if(!empty($errors) && $success === false) {
            $result = ['success' => false, 'errors' => $errors];
            return response()->json($result, 422);
        }
        
        $repository = new BookRepository();        
        if(!$repository->saveMultipleBets(array_values($bets))) {
            Log::error('Unable to save any bets');
            $result = ['success' => false, 'errors' => ['Unable to save any bets']];
            return response()->json($result, 500);
        }
        
        if (!empty($errors)) {
            return response()->json(['success' => 'partial', 'errors' => $errors], 207);
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
