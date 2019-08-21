<?php

namespace App\Policies;

use App\RolesAuthorization;
use App\SystemFeature;
use App\User;
use App\ShoppingCart;
use App\UsersAuthorization;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShoppingCartPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view the shopping cart.
     *
     * @param  \App\User  $user
     * @param  \App\ShoppingCart  $shoppingCart
     * @return mixed
     */
    public function viewProvisionColumn(User $user)
    {
        //** Take related system feature and corresponding authorization for roles and users from the DB.
        $systemFeature = SystemFeature::where('model', 'ShoppingCart')->where('action', 'ViewProvisionColumn')->first();
        $rolesAuthorizations = RolesAuthorization::where('system_feature_id', $systemFeature->id)->first();
        $usersAuthorizations = UsersAuthorization::where('system_feature_id', $systemFeature->id)->get();

        //** Populate $authorizedRoleIds array to determine authorized roles for the system feature */
        $authorizedRoleIds = array(1); // 1 indicating system admin is default element for all system feature
        if ($rolesAuthorizations->permission_of_role2 == 1) array_push($authorizedRoleIds, 2);
        if ($rolesAuthorizations->permission_of_role3 == 1) array_push($authorizedRoleIds, 3);
        if ($rolesAuthorizations->permission_of_role4 == 1) array_push($authorizedRoleIds, 4);
        if ($rolesAuthorizations->permission_of_role5 == 1) array_push($authorizedRoleIds, 5);
        if ($rolesAuthorizations->permission_of_role6 == 1) array_push($authorizedRoleIds, 6);

        //** Populate $authorizedRoleIds array to determine authorized roles for the system feature */
        $authorizedUserIDs = array();
        foreach($usersAuthorizations as $usersAuthorization ){
            array_push($authorizedUserIDs, $usersAuthorization->user_id);
        }

        //** Check if current user's role_id is in the $authorizedRoleIds array which includes all role ids that are authorized for the system feature
        // check if current user's id is in the $authorizedUserIDs array which includes all ids that are authorized for this system feature. */

        if (in_array($user->role_id, $authorizedRoleIds) || in_array($user->id, $authorizedUserIDs)){
            return true;
        }
    }
    /**
     * Determine whether the user can view the shopping cart.
     *
     * @param  \App\User  $user
     * @param  \App\ShoppingCart  $shoppingCart
     * @return mixed
     */
    public function view(User $user, ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Determine whether the user can create shopping carts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the shopping cart.
     *
     * @param  \App\User  $user
     * @param  \App\ShoppingCart  $shoppingCart
     * @return mixed
     */
    public function update(User $user, ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Determine whether the user can delete the shopping cart.
     *
     * @param  \App\User  $user
     * @param  \App\ShoppingCart  $shoppingCart
     * @return mixed
     */
    public function delete(User $user, ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Determine whether the user can restore the shopping cart.
     *
     * @param  \App\User  $user
     * @param  \App\ShoppingCart  $shoppingCart
     * @return mixed
     */
    public function restore(User $user, ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the shopping cart.
     *
     * @param  \App\User  $user
     * @param  \App\ShoppingCart  $shoppingCart
     * @return mixed
     */
    public function forceDelete(User $user, ShoppingCart $shoppingCart)
    {
        //
    }
}
