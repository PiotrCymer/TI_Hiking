<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity
 * @ORM\Table(name = "trips")
 */
class Hiking
{
    /**
     * @ORM\Column(type = "integer", name = "id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type = "string", length = 512)
     */
    private $name;

    /**
     * @ORM\Column(name = "start_date", type = "datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(name = "end_date", type = "datetime")
     */
    private $endDate;

    /**
     * @ORM\Column(name = "starting_point", type = "string", length = 512)
     */
    private $startingPoint;

    /**
     * @ORM\Column(type = "string", length = 512)
     */
    private $destination;

    /**
     * @ORM\Column(type = "text")
     */
    private $images;

    /**
     * @ORM\Column(type = "text")
     */
    private $video;

    /**
     * @ORM\Column(type = "string", length = 64)
     */
    private $length;

    /**
     * @ManyToOne(targetEntity="Users")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userId;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Hiking
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set startDate.
     *
     * @param \DateTime $startDate
     *
     * @return Hiking
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate.
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate.
     *
     * @param \DateTime $endDate
     *
     * @return Hiking
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate.
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set startingPoint.
     *
     * @param string $startingPoint
     *
     * @return Hiking
     */
    public function setStartingPoint($startingPoint)
    {
        $this->startingPoint = $startingPoint;

        return $this;
    }

    /**
     * Get startingPoint.
     *
     * @return string
     */
    public function getStartingPoint()
    {
        return $this->startingPoint;
    }

    /**
     * Set destination.
     *
     * @param string $destination
     *
     * @return Hiking
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination.
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set images.
     *
     * @param string $images
     *
     * @return Hiking
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images.
     *
     * @return string
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set video.
     *
     * @param string $video
     *
     * @return Hiking
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video.
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set length.
     *
     * @param string $length
     *
     * @return Hiking
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get length.
     *
     * @return string
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set userId.
     *
     * @param Users $userId
     *
     * @return Hiking
     */
    public function setUserId(Users $userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId.
     *
     * @return Users
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
