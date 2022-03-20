<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FileRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: FileRepository::class)]
class File
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'text', length: 255, nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $filename;

    // #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "files")]
    // private $userId;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'fileBlock')]
    private $userBlock;

    #[ORM\OneToOne(targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $user;

    public function __construct()
    {
        $this->userBlock = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getfilename(): ?string
    {
        return $this->filename;
    }

    public function setfilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserBlock(): Collection
    {
        return $this->userBlock;
    }

    public function addUserBlock(User $userBlock): self
    {
        if (!$this->userBlock->contains($userBlock)) {
            $this->userBlock[] = $userBlock;
        }

        return $this;
    }

    public function removeUserBlock(User $userBlock): self
    {
        $this->userBlock->removeElement($userBlock);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
