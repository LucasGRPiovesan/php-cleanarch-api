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
        return $this->em->getRepository(Profile::class)->findAll();
    }

    public function fetch(string $uuid): ?Profile
    {
        return $this->em->getRepository(Profile::class)->findOneBy(['uuid' => $uuid]);
    }

    public function store(Profile $profile): Profile
    {
        $this->em->persist($profile);
        $this->em->flush();

        return $profile;
    }
}
