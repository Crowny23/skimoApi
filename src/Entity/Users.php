<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ApiResource]
class Users implements UserInterface, PasswordAuthenticatedUserInterface, JWTUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $fullname = null;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Histories::class)]
    private Collection $histories;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: RatingComs::class)]
    private Collection $ratingComs;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    public function __construct()
    {
        $this->histories = new ArrayCollection();
        $this->ratingComs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * @return Collection<int, Histories>
     */
    public function getHistories(): Collection
    {
        return $this->histories;
    }

    public function addHistory(Histories $history): self
    {
        if (!$this->histories->contains($history)) {
            $this->histories->add($history);
            $history->setUsers($this);
        }

        return $this;
    }

    public function removeHistory(Histories $history): self
    {
        if ($this->histories->removeElement($history)) {
            // set the owning side to null (unless already changed)
            if ($history->getUsers() === $this) {
                $history->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RatingComs>
     */
    public function getRatingComs(): Collection
    {
        return $this->ratingComs;
    }

    public function addRatingCom(RatingComs $ratingCom): self
    {
        if (!$this->ratingComs->contains($ratingCom)) {
            $this->ratingComs->add($ratingCom);
            $ratingCom->setUsers($this);
        }

        return $this;
    }

    public function removeRatingCom(RatingComs $ratingCom): self
    {
        if ($this->ratingComs->removeElement($ratingCom)) {
            // set the owning side to null (unless already changed)
            if ($ratingCom->getUsers() === $this) {
                $ratingCom->setUsers(null);
            }
        }

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public static function createFromPayload($email, array $payload)
    {
        $user = new Users();
        $user->setEmail($email);
        return $user;
    }

}
