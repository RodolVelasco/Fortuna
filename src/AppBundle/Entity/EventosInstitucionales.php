<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EventosInstitucionales
 *
 * @ORM\Table(name="eventos_institucionales")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventosInstitucionalesRepository")
 */
class EventosInstitucionales
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_institucion", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $nombreInstitucion;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion_responsable_programa", type="text")
     * @Assert\NotBlank()
     */
    private $direccionResponsablePrograma;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_programa", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $nombrePrograma;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_contacto_responsable_programa", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $nombreContactoResponsablePrograma;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_contacto_responsable_programa", type="string", length=15)
     * @Assert\NotBlank()
     */
    private $telefonoContactoResponsablePrograma;

    /**
     * @var string
     *
     * @ORM\Column(name="email_contacto_responsable_programa", type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "El email '{{ value }}' no es válido.",
     *     checkMX = true
     * )
     */
    private $emailContactoResponsablePrograma;

    /**
     * @var string
     *
     * @ORM\Column(name="actividad", type="text")
     * @Assert\NotBlank()
     */
    private $actividad;

    /**
     * @var string
     *
     * @ORM\Column(name="departamento", type="string", length=50)
     * @Assert\NotBlank()
     */
    private $departamento;

    /**
     * @var string
     *
     * @ORM\Column(name="lugar", type="text")
     * @Assert\NotBlank()
     */
    private $lugar;

    /**
     * @var \Date
     *
     * @ORM\Column(name="fecha", type="date")
     * @Assert\NotBlank()
     */
    private $fecha;

    /**
     * @var int
     *
     * @ORM\Column(name="hora", type="integer")
     * @Assert\NotBlank()
     */
    private $hora;

    /**
     * @var int
     *
     * @ORM\Column(name="minuto", type="integer")
     * @Assert\NotBlank()
     */
    private $minuto;

    /**
     * @var string
     *
     * @ORM\Column(name="poblacion_objetivo", type="text")
     * @Assert\NotBlank()
     */
    private $poblacionObjetivo;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_participantes", type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 1,
     *      max = 10000,
     *      minMessage = "El número menor a ingresar debe ser al menos {{ limit }}",
     *      maxMessage = "El número mayor a ingresar es {{ limit }}"
     * )
     */
    private $numeroParticipantes;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_contacto_responsable_actividad", type="string", length=50)
     * @Assert\NotBlank()
     */
    private $nombreContactoResponsableActividad;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_contacto_responsable_actividad", type="string", length=15)
     * @Assert\NotBlank()
     */
    private $telefonoContactoResponsableActividad;

    /**
     * @var string
     *
     * @ORM\Column(name="email_contacto_responsable_actividad", type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Email(
         *     message = "El email '{{ value }}' no es válido.",
     *     checkMX = true
     * )
     */
    private $emailContactoResponsableActividad;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="eventosInstitucionales")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     */
    protected $user;

    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombreInstitucion
     *
     * @param string $nombreInstitucion
     *
     * @return EventosInstitucionales
     */
    public function setNombreInstitucion($nombreInstitucion)
    {
        $this->nombreInstitucion = $nombreInstitucion;

        return $this;
    }

    /**
     * Get nombreInstitucion
     *
     * @return string
     */
    public function getNombreInstitucion()
    {
        return $this->nombreInstitucion;
    }

    /**
     * Set direccionResponsablePrograma
     *
     * @param string $direccionResponsablePrograma
     *
     * @return EventosInstitucionales
     */
    public function setDireccionResponsablePrograma($direccionResponsablePrograma)
    {
        $this->direccionResponsablePrograma = $direccionResponsablePrograma;

        return $this;
    }

    /**
     * Get direccionResponsablePrograma
     *
     * @return string
     */
    public function getDireccionResponsablePrograma()
    {
        return $this->direccionResponsablePrograma;
    }

    /**
     * Set nombrePrograma
     *
     * @param string $nombrePrograma
     *
     * @return EventosInstitucionales
     */
    public function setNombrePrograma($nombrePrograma)
    {
        $this->nombrePrograma = $nombrePrograma;

        return $this;
    }

    /**
     * Get nombrePrograma
     *
     * @return string
     */
    public function getNombrePrograma()
    {
        return $this->nombrePrograma;
    }

    /**
     * Set nombreContactoResponsablePrograma
     *
     * @param string $nombreContactoResponsablePrograma
     *
     * @return EventosInstitucionales
     */
    public function setNombreContactoResponsablePrograma($nombreContactoResponsablePrograma)
    {
        $this->nombreContactoResponsablePrograma = $nombreContactoResponsablePrograma;

        return $this;
    }

    /**
     * Get nombreContactoResponsablePrograma
     *
     * @return string
     */
    public function getNombreContactoResponsablePrograma()
    {
        return $this->nombreContactoResponsablePrograma;
    }

    /**
     * Set telefonoContactoResponsablePrograma
     *
     * @param string $telefonoContactoResponsablePrograma
     *
     * @return EventosInstitucionales
     */
    public function setTelefonoContactoResponsablePrograma($telefonoContactoResponsablePrograma)
    {
        $this->telefonoContactoResponsablePrograma = $telefonoContactoResponsablePrograma;

        return $this;
    }

    /**
     * Get telefonoContactoResponsablePrograma
     *
     * @return string
     */
    public function getTelefonoContactoResponsablePrograma()
    {
        return $this->telefonoContactoResponsablePrograma;
    }

    /**
     * Set emailContactoResponsablePrograma
     *
     * @param string $emailContactoResponsablePrograma
     *
     * @return EventosInstitucionales
     */
    public function setEmailContactoResponsablePrograma($emailContactoResponsablePrograma)
    {
        $this->emailContactoResponsablePrograma = $emailContactoResponsablePrograma;

        return $this;
    }

    /**
     * Get emailContactoResponsablePrograma
     *
     * @return string
     */
    public function getEmailContactoResponsablePrograma()
    {
        return $this->emailContactoResponsablePrograma;
    }

    /**
     * Set actividad
     *
     * @param string $actividad
     *
     * @return EventosInstitucionales
     */
    public function setActividad($actividad)
    {
        $this->actividad = $actividad;

        return $this;
    }

    /**
     * Get actividad
     *
     * @return string
     */
    public function getActividad()
    {
        return $this->actividad;
    }

    /**
     * Set departamento
     *
     * @param string $departamento
     *
     * @return EventosInstitucionales
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return string
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * Set lugar
     *
     * @param string $lugar
     *
     * @return EventosInstitucionales
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;

        return $this;
    }

    /**
     * Get lugar
     *
     * @return string
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * Set fecha
     *
     * @param \Date $fecha
     *
     * @return EventosInstitucionales
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \Date
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set hora
     *
     * @param integer $hora
     *
     * @return EventosInstitucionales
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return int
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set minuto
     *
     * @param integer $minuto
     *
     * @return EventosInstitucionales
     */
    public function setMinuto($minuto)
    {
        $this->minuto = $minuto;

        return $this;
    }

    /**
     * Get minuto
     *
     * @return int
     */
    public function getMinuto()
    {
        return $this->minuto;
    }

    /**
     * Set poblacionObjetivo
     *
     * @param string $poblacionObjetivo
     *
     * @return EventosInstitucionales
     */
    public function setPoblacionObjetivo($poblacionObjetivo)
    {
        $this->poblacionObjetivo = $poblacionObjetivo;

        return $this;
    }

    /**
     * Get poblacionObjetivo
     *
     * @return string
     */
    public function getPoblacionObjetivo()
    {
        return $this->poblacionObjetivo;
    }

    /**
     * Set numeroParticipantes
     *
     * @param integer $numeroParticipantes
     *
     * @return EventosInstitucionales
     */
    public function setNumeroParticipantes($numeroParticipantes)
    {
        $this->numeroParticipantes = $numeroParticipantes;

        return $this;
    }

    /**
     * Get numeroParticipantes
     *
     * @return int
     */
    public function getNumeroParticipantes()
    {
        return $this->numeroParticipantes;
    }

    /**
     * Set nombreContactoResponsableActividad
     *
     * @param string $nombreContactoResponsableActividad
     *
     * @return EventosInstitucionales
     */
    public function setNombreContactoResponsableActividad($nombreContactoResponsableActividad)
    {
        $this->nombreContactoResponsableActividad = $nombreContactoResponsableActividad;

        return $this;
    }

    /**
     * Get nombreContactoResponsableActividad
     *
     * @return string
     */
    public function getNombreContactoResponsableActividad()
    {
        return $this->nombreContactoResponsableActividad;
    }

    /**
     * Set telefonoContactoResponsableActividad
     *
     * @param string $telefonoContactoResponsableActividad
     *
     * @return EventosInstitucionales
     */
    public function setTelefonoContactoResponsableActividad($telefonoContactoResponsableActividad)
    {
        $this->telefonoContactoResponsableActividad = $telefonoContactoResponsableActividad;

        return $this;
    }

    /**
     * Get telefonoContactoResponsableActividad
     *
     * @return string
     */
    public function getTelefonoContactoResponsableActividad()
    {
        return $this->telefonoContactoResponsableActividad;
    }

    /**
     * Set emailContactoResponsableActividad
     *
     * @param string $emailContactoResponsableActividad
     *
     * @return EventosInstitucionales
     */
    public function setEmailContactoResponsableActividad($emailContactoResponsableActividad)
    {
        $this->emailContactoResponsableActividad = $emailContactoResponsableActividad;

        return $this;
    }

    /**
     * Get emailContactoResponsableActividad
     *
     * @return string
     */
    public function getEmailContactoResponsableActividad()
    {
        return $this->emailContactoResponsableActividad;
    }




    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return EventosInstitucionales
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
