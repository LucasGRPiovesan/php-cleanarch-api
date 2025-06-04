<?php

namespace Domain\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "tb_profile")]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "guid", unique: true)]
    private string $uuid;

    #[ORM\Column(type: "string", length: 100)]
    private string $profile;

    #[ORM\Column(type: "string", nullable: true)]
    private ?string $description;

    #[ORM\Column(type: "datetime_immutable")]
    private \DateTimeImmutable $created_at;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTime $updated_at = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTime $deleted_at = null;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'profile')]
    private Collection $users;

    public function __construct(string $uuid, string $profile, ?string $description = null)
    {
        $this->uuid = $uuid;
        $this->profile = $profile;
        $this->description = $description;
        $this->created_at = new \DateTimeImmutable();
        $this->users = new ArrayCollection();
    }

    public function addUser(User $user): void
    {
        $this->users->add($user);
    }

    public function getUuid(): string 
    {
        return $this->uuid;    
    }

    public function getProfile(): string 
    {
        return $this->profile;    
    }

    public function getDescription(): string 
    {
        return $this->profile;    
    }

    public function getCreatedAt(): \DateTimeImmutable 
    {
        return $this->created_at;
    }
}
