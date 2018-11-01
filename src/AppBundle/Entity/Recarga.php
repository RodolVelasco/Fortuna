<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Recarga
 *
 * @ORM\Table(name="recarga")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\RecargaRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("codigo", message="Este código ya fue registrado")
 *
 */
class Recarga
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\RandomIdGenerator")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=16, nullable=false)
     * @Assert\Length(
     *      min = 16,
     *      max = 16,
     *      exactMessage = "Tu código de recarga debe tener exactamente {{ limit }} caracteres")
     *
     */
    private $codigo;

    /**
     * @var integer
     *
     * @ORM\Column(name="recarga", type="integer", length=2, nullable=false)
     *
     */
    private $recarga;

    /**
     * @var decimal
     *
     * @ORM\Column(name="precio", type="decimal", precision=4, scale=2, nullable=true)
     */
    private $precio;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo_pago_por_monedero", type="integer", length=1, nullable=false)
     *
     */
    private $tipoPagoPorMonedero;

    /**
     * @var integer $estado
     *
     * @ORM\Column(name="estado", type="integer", length=1, nullable=false)
     */
    private $estado;

    /**
     * @var \DateTime $fechaCreacion
     *
     * @ORM\Column(name="fecha_creacion", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $fechaCreacion;

    /**
     * @var \DateTime $fechaRecarga
     *
     * @ORM\Column(name="fecha_recarga", type="datetime", nullable=true)
     */
    protected $fechaRecarga;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="recargadores")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     *
    */
    protected $recargador;

    /************ constructeur ************/

    public function __construct()
    {
        $this->fechaCreacion = new \DateTime();
        //$this->proveedor = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->unidad = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->lineaTrabajo = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->periodo = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     *
     * @return Codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return substr($this->codigo,0,4) . ' - ' . substr($this->codigo,4,4) . ' - ' . substr($this->codigo,8,4) . ' - ' . substr($this->codigo,12,4);
    }

    /**
     * Set recarga
     *
     * @param integer $recarga
     *
     * @return Codigo
     */
    public function setRecarga($recarga)
    {
        $this->recarga = $recarga;

        return $this;
    }

    /**
     * Get recarga
     *
     * @return integer
     */
    public function getRecarga()
    {
        return $this->recarga;
    }

    /**
     * Set tipoPagoPorMonedero
     *
     * @param integer $tipoPagoPorMonedero
     *
     * @return Codigo
     */
    public function setTipoPagoPorMonedero($tipoPagoPorMonedero)
    {
        $this->tipoPagoPorMonedero = $tipoPagoPorMonedero;

        return $this;
    }

    /**
     * Get tipoPagoPorMonedero
     *
     * @return integer
     */
    public function getTipoPagoPorMonedero()
    {
        return $this->tipoPagoPorMonedero;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Codigo
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaRecarga
     *
     * @param \DateTime $fechaRecarga
     *
     * @return Codigo
     */
    public function setFechaRecarga($fechaRecarga)
    {
        $this->fechaRecarga = $fechaRecarga;

        return $this;
    }

    /**
     * Get fechaRecarga
     *
     * @return \DateTime
     */
    public function getFechaRecarga()
    {
        return $this->fechaRecarga;
    }

    /**
     * Set recargador
     *
     * @param \AppBundle\Entity\User $recargador
     *
     * @return Codigo
     */
    public function setRecargador(\AppBundle\Entity\User $recargador = null)
    {
        $this->recargador = $recargador;

        return $this;
    }

    /**
     * Get recargador
     *
     * @return \AppBundle\Entity\User
     */
    public function getRecargador()
    {
        return $this->recargador;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     *
     * @return Recarga
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer
     */
    public function getEstado()
    {
        return $this->estado;
    }


    /**
     * Set precio
     *
     * @param string $precio
     *
     * @return Recarga
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return string
     */
    public function getPrecio()
    {
        return $this->precio;
    }
    
    public function __toString() {
        return $this->getCodigo();
    }
}
