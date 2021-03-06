<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource(
* normalizationContext={"groups"={"user"}},
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"user:read", "user:item:get"}},
 *          },
 *          "put"={
 *              "access_control"="is_granted('POST_EDIT', object)",
 *              "access_control_message"="Accés non autorisé"
 *          },
 *          "delete"={"access_control"="is_granted('POST_EDIT',object)"}
 *     },
 *     collectionOperations={
 *          "get"={"access_control"="is_granted('ROLE_ADMIN')"},
 *          "post"={"access_control"="is_granted('POST_EDIT',object)"}
 *     }
 * 
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * 
 * @ApiResource(iri="http://schema.org/User")
 *  @UniqueEntity("email" , message="cette adresse email existe déja.")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Veuillez remplir ce champ")
      * @Groups({"user"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Veuillez remplir ce champ")
      * @Groups({"user"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message = "Veuillez saisir une adresse email valide ." )
      * @Groups({"user"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Veuillez remplir ce champ")
      * @Groups({"user"})
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
      * @Groups({"user"})
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message = "Veuillez remplir ce champ")
     * @Groups({"user"})
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="userPartenaire")
     */
    private $partenaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="userCreateur")
     */
    private $comptes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="userDepot")
     */
    private $depots;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Affectation", mappedBy="user")
     */
    private $affectations;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="userCreateur")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="userEnvoi")
     */
    private $transactionUserEnvoi;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="userRetrait")
     */
    private $transactionUserRetrait;

    public function __construct()
    {
        $this->isActive = true;
        $this->comptes = new ArrayCollection();
        $this->depots = new ArrayCollection();
        $this->affectations = new ArrayCollection();
        $this->transactionUserEnvoi = new ArrayCollection();
        $this->transactionUserRetrait = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function eraseCredentials()
    {
        return null;
    }
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }
    public function getUsername(): string
    {
        return (string) $this->email;
    }
    public function getRoles(): array
    {
        
        return [strtoupper($this->role->getLibelle())];
    }
    
    public function getSalt()
    {
        return null;

    }

    
    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }

    public function setPartenaire(?Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

        return $this;
    }

    /**
     * @return Collection|Compte[]
     */
    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function addCompte(Compte $compte): self
    {
        if (!$this->comptes->contains($compte)) {
            $this->comptes[] = $compte;
            $compte->setUserCreateur($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->comptes->contains($compte)) {
            $this->comptes->removeElement($compte);
            // set the owning side to null (unless already changed)
            if ($compte->getUserCreateur() === $this) {
                $compte->setUserCreateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Depot[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setUserDepot($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->contains($depot)) {
            $this->depots->removeElement($depot);
            // set the owning side to null (unless already changed)
            if ($depot->getUserDepot() === $this) {
                $depot->setUserDepot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Affectation[]
     */
    public function getAffectations(): Collection
    {
        return $this->affectations;
    }

    public function addAffectation(Affectation $affectation): self
    {
        if (!$this->affectations->contains($affectation)) {
            $this->affectations[] = $affectation;
            $affectation->setUser($this);
        }

        return $this;
    }

    public function removeAffectation(Affectation $affectation): self
    {
        if ($this->affectations->contains($affectation)) {
            $this->affectations->removeElement($affectation);
            // set the owning side to null (unless already changed)
            if ($affectation->getUser() === $this) {
                $affectation->setUser(null);
            }
        }

        return $this;
    }

    public function getUser(): ?Partenaire
    {
        return $this->user;
    }

    public function setUser(?Partenaire $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactionUserEnvoi(): Collection
    {
        return $this->transactionUserEnvoi;
    }

    public function addTransactionUserEnvoi(Transaction $transactionUserEnvoi): self
    {
        if (!$this->transactionUserEnvoi->contains($transactionUserEnvoi)) {
            $this->transactionUserEnvoi[] = $transactionUserEnvoi;
            $transactionUserEnvoi->setUserEnvoi($this);
        }

        return $this;
    }

    public function removeTransactionUserEnvoi(Transaction $transactionUserEnvoi): self
    {
        if ($this->transactionUserEnvoi->contains($transactionUserEnvoi)) {
            $this->transactionUserEnvoi->removeElement($transactionUserEnvoi);
            // set the owning side to null (unless already changed)
            if ($transactionUserEnvoi->getUserEnvoi() === $this) {
                $transactionUserEnvoi->setUserEnvoi(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactionUserRetrait(): Collection
    {
        return $this->transactionUserRetrait;
    }

    public function addTransactionUserRetrait(Transaction $transactionUserRetrait): self
    {
        if (!$this->transactionUserRetrait->contains($transactionUserRetrait)) {
            $this->transactionUserRetrait[] = $transactionUserRetrait;
            $transactionUserRetrait->setUserRetrait($this);
        }

        return $this;
    }

    public function removeTransactionUserRetrait(Transaction $transactionUserRetrait): self
    {
        if ($this->transactionUserRetrait->contains($transactionUserRetrait)) {
            $this->transactionUserRetrait->removeElement($transactionUserRetrait);
            // set the owning side to null (unless already changed)
            if ($transactionUserRetrait->getUserRetrait() === $this) {
                $transactionUserRetrait->setUserRetrait(null);
            }
        }

        return $this;
    }
    
    
}
