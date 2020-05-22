<?php

namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function view(User $user, Post $post)
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
      if($user->role > 0){
        return Response::allow();
      }else {
        return Response::deny('ما مجوز لازم جهت ثبت پست را ندارید');
      }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        if($user->id == $post->user->id || $user->role > 1){
          return Response::allow();
        }else {
          return Response::deny('شما مجوز لازم جهت ویرایش این پست را ندارید');
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
      if($user->id == $post->user->id || $user->role > 1){
        return Response::allow();
      }else {
        return Response::deny('شما مجوز لازم جهت حذف این پست را ندارید');
      }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function restore(User $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can permanently submit the model.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function submit(User $user, Post $post)
    {
      if($user->role > 1){
        return Response::allow();
      }else {
        return Response::deny('شما مجوز لازم جهت انتشار این پست را ندارید');
      }
    }
}
