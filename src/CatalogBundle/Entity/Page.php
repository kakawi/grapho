<?php


namespace CatalogBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="page")
 */
class Page
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    protected $pageText;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $weight;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isMainPage;

    /**
     * @ORM\Column(type="string")
     *
     */
    protected $pageFormatter;

    /**
     * @ORM\Column(type="text")
     */
    protected $rawPageText;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPageText()
    {
        return $this->pageText;
    }

    /**
     * @param mixed $pageText
     */
    public function setPageText($pageText)
    {
        $this->pageText = $pageText;
    }

    /**
     * @return mixed
     */
    public function getPageFormatter()
    {
        return $this->pageFormatter;
    }

    /**
     * @param mixed $pageFormatter
     */
    public function setPageFormatter($pageFormatter)
    {
        $this->pageFormatter = $pageFormatter;
    }

    /**
     * @return mixed
     */
    public function getRawPageText()
    {
        return $this->rawPageText;
    }

    /**
     * @param mixed $rawPageText
     */
    public function setRawPageText($rawPageText)
    {
        $this->rawPageText = $rawPageText;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }



    /**
     * Set isMainPage
     *
     * @param integer $isMainPage
     *
     * @return Page
     */
    public function setIsMainPage($isMainPage)
    {
        $this->isMainPage = $isMainPage;

        return $this;
    }

    /**
     * Get isMainPage
     *
     * @return integer
     */
    public function getIsMainPage()
    {
        return $this->isMainPage;
    }
}
