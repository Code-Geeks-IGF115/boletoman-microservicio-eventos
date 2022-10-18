<?php

namespace App\Entity;

use App\Repository\CategoriaEventoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoriaEventoRepository::class)]
class CategoriaEvento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['ver_evento'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['ver_evento'])]
    private ?string $nombre = null;
    
    #[ORM\OneToMany(mappedBy: 'categoria', targetEntity: Evento::class)]
    private Collection $eventos;

    public function __construct()
    {
        $this->eventos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, Evento>
     */
    public function getEventos(): Collection
    {
        return $this->eventos;
    }

    public function addEvento(Evento $evento): self
    {
        if (!$this->eventos->contains($evento)) {
            $this->eventos->add($evento);
            $evento->setCategoria($this);
        }

        return $this;
    }

    public function removeEvento(Evento $evento): self
    {
        if ($this->eventos->removeElement($evento)) {
            // set the owning side to null (unless already changed)
            if ($evento->getCategoria() === $this) {
                $evento->setCategoria(null);
            }
        }

        return $this;
    }
}
