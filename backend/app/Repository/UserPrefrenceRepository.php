<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserPrefrence;

class UserPrefrenceRepository
{

    /**
     * Create or update a UserPrefrence
     * @param $sourceIds
     * @param $categoryIds
     * @param $authorIds
     * @param User $user
     * @return UserPrefrence $userPrefrence
     */
    public function createOrUpdateUserPrefrence(
        $sourceIds,
        $categoryIds,
        $authorIds,
        User $user
    ) {
        $userPrefrence = UserPrefrence::where(["user_id" => $user->id])->first();

        if (!$userPrefrence) {
            $userPrefrence = new UserPrefrence();
            $userPrefrence->user_id = $user->id;
        }
        
        if ($sourceIds !== null) {
            $userPrefrence->source_ids = $sourceIds;
        }

        if ($categoryIds !== null) {
            $userPrefrence->category_ids = $categoryIds;
        }

        if ($authorIds !== null) {
            $userPrefrence->author_ids = $authorIds;
        }

        $userPrefrence->save();

        return $userPrefrence;
    }

    /**
     * Get user prefrence related to provided user in params
     * @param User $user
     * @return UserPrefrence $userPrefrence
     */
    public function getUserPrefrence(User $user)
    {
        $userPrefrence = UserPrefrence::where(["user_id" => $user->id])->first();
        return $userPrefrence;
    }
}
