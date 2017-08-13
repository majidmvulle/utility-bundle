<?php

namespace MajidMvulle\Bundle\UtilityBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class City.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 *
 * @Serializer\ExclusionPolicy("all")
 */
class City
{
    /**
     * @var int
     *
     * @Serializer\Expose()
     */
    protected $id;

    /**
     * @var string
     *
     * @Serializer\Expose()
     */
    protected $name;

    /**
     * @var string
     *
     * @Serializer\Expose()
     */
    protected $country;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getId();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Cities.
     *
     * @return ArrayCollection
     */
    public static function getCities()
    {
        $listOfCities = [
            [
                'id' => 1,
                'name' => 'Dubai',
                'country' => 'ARE',
            ],
            [
                'id' => 2,
                'name' => 'Abu Dhabi',
                'country' => 'ARE',
            ],
            [
                'id' => 3,
                'name' => 'Sharjah',
                'country' => 'ARE',
            ],
            [
                'id' => 4,
                'name' => 'Ajman',
                'country' => 'ARE',
            ],
            [
                'id' => 5,
                'name' => 'Al Ain',
                'country' => 'ARE',
            ],
            [
                'id' => 6,
                'name' => 'Fujairah',
                'country' => 'ARE',
            ],
            [
                'id' => 7,
                'name' => 'Ras al-Khaimah',
                'country' => 'ARE',
            ],
            [
                'id' => 8,
                'name' => 'Umm al-Quwain',
                'country' => 'ARE',
            ],
        ];

        $cities = new ArrayCollection();

        foreach ($listOfCities as $aCity) {
            $city = new self();
            $city->id = $aCity['id'];
            $city->name = $aCity['name'];
            $city->country = $aCity['country'];

            $cities->add($city);
        }

        return $cities;
    }

    /**
     * Get cities as choice list.
     *
     * @return array
     */
    public static function getCitiesList()
    {
        $cities = [];

        /** @var \MajidMvulle\Bundle\UtilityBundle\Model\City $city */
        foreach (self::getCities()->toArray() as $city) {
            $cities[$city->getId()] = $city->getName();
        }

        return $cities;
    }

    /**
     * Gets city by id.
     *
     * @param $id
     *
     * @return mixed
     */
    public static function getCityById($id)
    {
        return self::getCities()->matching(Criteria::create()->where(Criteria::expr()->eq('id', $id)))->first();
    }
}
