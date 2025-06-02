<?php

namespace Infrastructure\Repositories;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Entities\User;
use Domain\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function findByUuid(string $uuid): ?User
    {
        return $this->em->getRepository(User::class)->findOneBy(['uuid' => $uuid]);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->em->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    public function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}
