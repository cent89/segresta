<?php
namespace App\Traits;

trait MyEntrustUserTrait
{
  /**
   *Filtering users according to their role
   *
   *@param string $role
   *@return users collection
   */
  public function scopeWithRole($query, $role)
  {
      return $query->whereHas('roles', function ($query) use ($role)
      {
          $query->where('name', $role);
      });
  }
}
