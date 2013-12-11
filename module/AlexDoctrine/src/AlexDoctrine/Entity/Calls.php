<?php

namespace AlexDoctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
// added by Stoyan
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use DoctrineModule\Validator\NoObjectExists;
use DoctrineORMModule\Form\Element\EntitySelect;

use Zend\Form\Annotation;

/**
 * Calls
 *
 * @ORM\Table(name="calls")
 * @ORM\Entity(repositoryClass="AlexDoctrine\Entity\Repository\CallsRepository")
 * @Annotation\Name("calls")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 * @property int $id
 * @property string $subject
 * @property string $content
 * @property string $customers
 */
class Calls
{
//         * @Annotation\Validator({"name":"\DoctrineModule\Validator\NoObjectExists",
//     *                        "options":{"object_repository":"Customers","fields":{"firstName"}}})

    /**
    * @ORM\ManyToOne(targetEntity="Customers", inversedBy="calls", cascade={"persist"})
    * @ORM\JoinColumn(name="CustomerId", referencedColumnName="id", unique=false, nullable=false)
    * @Annotation\Type("DoctrineORMModule\Form\Element\EntitySelect")
    * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[0-9]+$/"}})
    * @Annotation\Attributes({"readonly":"false","required" : true})
    * @Annotation\Options({"label":"Customer:",
    *                      "target_class":"AlexDoctrine\Entity\Customers",
    *                      "is_method":true,
    *                       "property" : "firstName",
    *                      "find_method":{
    *                               "name": "findAll" ,
    *                               "criteria" : {},
    *                               "orderBy"  : {"name" : "ASC"}
     *                      }
    * })
    */
    private $customers;
 // @Annotation\Exclude()

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
	 * @Annotation\Exclude()
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="Subject", type="string", length=100, nullable=false)
	 * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":100}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z0-9_-]{0,100}$/"}})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Subject:"})
     */
    private $subject;



      /**
     * @var string
     *
     * @ORM\Column(name="Content", type="string", length=200, nullable=false)
	 * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":200}})
     * @Annotation\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z0-9_-]{0,200}$/"}})
     * @Annotation\Attributes({"type":"text","class":"alex1"})
     * @Annotation\Required({"required":"true" })
     * @Annotation\Options({"label":"Content:"})
     */
    private $content;

//GETS AND SET

    public function getCustomers()
    {
        return $this->customers;
    }

    public function setCustomers($value)
    {
        $this->customers = $value;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setId ($value)
    {
        $this->id = $value;
    }
    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($value)
    {
        $this->subject = $value;
    }
    public function getContent()
    {
        return $this->content;
    }

    public function setContent($value)
    {
        $this->content = $value;
    }
}

