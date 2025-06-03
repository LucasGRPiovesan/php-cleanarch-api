<?php

namespace Infrastructure\Database\Seeds;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\{FixtureInterface, DependentFixtureInterface};
use Doctrine\Persistence\ObjectManager;
use Domain\Entities\{Profile, User};
use Ramsey\Uuid\Uuid;

class UserFixture extends AbstractFixture implements FixtureInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        try {

            /** @var Profile $profile */
            $profile = $this->getReference('admin', Profile::class);
    
            $user = new User(
                Uuid::uuid4()->toString(),
                'João Silva',
                'joao@email.com',
                password_hash('123456', PASSWORD_DEFAULT),
                $profile
            );
    
            $manager->persist($user);
            $manager->flush();
    
            echo "✅ Users seeded successfully" . PHP_EOL;

        } catch (\Throwable $th) {
            
            echo "❌ Error on seed Users" . PHP_EOL;
            echo $th->getMessage() . PHP_EOL;
        }
    }

    public function getDependencies(): array
    {
        return [ProfileFixture::class];
    }
}
