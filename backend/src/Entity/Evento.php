<?php

namespace App\Entity;

use App\Repository\EventoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert; //agregue la funcion 

#[ORM\Entity(repositoryClass: EventoRepository::class)]
class Evento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 25)]
    private ?string $tipoDeEvento = null;
 /**
     * @Assert\GreaterThanOrEqual("today")
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaInicio = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $horaInicio = null;
 /**
     * @Assert\GreaterThanOrEqual(propertyPath="fechaInicio")
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaFin = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $horaFin = null;

    #[ORM\OneToMany(mappedBy: 'evento', targetEntity: Imagen::class, orphanRemoval: true)]
    private Collection $imagens;

    #[ORM\ManyToOne(inversedBy: 'eventos')]
    private ?SalaDeEventos $salaDeEventos = null;

    #[ORM\ManyToOne(inversedBy: 'eventos')]
    private ?SalaDeEventos $salaDeEventos = null;

    //#[ORM\OneToMany(mappedBy: 'eventos', targetEntity: SalaDeEventos::class)]
    //private Collection $salaDeEventos;

    public function __construct()
    {
        $this->imagens = new ArrayCollection();
       // $this->salaDeEventos = new ArrayCollection();
    }

    public function __toString() {
        $fechaString=$this->fechaInicio->format('Y-m-d');
        $horaString=$this->horaInicio->format('H:i:s');
        return $this->nombre." ".$fechaString." ".$horaString;
    }

    public function __toString() {
        $fechaString=$this->fechaInicio->format('Y-m-d');
        $horaString=$this->horaInicio->format('H:i:s');
        return $this->nombre." ".$fechaString." ".$horaString;
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getTipoDeEvento(): ?string
    {
        return $this->tipoDeEvento;
    }

    public function setTipoDeEvento(string $tipoDeEvento): self
    {
        $this->tipoDeEvento = $tipoDeEvento;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(\DateTimeInterface $fechaInicio): self
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    public function getHoraInicio(): ?\DateTimeInterface
    {
        return $this->horaInicio;
    }

    public function setHoraInicio(\DateTimeInterface $horaInicio): self
    {
        $this->horaInicio = $horaInicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fechaFin;
    }

    public function setFechaFin(\DateTimeInterface $fechaFin): self
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    public function getHoraFin(): ?\DateTimeInterface
    {
        return $this->horaFin;
    }

    public function setHoraFin(\DateTimeInterface $horaFin): self
    {
        $this->horaFin = $horaFin;

        return $this;
    }

   
    /**
     * @return Collection<int, Imagen>
     */
    public function getImagens(): Collection
    {
        return $this->imagens;
    }

    public function addImagen(Imagen $imagen): self
    {
        if (!$this->imagens->contains($imagen)) {
            $this->imagens->add($imagen);
            $imagen->setEvento($this);
        }

        return $this;
    }

    public function removeImagen(Imagen $imagen): self
    {
        if ($this->imagens->removeElement($imagen)) {
            // set the owning side to null (unless already changed)
            if ($imagen->getEvento() === $this) {
                $imagen->setEvento(null);
            }
        }

        return $this;
    }

    public function getSalaDeEventos(): ?SalaDeEventos
    {
        return $this->salaDeEventos;
    }

    public function setSalaDeEventos(?SalaDeEventos $salaDeEventos): self
    {
        $this->salaDeEventos = $salaDeEventos;

        return $this;
    }

    public function getSalaDeEventos(): ?SalaDeEventos
    {
        return $this->salaDeEventos;
    }

    public function setSalaDeEventos(?SalaDeEventos $salaDeEventos): self
    {
        $this->salaDeEventos = $salaDeEventos;

        return $this;
    }
}
