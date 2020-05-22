<?php

namespace App\Policies;

use App\Comment;
use App\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
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
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function view(User $user, Comment $comment)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
      if($user->role > 1){
        return Response::allow();
      }else {
        return Response::deny('شما مجوز لازم جهت انتشار نظر را ندارید');
      }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
      if($user->role > 1){
        return Response::allow();
      }else {
        return Response::deny('شما مجوز لازم جهت حذف نظر را ندارید');
      }
    }

    /**
     * Determine whether the user can mark the comment as spam
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function spam(User $user, Comment $comment)
    {
      if($user->role > 1){
        return Response::allow();
      }else {
        return Response::deny('شما مجوز لازم جهت اسپم کردن این نظر ندارید');
      }
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function forceDelete(User $user, Comment $comment)
    {
        //
    }
}
