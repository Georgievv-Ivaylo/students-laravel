<?php

namespace app\Modules\FindFriends\Controllers;

class ViewController extends Controller
{

    public function welcome()
    {
        return view('FindFriends::welcome');
    }

    public function searchFriends($user_id = null)
    {
        $user = User::select('user_id as id', 'real_name as title', 'country as country_id')
        ->where('user_id', $user_id)
        ->with('country', 'friends', 'friends2')
        ->first();

        $suggestedFriends = [];
        if ($user) {
            $userFriends1 = $this->array_value_recursive('fr1', $user['friends2']->toArray());
            $userFriends2 = $this->array_value_recursive('fr2', $user['friends']->toArray());
            $userFriends = [];
            if (count($userFriends1) && count($userFriends2)) {
                $userFriends = array_merge($userFriends1, $userFriends2);
            } elseif (count($userFriends1)) {
                $userFriends = $userFriends1;
            } elseif (count($userFriends2)) {
                $userFriends = $userFriends2;
            }

            $suggestedFriends = User::select('user_id as id', 'real_name as title', 'country as country_id')
            ->where([
                ['country', 1],
                ['user_id', '<>', $user_id]
            ])
            ->whereNotIn('user_id', $userFriends)
            ->orderBy('real_name', 'asc')
            ->paginate(25);
        }
        return view('FindFriends::searchFriends', [
                        'friends' => $suggestedFriends,
                        'user' => $user
        ]);
    }

    public function array_value_recursive($key, array $arr)
    {
        $val = array();
        array_walk_recursive($arr, function($v, $k) use($key, &$val) {
            if($k == $key) array_push($val, $v);
        });
        return count($val) > 1 ? $val : array_pop($val);
    }
}
