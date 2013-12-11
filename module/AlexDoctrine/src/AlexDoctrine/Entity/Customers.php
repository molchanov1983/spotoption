<?php

namespace AlexDoctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Zend\Form\Annotation;

/**
 * Customers
 *
 * @ORM\Table(name="customers")
 * @ORM\Entity(repositoryClass="AlexDoctrine\Entity\Repository\CustomersRepository")
 * @Annotation\Name("customers")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 * @Annotation\Attributes({"class":"form-alex"})
 * @property int $id
 * @property string $calls
 * @property string $firstName
 * @property string $lastName
 * @property string $phone
 * @property string $address
 * @property string $status
 */
//   donot allow the user to edit '$calls'; in these cases i can use @Annotation\Exclude().
class Customers
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Annotation\Attributes({"type":"hidden"})
     * @Annotation\Exclude().
     */
     private $id;

    /**
    * @ORM\OneToMany(targetEntity="Calls", mappedBy="customers", cascade={"all"})
    * @Annotation\Filter({"name":"StringTrim"})
    * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
    * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[0-9]{0,100}$/"}})
    * @Annotation\Attributes({"type":"text", "class":"alex1"})
    * @Annotation\Options({"label":"Calls number:"})
    * @Annotation\Exclude()
    */
    private $calls;

    public function __construct()
    {
        $this->calls = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="FirstNamee", type="string", length=100, nullable=false)
	 * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z0-9_-]{0,100}$/"}})
     * @Annotation\Attributes({"type":"text","class":"alex1"})
     * @Annotation\Options({"label":"Firstname:"})
     * @Annotation\Required({"required":"true" })
     */
    private $firstName;

  /**
     * @var string
     *
     * @ORM\Column(name="LastName", type="string", length=100, nullable=false)
	 * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z0-9_-]{0,100}$/"}})
     * @Annotation\Attributes({"type":"text","class":"alex1"})
     * @Annotation\Options({"label":"Lastname:"})
     * @Annotation\Required({"required":"true" })
     */
    private $lastName;

   /**
     * @var string
     *
     * @ORM\Column(name="Phone", type="string", length=20, nullable=false)
	 * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":20}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[0-9_-]{0,100}$/"}})
     * @Annotation\Attributes({"type":"text","class":"alex1"})
     * @Annotation\Options({"label":"Phone:"})
     * @Annotation\Required({"required":"true" })
     */
    private $phone;

      /**
     * @var string
     *
     * @ORM\Column(name="Address", type="string", length=200, nullable=false)
	 * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":200}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z0-9_-]{0,200}$/"}})
     * @Annotation\Attributes({"type":"text","class":"alex1"})
     * @Annotation\Options({"label":"Address:"})
     * @Annotation\Required({"required":"true" })
     */
    private $address;


    /**
     * @var integer
     *
     * @ORM\Column(name="Status", type="integer", nullable=false)
     * @Annotation\Attributes({"type":"text","class":"alex1"})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[0-9]{0,2}$/"}})
     * @Annotation\Options({"label":"Status:"})
     * @Annotation\Required({"required":"true" })
     */
    private $status;


     /**
     * Magic getter to expose protected properties.
     */


    public function getId ()
    {
         return $this->id;
    }
    public function setId ($value)
    {
         $this->id = $value;
    }
    public function getFirstName ()
    {
         return $this->firstName;
    }
    public function setFirstName ($value)
    {
         $this->firstName = $value;
    }
    public function getCalls()
    {
        return $this->calls;
    }
    public function setCalls ($value)
    {
         $this->calls = $value;
    }
    public function getLastName()
    {
        return $this->lastName;
    }
    public function setLastName ($value)
    {
         $this->lastName = $value;
    }
    public function getPhone()
    {
        return $this->phone;
    }
    public function setPhone ($value)
    {
         $this->phone = $value;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function setAddress ($value)
    {
         $this->address = $value;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus ($value)
    {
         $this->status = $value;
    }

}