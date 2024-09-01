<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Set;
use App\Models\Card;
use App\Models\User;

class SetController extends Controller
{
    // 세트 저장 페이지
    public function createSet() 
    {
        return view('set/create-set');
    }

    // 세트 저장 기능
    public function saveSet(Request $request)
    {
        $set_data = $request->only(['title', 'instruction', 'email']);
        Set::create($set_data);

        $cardsData = $request->input('cards');
        $title = $request->input('title');
        foreach ($cardsData as $data) {
            Card::create([
                'set_title' => $title,
                'word' => $data['word'],
                'meaning' => $data['meaning'],
            ]);
        }

        return redirect('/quizgo');
    }

    // 상세 보기
    public function showSet(Set $set)
    {
        $cards = Card::where('set_title', $set->title)->get();
        $creator = User::select('name', 'profile')->where('email', $set->email)->first();

        return view('set/show-set', compact('set', 'cards', 'creator'));
    }

    // 세트 삭제
    public function deleteSet(Set $set)
    {
        Set::where('id', $set->id)->delete();

        return redirect('/quizgo');
    }

    // 단어 테스트 페이지
    public function testSet(Set $set)
    {
        $cards = Card::where('set_title', $set->title)->get();

        $card_counts = Card::select('set_title', DB::raw('count(*) as count'))
                        ->where('set_title', $set->title)
                        ->groupBy('set_title')
                        ->get();

        return view('set/test-set', compact('set', 'cards', 'card_counts'));
    }

    // 세트 업데이트 페이지
    public function modifySet(Set $set)
    {
        $cards = Card::where('set_title', $set->title)->get();

        return view('set/modify-set', compact('set', 'cards'));
    }

    // 카드 삭제
    public function deleteCard(Request $request)
    {
        $id_list_for_deletion = $request->input('id_list_for_deletion');

        if($id_list_for_deletion) {
            foreach ($id_list_for_deletion as $id) {
                Card::where('id', $id)->delete();
            }
        }

        return response()->json(['success' => true]);
    }

    // 세트 업데이트 기능
    public function updateSet(Request $request, Set $set)
    {
        // 세트 업데이트
        $title = $request->input('title');
        $instruction = $request->input('instruction');
        Set::where('id', $set->id)->update([
            'title' => $title,
            'instruction' => $instruction,
        ]);

        // 카드 업데이트
        $request->validate([
            'cards.*.word' => 'required|string',
            'cards.*.meaning' => 'required|string',
            'title' => 'required|string',
        ]);

        $cardsData = $request->input('cards');

        foreach ($cardsData as $data) {
            $id = $data['id'] ?? null;
            if($id) {
                Card::where('id', $id)->update([
                    'set_title' => $title,
                    'word' => $data['word'],
                    'meaning' => $data['meaning'],
                ]);
            } else {
                Card::create([
                    'set_title' => $title,
                    'word' => $data['word'],
                    'meaning' => $data['meaning'],
                ]);
            }
        }

        // 세트 아이디
        $set_id = Set::where('title', $title)->value('id');

        return redirect('set/show-set/' . $set_id);
    }

    // 만든 이 페이지
    public function Creator($name)
    {
        $profile = User::select('profile')->where('name', $name)->first();
        $email = User::select('email')->where('name', $name)->first()->email;
        $sets = Set::where('email', $email)->orderBy('created_at', 'desc')->get();
        $number_of_cards = Card::select('set_title', DB::raw('count(*) as count'))
                            ->groupBy('set_title')->orderBy('created_at')->get();

        return view('set/creator', compact('name', 'profile', 'sets', 'number_of_cards'));
    }

    public function searchCreator(Request $request)
    {
        $search_creator = $request->input('search_creator');
        $name = $request->input('name');
        $email = User::select('email')->where('name', $name)->first()->email;

        if($search_creator) {
            $results = Set::where('title', 'like', "%$search_creator%")->where('email', $email)->get();
        }

        return response()->json($results);
    }
}