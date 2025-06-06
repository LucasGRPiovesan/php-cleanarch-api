<?php

namespace Infrastructure\Repositories;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Entities\Profile;
use Domain\Repositories\ProfileRepositoryInterface;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function __construct(private EntityManagerInterface $em){}

    public function list(): array
    {
        return $this->em->getRepository(Profile::class)->findBy([
            'deleted_at' => null
        ]);
    }

    public function fetch(string $uuid): ?Profile
    {
        return $this->em->getRepository(Profile::class)->findOneBy([
            'uuid' => $uuid,
            'deleted_at' => null
        ]);
    }

    public function store(Profile $profile): Profile
    {
        $this->em->persist($profile);
        $this->em->flush();

        return $profile;
    }

    public function update(Profile $profile): Profile
    {
        $this->em->flush();
        return $profile;
    }

    public function delete(Profile $profile): void
    {
        $profile->setDeletedAt(new \DateTime());

        $this->em->persist($profile);
        $this->em->flush();
    }
}
