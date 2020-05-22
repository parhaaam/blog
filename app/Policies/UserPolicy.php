<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
      if($user->role > 2){
        return Response::allow();
      }else {
        return Response::deny('شما مجوز لازم جهت دیدن این برگه‌را ندارید');
      }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
      if($user->id == $model->id || $user->role > 2){
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
      if($user->role > 2){
        return Response::allow();
      }else {
        return Response::deny('شما مجوز لازم جهت ثبت کاربر جدید را ندارید');
      }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
      if($user->id == $model->id || $user->role > 2){
        return Response::allow();
      }else {
        return Response::deny('شما مجوز لازم جهت دیدن این برگه‌را ندارید');
      }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
      if($user->role > 2){
        return Response::allow();
      }else {
        return Response::deny('شما مجوز لازم جهت ثبت کاربر جدید را ندارید');
      }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
