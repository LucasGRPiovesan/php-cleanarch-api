<?php

namespace Domain\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "tb_user")]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "guid", unique: true)]
    private string $uuid;

    #[ORM\Column(type: "string", length: 100)]
    private string $name;

    #[ORM\Column(type: "string", unique: true)]
    private string $email;

    #[ORM\Column(type: "string")]
    private string $password;

    #[ORM\Column(type: "datetime_immutable")]
    private \DateTimeImmutable $created_at;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTime $updated_at = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTime $deleted_at = null;

    #[ORM\ManyToOne(targetEntity: Profile::class, inversedBy: 'users', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'id_profile', referencedColumnName: 'id', nullable: false)]
    private Profile $profile;

    public function __construct(string $uuid, string $name, string $email, string $password, Profile $profile)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->profile = $profile;
        $this->created_at = new \DateTimeImmutable();
    }

    public function getUuid(): string 
    {
        return $this->uuid;    
    }

    public function getName(): string 
    {
        return $this->name;    
    }

    public function getEmail(): string 
    {
        return $this->email;    
    }

    public function getProfile(): Profile 
    {
        return $this->profile;
    }

    public function getCreatedAt(): \DateTimeImmutable 
    {
        return $this->created_at;
    }
}
