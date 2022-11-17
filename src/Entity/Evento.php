<?php

namespace App\Entity;

use App\Repository\EventoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime; 

#[ORM\Entity(repositoryClass: EventoRepository::class)]
class Evento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['ver_evento'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['ver_evento'])]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    #[Groups(['ver_evento'])]
    private ?string $descripcion = null;

    #[ORM\Column(length: 25)]
    #[Groups(['ver_evento'])]
    private ?string $tipoDeEvento = null;
 /**
     * @Assert\GreaterThanOrEqual("today")
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['ver_evento'])]
    private ?DateTime $fechaInicio = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Groups(['ver_evento'])]
    private ?DateTime $horaInicio = null;
 /**
     * @Assert\GreaterThanOrEqual(propertyPath="fechaInicio")
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['ver_evento'])]
    private ?DateTime $fechaFin = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Groups(['ver_evento'])]
    private ?DateTime $horaFin = null;

    #[ORM\OneToMany(mappedBy: 'evento', targetEntity: Imagen::class, orphanRemoval: true)]
    private Collection $imagens;

    #[ORM\Column(nullable:true)]     
    private ?int $sala_de_eventos_id = null;

    #[ORM\ManyToOne(inversedBy: 'eventos')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['ver_evento'])]
    private ?CategoriaEvento $categoria = null;

    #[ORM\OneToMany(mappedBy: 'evento', targetEntity: Frecuencia::class, orphanRemoval: true)]
    private Collection $concurrencia;

    #[ORM\Column(nullable: true)]
    private ?int $idUsuario = null;

    public function __construct()
    {
        $this->imagens = new ArrayCollection();
        $this->concurrencia = new ArrayCollection();
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

    public function getFechaInicio(): ?DateTime
    {
        return $this->fechaInicio;
    }

    public function getHoraInicio(): ?DateTime
    {
        return $this->horaInicio;
    }

    public function getFechaFin(): ?DateTime
    {
        return $this->fechaFin;
    }

    public function getHoraFin(): ?DateTime
    {
        return $this->horaFin;
    }

    //conviertiendo a DateTime
    public function setHoraInicio(string $horaInicio=null): self
    {
        if($horaInicio){
            $this->horaInicio = date_create( $horaInicio);
        }else{
            $this->horaInicio=$horaInicio;
        }
        return $this;
    }

    public function setHoraFin(string $horaFin): self
    {
        if($horaFin){
            $this->horaFin = date_create($horaFin);
        }else{
            $this->horaFin=$horaFin;
        }
        return $this;
    }

    public function setFechaInicio(string $fechaInicio): self
    {
        if($fechaInicio){
            $this->fechaInicio =date_create($fechaInicio);
        }else{
            $this->fechaInicio=$fechaInicio;
        }
        return $this;
    }

    public function setFechaFin(string $fechaFin): self
    {
        if($fechaFin){
            $this->fechaFin = date_create($fechaFin);
        }else{
            $this->fechaFin=$fechaFin;
        }
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

    public function getSalaDeEventosID(): ?int
    {
        return $this->sala_de_eventos_id;
    }

    public function setSalaDeEventosID(?int $sala_de_eventos_id): self
    {
        $this->sala_de_eventos_id = $sala_de_eventos_id;

        return $this;
    }

    public function getCategoria(): ?CategoriaEvento
    {
        return $this->categoria;
    }

    public function setCategoria(?CategoriaEvento $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * @return Collection<int, Frecuencia>
     */
    public function getConcurrencia(): Collection
    {
        return $this->concurrencia;
    }

    public function addConcurrencium(Frecuencia $concurrencium): self
    {
        if (!$this->concurrencia->contains($concurrencium)) {
            $this->concurrencia->add($concurrencium);
            $concurrencium->setEvento($this);
        }

        return $this;
    }

    public function removeConcurrencium(Frecuencia $concurrencium): self
    {
        if ($this->concurrencia->removeElement($concurrencium)) {
            // set the owning side to null (unless already changed)
            if ($concurrencium->getEvento() === $this) {
                $concurrencium->setEvento(null);
            }
        }

        return $this;
    }

    public function getIdUsuario(): ?int
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(?int $idUsuario): self
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

}
