<?php


namespace CatalogBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use \Application\Sonata\MediaBundle\Entity\Media;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")

 */
class Product
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
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\NotBlank()
     */
    protected $price;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    protected $description;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $descriptionFormatter;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    protected $rawDescription;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")

     *   @ORM\JoinColumn(name="image", referencedColumnName="id")
     * @Assert\Type(type="Application\Sonata\MediaBundle\Entity\Media")
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *
     * @Assert\Type(type="CatalogBundle\Entity\Category")
     * @Assert\Valid()
     */
    protected $category;

    /**
     * 
     * @ORM\Column(name="in_front_page", type="boolean", nullable=true)
     */
    protected $inFrontPage = false;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $path;

//    /**
//     * @Assert\File(maxSize="6000000")
//     */
    protected $file;

//    public function setFile(\Application\Sonata\MediaBundle\Entity\Media  $file = null)
//    {
//        $this->file = $file;
//    }

    public function getFile()
    {
        return $this->file;
    }

    /**
     * (1)
     * @return string
     */
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }

    /**
     * (2)
     * @return string
     */
    public function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    /**
     * (3.1)
     * @return null|string
     */
    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    /**
     * (3.2)
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function upload($mediaManager)
    {
        if (null === $this->getFile()) return;
        $file = $this->getFile();

        // move takes the target directory and then the target filename to move to
//        $filePath = $this->getFile()->getClientOriginalName();
//        $this->getFile()->move(
//            $this->getUploadRootDir(),
//            $filePath
//        );

        $mediaManager->save($file, 'user', 'sonata.media.provider.image');

        // set the path property to the filename where you'ved saved the file
//        $this->setPath($filePath);

        // clean up the file property as you won't need it anymore
        $this->file = null;
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
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getRawDescription()
    {
        return $this->rawDescription;
    }

    /**
     * @param mixed $rawDescription
     */
    public function setRawDescription($rawDescription)
    {
        $this->rawDescription = $rawDescription;
    }

    /**
     * @return mixed
     */
    public function getDescriptionFormatter()
    {
        return $this->descriptionFormatter;
    }

    /**
     * @param mixed $descriptionFormatter
     */
    public function setDescriptionFormatter($descriptionFormatter)
    {
        $this->descriptionFormatter = $descriptionFormatter;
    }


    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }




    /**
     * Set category
     *
     * @param \CatalogBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \CatalogBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }


    

    /**
     * Set image
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $image
     *
     * @return Product
     */
    public function setImage(\Application\Sonata\MediaBundle\Entity\Media $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set inFrontPage
     *
     * @param boolean $inFrontPage
     *
     * @return Product
     */
    public function setInFrontPage($inFrontPage)
    {
        $this->inFrontPage = $inFrontPage;

        return $this;
    }

    /**
     * Get inFrontPage
     *
     * @return boolean
     */
    public function getInFrontPage()
    {
        return $this->inFrontPage;
    }
}
