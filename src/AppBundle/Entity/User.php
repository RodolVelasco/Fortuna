<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;
// DON'T forget this use statement!!!
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="UserRepository"))
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("dui", message="Este número de DUI ya está registrado")
 * @UniqueEntity("telefono", message="Este número de teléfono ya está registrado")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\RandomIdGenerator")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(groups={"Profile", "ResetPassword", "Registration", "ChangePassword"}))
     * @Assert\NotNull(groups={"Profile", "ResetPassword", "Registration", "ChangePassword"}))
     * @Assert\Length(
     *      min = 3,
     *      max = 30,
     *      minMessage = "Tu nombre debe tener al menos {{ limit }} letras",
     *      maxMessage = "Tu nombre no debe tener más de  {{ limit }} letras",
     *      groups={"Profile", "ResetPassword", "Registration", "ChangePassword"})
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(groups={"Profile", "ResetPassword", "Registration", "ChangePassword"}))
     * @Assert\NotNull(groups={"Profile", "ResetPassword", "Registration", "ChangePassword"}))
     * @Assert\Length(
     *      min = 4,
     *      max = 30,
     *      minMessage = "Tu apellido debe tener al menos {{ limit }} letras",
     *      maxMessage = "Tu apellido no debe tener más de  {{ limit }} letras",
     *      groups={"Profile", "ResetPassword", "Registration", "ChangePassword"})
     */
    protected $apellido;

    /**
     * @var string $telefono
     *
     * @ORM\Column(name="telefono", type="string", length=45, nullable=false)
     * @Assert\NotBlank(groups={"Profile", "ResetPassword", "Registration"}))
     * @Assert\NotNull(groups={"Profile", "ResetPassword", "Registration"}))
     * @Assert\Length(
     *      min = 9,
     *      max = 9,
     *      exactMessage = "Tu número telefónico debe tener exactamente {{ limit }} números",
     *      groups={"Profile", "ResetPassword", "Registration"})
     */
    private $telefono;

    /**
     * @var string $dui
     *
     * @ORM\Column(name="dui", type="string", length=45, nullable=false)
     * @Assert\NotBlank(groups={"Profile", "ResetPassword", "Registration"}))
     * @Assert\NotNull(groups={"Profile", "ResetPassword", "Registration"}))
     * @Assert\Length(
     *      min = 10,
     *      max = 10,
     *      exactMessage = "Tu número de DUI debe tener exactamente {{ limit }} números",
     *      groups={"Profile", "ResetPassword", "Registration"})
     *
     */
    private $dui;

    /**
     * @Assert\NotBlank(groups={"ResetPassword", "Registration", "ChangePassword"}))
     * @Assert\NotNull(groups={"ResetPassword", "Registration", "ChangePassword"}))
     * @Assert\Length(
     *     min = 5,
     *     max = 20,
     *     minMessage="Tu contraseña debe tener al menos {{ limit }} letras",
     *     maxMessage="Tu contraseña no debe tener más de {{ limit }} letras",
     *     groups={"Profile", "ResetPassword", "Registration", "ChangePassword"})
     */
    protected $plainPassword;
