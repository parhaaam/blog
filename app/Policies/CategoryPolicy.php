<?php

namespace App\Policies;

use App\Category;
use App\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
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
     * @param  \App\Category  $category
     * @return mixed
     */
    public function view(User $user, Category $category)
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
        return Response::deny('شما مجوز لازم جهت ایجاد دسته‌بندی را ندارید');
      }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Category  $category
     * @return mixed
     */
    public function update(User $user, Category $category)
    {
      if($user->role > 1){
        return Response::allow();
      }else {
        return Response::deny('شما مجوز لازم جهت ویرایش دسته‌بندی ندارید');
      }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Category  $category
     * @return mixed
     */
    public function delete(User $user, Category $category)
    {
      if($user->role > 1){
        return Response::allow();
      }else {
        return Response::deny('شما مجوز لازم جهت ایجاد حذف دسته‌بندی ندارید');
      }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Category  $category
     * @return mixed
     */
    public function restore(User $user, Category $category)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Category  $category
     * @return mixed
     */
    public function forceDelete(User $user, Category $category)
    {
        //
    }
}
