<?php

namespace Infrastructure\Repositories;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Entities\User;
use Domain\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private EntityManagerInterface $em){}

    public function findByUuid(string $uuid): ?User
    {
        return $this->em->getRepository(User::class)->findOneBy(['uuid' => $uuid]);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->em->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    public function list(): array
    {
        return $this->em->getRepository(User::class)->findBy([
            'deleted_at' => null
        ]);
    }

    public function fetch(string $uuid): ?User
    {
        return $this->em->getRepository(User::class)->findOneBy([
            'uuid' => $uuid,
            'deleted_at' => null
        ]);
    }

    public function store(User $user): User
    {
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function update(User $user): User
    {
        $this->em->flush();
        return $user;
    }

    public function delete(User $user): void
    {
        $user->setDeletedAt(new \DateTime());

        $this->em->persist($user);
        $this->em->flush();
    }
}
