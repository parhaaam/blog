<?php

namespace App\Policies;

use App\Tag;
use App\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
      if($user->role > 1){
        return Response::allow();
      }else {
        return Response::deny('شما مجوز لازم جهت دیدن این برگه‌را ندارید');
      }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function view(User $user, Tag $tag)
    {
      if($user->role > 1){
        return Response::allow();
      }else {
        return Response::deny('شما مجوز لازم جهت دیدن این برگه‌را ندارید');
      }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      if($user->role > 1){
        return Response::allow();
      }else {
        return Response::deny('شما مجوز لازم جهت ثبت هشتگ جدید را ندارید');
      }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function update(User $user, Tag $tag)
    {
      if($user->role > 1){
        return Response::allow();
      }else {
        return Response::deny('شما مجوز لازم جهت ویرایش هشتگ را ندارید');
      }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function delete(User $user, Tag $tag)
    {
      if($user->role > 1){
        return Response::allow();
      }else {
        return Response::deny('شما مجوز لازم جهت حذف هشتگ را ندارید');
      }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function restore(User $user, Tag $tag)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function forceDelete(User $user, Tag $tag)
    {
        //
    }
}
