<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
//use Symfony\Component\Validator\Constraints as Assert;

//use Symfony\Component\HttpFoundation\File\File;

/**
 * Participa
 *
 * @ORM\Table(name="participa")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ParticipaRepository")
 *
 */
class Participa
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\RandomIdGenerator")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sorteo", inversedBy="participantes")
     * @ORM\JoinColumn(name="sorteo_id", referencedColumnName="id", nullable=false)
     *
     */
    protected $sorteo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="participantes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     *
     */
    protected $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero", type="integer", length=11, nullable=false)
     *
     */
    private $numero;


    /************ constructeur ************/

    public function __construct()
    {
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
     * Set numero
     *
     * @param integer $numero
     * @return Participa
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set proveedor
     *
     * @param \AppBundle\Entity\Sorteo $sorteo
     * @return Sorteo
     */
    public function setSorteo(\AppBundle\Entity\Sorteo $sorteo = null)
    {
        $this->sorteo = $sorteo;

        return $this;
    }

    /**
     * Get sorteo
     *
     * @return \AppBundle\Entity\Sorteo
     */
    public function getSorteo()
    {
        return $this->sorteo;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return User
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
    
    public function __toString() {
        return "Sor: " . $this->getSorteo()->getId() . " | Num: " .$this->getNumero() . "";
    }
}
