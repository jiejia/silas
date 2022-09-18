<?php
namespace App\Common\Repositories;

use App\Common\Repositories\Repository;
use App\Models\User;

class UserRepository extends Repository
{
    protected string $model = User::class;
}
