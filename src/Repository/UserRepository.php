<?php

namespace App\Repository;

/**
 * Class UserRepository
 * @package App\Repository
 */
class UserRepository extends BaseRepository
{

    private $urn = 'users';

    public function getAll($parameters = array())
    {
        return $this->query($this->urn, 'GET', $parameters);
    }

}