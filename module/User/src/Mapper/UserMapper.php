<?php

namespace User\Mapper;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Hydrator\HydratorInterface;
use LmcUser\Mapper\UserInterface;

class UserMapper implements UserInterface
{

    private TableGateway $tableGateway;

    private HydratorInterface $hydrator;

    public function __construct(TableGateway $tableGateway, HydratorInterface $hydrator)
    {
        $this->tableGateway = $tableGateway;
        $this->hydrator = $hydrator;
    }

    public function findByEmail($email)
    {
        $rowSet = $this->getTable()->select([
            'email' => $email,
        ]);
        return $rowSet->current();
    }

    public function findByUsername($username)
    {
        $rowSet = $this->getTable()->select([
            'username' => $username,
        ]);
        return $rowSet->current();
    }

    public function findById($id)
    {
        $rowSet = $this->getTable()->select([
            'user_id' => $id,
        ]);
        $user = $rowSet->current();
        return $user;
    }

    public function insert(\LmcUser\Entity\UserInterface $user)
    {
        $data = $this->getHydrator()->extract($user);
        $this->getTable()->insert($data);
        $id = $this->getTable()->lastInsertValue;
        return $this->findById($id);
    }

    public function update(\LmcUser\Entity\UserInterface $user)
    {
        $data = $this->getHydrator()->extract($user);
        $this->getTable()->update($data, [
            'user_id' => $user->getId(),
        ]);
        return $this->findById($user->getId());
    }

    private function getTable(): TableGateway
    {
        return $this->tableGateway;
    }

    private function getHydrator(): HydratorInterface
    {
        return $this->hydrator;
    }
}
