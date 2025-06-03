<?php

namespace Infrastructure\Database\Seeds;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Domain\Entities\Profile;
use Ramsey\Uuid\Uuid;

class ProfileFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        try {
            
            $profile = new Profile(
                Uuid::uuid4()->toString(),
                'admin',
                'Administrador do sistema'
            );
    
            $manager->persist($profile);
            $manager->flush();
            
            // Guarda a referência para uso em outros fixtures
            $this->addReference('admin', $profile);
            echo "✅ Profiles seeded successfully" . PHP_EOL;

        } catch (\Throwable $th) {
            
            echo "❌ Error on seed Profiles" . PHP_EOL;
            echo $th->getMessage() . PHP_EOL; 
        }
    }
}
