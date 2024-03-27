<?php

namespace User\Mapper;

use Laminas\Hydrator\HydratorInterface;
use LmcUser\Entity\UserInterface as UserEntityInterface;
use LmcUser\Mapper\Exception\InvalidArgumentException;

class UserHydrator implements HydratorInterface
{

    private HydratorInterface $hydrator;

    public function __construct(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    public function extract(object $object): array
    {
        if (!$object instanceof UserEntityInterface) {
            throw new InvalidArgumentException('$object must be an instance of LmcUser\Entity\UserInterface');
        }

        /** @var \User\Entity\User $object */
        $data = $this->hydrator->extract($object);

        // get the firstname and lastname. Assume the pattern is 'first_name last_name'
        $array = explode(' ', $data['full_name']);
        $data['first_name'] = $array[0];
        $data['last_name'] = $array[1];
        unset($data['full_name']);

        // This part comes from the LmcUser User hydrator and we need to keep it
        if ($data['id'] !== null) {
            $data = $this->mapField('id', 'user_id', $data);
        } else {
            unset($data['id']);
        }

        return $data;
    }

    public function hydrate(array $data, object $object)
    {
        if (!$object instanceof UserEntityInterface) {
            throw new InvalidArgumentException('$object must be an instance of LmcUser\Entity\UserInterface');
        }

        // This part comes from the LmcUser User hydrator and we need to keep it
        $data = $this->mapField('user_id', 'id', $data);

        $data['fullname'] = $data['first_name'] . ' ' . $data['last_name'];
        unset($data['first_name']);
        unset($data['last_name']);

        return $this->hydrator->hydrate($data, $object);
    }

    protected function mapField(string $keyFrom, string$keyTo, array $array): array
    {
        $array[$keyTo] = $array[$keyFrom];
        unset($array[$keyFrom]);

        return $array;
    }

}