/*    * @Assert\Regex(
    *     pattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{8,100}$/",
    *     message="Tu contraseña debe tener caracteres especiales, aA-zZ y números 0-9",
    *     groups={"Profile", "ResetPassword", "Registration", "ChangePassword"})
*/

    /**
     * @Assert\NotBlank(groups={"Profile", "ResetPassword", "Registration", "ChangePassword"}))
     * @Assert\NotNull(groups={"Profile", "ResetPassword", "Registration", "ChangePassword"}))
     * @Assert\Length(
     *     min = 3,
     *     max = 25,
     *     minMessage="Tu nombre de usuario debe tener al menos {{ limit }} letras",
     *     maxMessage="Tu nombre de usuario no debe tener más de {{ limit }} letras",
     *     groups={"Profile", "ResetPassword", "Registration", "ChangePassword"})
     */
    protected $username;

    /**
     * @Assert\NotBlank(groups={"Profile", "ResetPassword", "Registration"}))
     * @Assert\NotNull(groups={"Profile", "ResetPassword", "Registration"}))
     * @Assert\Length(
     *     min = 14,
     *     max = 50,
     *     minMessage="Tu correo electrónico debe tener al menos {{ limit }} letras",
     *     maxMessage="Tu correo electrónico no debe tener más de {{ limit }} letras",
     *     groups={"Profile", "ResetPassword", "Registration"})
     * @Assert\Email(
     *     message = "El correo electrónico '{{ value }}' no es válido",
     *     checkMX = true,
     *     groups={"Profile", "ResetPassword", "Registration"}))
     */
    protected $email;

    /**
     * @var \Date
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=false)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $fechaNacimiento;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sexo", type="boolean", nullable=false)
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="departamento_municipio", type="string", length=100, options={"default" : "San Salvador - San Salvador"}, nullable=true)
     */
    private $departamentoMunicipio;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion_primaria", type="text", nullable=true)
     */
    private $direccionPrimaria;

    /**
     * @var integer
     *
     * @ORM\Column(name="saldo_principal", type="integer", length=2, nullable=false, options={"default" : 0})
     *
     */
    private $saldoPrincipal;

    /**
     * @var integer
     *
     * @ORM\Column(name="saldo_bono", type="integer", length=2, nullable=false, options={"default" : 0})
     *
     */
    private $saldoBono;

    /**
     * @var integer
     *
     * @ORM\Column(name="saldo_promocional", type="integer", length=2, nullable=false, options={"default" : 0})
     *
     */
    private $saldoPromocional;

    /**
     * @var integer
     *
     * @ORM\Column(name="contador_fallo_recarga", type="integer", length=1, nullable=false, options={"default" : 0})
     *
     */
    private $contadorFalloRecarga;

    /**
     * @var \DateTime $fechaCreacion
     *
     * @ORM\Column(name="fecha_creacion", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $fechaCreacion;

    /**
     * @var \DateTime $ultimaActividad
     *
     * @ORM\Column(name="fecha_ultima_actividad", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $fechaUltimaActividad;

    /**
    * @ORM\OneToOne(targetEntity="AppBundle\Entity\image", cascade={"remove", "persist"})
    */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\EventosInstitucionales", mappedBy="user")
     */
    protected $eventosInstitucionales;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Participa", mappedBy="user")
     */
    protected $participantes;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Sorteo", mappedBy="ganador")
     */
    protected $ganadores;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Sorteo", mappedBy="creador")
     */
    protected $creadores;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Recarga", mappedBy="recargador")
     */
    protected $recargadores;

    public function __construct()
    {
        parent::__construct();
        $this->fechaCreacion = new \DateTime;
        $this->fechaUltimaActividad = new \DateTime;
        $this->image = new \AppBundle\Entity\image();
        $this->saldoPrincipal=0;
        $this->saldoBono=0;
        $this->saldoPromocional=0;
        $this->contadorFalloRecarga=0;
        $this->participantes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ganadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->creadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recargadores = new \Doctrine\Common\Collections\ArrayCollection();

        $this->addRole("ROLE_USER");
        $this->eventosInstitucionales = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getFullName()
    {
        //return $this->family_name.' '.$this->first_name;
        if(in_array('ROLE_ADMIN', $this->roles)){
            return "Fortuna";
        }else{
            return $this->nombre.' '.$this->apellido;
        }
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return User
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     *
     * @return User
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return profile
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set dui
     *
     * @param string $dui
     * @return profile
     */
    public function setDui($dui)
    {
        $this->dui = $dui;

        return $this;
    }

    /**
     * Get dui
     *
     * @return string
     */
    public function getDui()
    {
        return $this->dui;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return User
     */
    public function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaUltimaActividad
     *
     * @param \DateTime $fechaUltimaActividad
     * @return User
     */
    public function setFechaUltimaActividad($fechaUltimaActividad) {
        $this->fechaUltimaActividad = $fechaUltimaActividad;

        return $this;
    }

    /**
     * Get fechaUltimaActividad
     *
     * @return \DateTime
     */
    public function getFechaUltimaActividad() {
        return $this->fechaUltimaActividad;
    }

    /**
     * Set fechaUltimaActividad
     *
     * @param \DateTime $fechaUltimaActividad
     * @return User
     */
    public function isActiveNow() {
        $this->fechaUltimaActividad = new \DateTime();

        return $this;
    }

    /**
     * Set image
     *
     * @param \AppBundle\Entity\image $image
     * @return profile
     */
    public function setImage(\AppBundle\Entity\image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AppBundle\Entity\image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar() {

        return $this->image->getWebPath();
    }

    /**
     * Get the most significant role
     *
     * @return string
     */
    public function getRole()
    {
        if(in_array('ROLE_ADMIN', $this->roles)) $role = 'Fortuna Admin';
        else if(in_array('ROLE_MANAGER', $this->roles)) $role = 'Empresarial';
        else $role = 'aFortunado';
        return $role;
    }

    /**
     * Add eventosInstitucionale
     *
     * @param \AppBundle\Entity\EventosInstitucionales $eventosInstitucionale
     *
     * @return User
     */
    public function addEventosInstitucionale(\AppBundle\Entity\EventosInstitucionales $eventosInstitucionale)
    {
        $this->eventosInstitucionales[] = $eventosInstitucionale;

        return $this;
    }

    /**
     * Remove eventosInstitucionale
     *
     * @param \AppBundle\Entity\EventosInstitucionales $eventosInstitucionale
     */
    public function removeEventosInstitucionale(\AppBundle\Entity\EventosInstitucionales $eventosInstitucionale)
    {
        $this->eventosInstitucionales->removeElement($eventosInstitucionale);
    }

    /**
     * Get eventosInstitucionales
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEventosInstitucionales()
    {
        return $this->eventosInstitucionales;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     *
     * @return User
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set sexo
     *
     * @param boolean $sexo
     *
     * @return User
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return boolean
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set departamentoMunicipio
     *
     * @param string $departamentoMunicipio
     *
     * @return User
     */
    public function setDepartamentoMunicipio($departamentoMunicipio)
    {
        $this->departamentoMunicipio = $departamentoMunicipio;

        return $this;
    }

    /**
     * Get departamentoMunicipio
     *
     * @return string
     */
    public function getDepartamentoMunicipio()
    {
        return $this->departamentoMunicipio;
    }

    /**
     * Set direccionPrimaria
     *
     * @param string $direccionPrimaria
     *
     * @return User
     */
    public function setDireccionPrimaria($direccionPrimaria)
    {
        $this->direccionPrimaria = $direccionPrimaria;

        return $this;
    }

    /**
     * Get direccionPrimaria
     *
     * @return string
     */
    public function getDireccionPrimaria()
    {
        return $this->direccionPrimaria;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return User
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Add participante
     *
     * @param \AppBundle\Entity\Participa $participante
     *
     * @return User
     */
    public function addParticipante(\AppBundle\Entity\Participa $participante)
    {
        $this->participantes[] = $participante;

        return $this;
    }

    /**
     * Remove participante
     *
     * @param \AppBundle\Entity\Participa $participante
     */
    public function removeParticipante(\AppBundle\Entity\Participa $participante)
    {
        $this->participantes->removeElement($participante);
    }

    /**
     * Get participantes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParticipantes()
    {
        return $this->participantes;
    }

    /**
     * Add ganadore
     *
     * @param \AppBundle\Entity\Sorteo $ganadore
     *
     * @return User
     */
    public function addGanadore(\AppBundle\Entity\Sorteo $ganadore)
    {
        $this->ganadores[] = $ganadore;

        return $this;
    }

    /**
     * Remove ganadore
     *
     * @param \AppBundle\Entity\Sorteo $ganadore
     */
    public function removeGanadore(\AppBundle\Entity\Sorteo $ganadore)
    {
        $this->ganadores->removeElement($ganadore);
    }

    /**
     * Get ganadores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGanadores()
    {
        return $this->ganadores;
    }

    /**
     * Add creadore
     *
     * @param \AppBundle\Entity\Sorteo $creadore
     *
     * @return User
     */
    public function addCreadore(\AppBundle\Entity\Sorteo $creadore)
    {
        $this->creadores[] = $creadore;

        return $this;
    }

    /**
     * Remove creadore
     *
     * @param \AppBundle\Entity\Sorteo $creadore
     */
    public function removeCreadore(\AppBundle\Entity\Sorteo $creadore)
    {
        $this->creadores->removeElement($creadore);
    }

    /**
     * Get creadores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCreadores()
    {
        return $this->creadores;
    }

    /**
     * Set saldoPrincipal
     *
     * @param integer $saldoPrincipal
     *
     * @return User
     */
    public function setSaldoPrincipal($saldoPrincipal)
    {
        $this->saldoPrincipal = $saldoPrincipal;

        return $this;
    }

    /**
     * Get saldoPrincipal
     *
     * @return integer
     */
    public function getSaldoPrincipal()
    {
        return $this->saldoPrincipal;
    }

    /**
     * Set saldoBono
     *
     * @param integer $saldoBono
     *
     * @return User
     */
    public function setSaldoBono($saldoBono)
    {
        $this->saldoBono = $saldoBono;

        return $this;
    }

    /**
     * Get saldoBono
     *
     * @return integer
     */
    public function getSaldoBono()
    {
        return $this->saldoBono;
    }

    /**
     * Set saldoPromocional
     *
     * @param integer $saldoPromocional
     *
     * @return User
     */
    public function setSaldoPromocional($saldoPromocional)
    {
        $this->saldoPromocional = $saldoPromocional;

        return $this;
    }

    /**
     * Get saldoPromocional
     *
     * @return integer
     */
    public function getSaldoPromocional()
    {
        return $this->saldoPromocional;
    }

    /**
     * Add recargadore
     *
     * @param \AppBundle\Entity\Recarga $recargadore
     *
     * @return User
     */
    public function addRecargadore(\AppBundle\Entity\Recarga $recargadore)
    {
        $this->recargadores[] = $recargadore;

        return $this;
    }

    /**
     * Remove recargadore
     *
     * @param \AppBundle\Entity\Recarga $recargadore
     */
    public function removeRecargadore(\AppBundle\Entity\Recarga $recargadore)
    {
        $this->recargadores->removeElement($recargadore);
    }

    /**
     * Get recargadores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecargadores()
    {
        return $this->recargadores;
    }

    /**
     * Set contadorFalloRecarga
     *
     * @param integer $contadorFalloRecarga
     *
     * @return User
     */
    public function setContadorFalloRecarga($contadorFalloRecarga)
    {
        $this->contadorFalloRecarga = $contadorFalloRecarga;

        return $this;
    }

    /**
     * Get contadorFalloRecarga
     *
     * @return integer
     */
    public function getContadorFalloRecarga()
    {
        return $this->contadorFalloRecarga;
    }
}
