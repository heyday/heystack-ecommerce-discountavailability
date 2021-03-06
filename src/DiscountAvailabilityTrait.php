<?php

namespace Heystack\Availability;

use Heystack\Core\Exception\ConfigurationException;
use Heystack\Ecommerce\Locale\Interfaces\ZoneServiceInterface;
use Heystack\Ecommerce\Locale\Traits\HasZoneServiceTrait;
use DataObject;

/**
 * @package Heystack\Availability
 */
trait DiscountAvailabilityTrait
{
    /**
     * @return bool
     * @throws \Heystack\Core\Exception\ConfigurationException
     */
    public function isDiscountAvailable()
    {
        if (!$this instanceof DataObject) {
            throw new ConfigurationException(
                sprintf(
                    "'%s' is not an instance of DataObject",
                    __CLASS__
                )
            );
        }
        
        $zoneService = $this->getZoneService();

        if (!$zoneService instanceof ZoneServiceInterface) {
            throw new ConfigurationException(
                sprintf(
                    "%s::isDiscountAvailable expected to have a zone service but not was set on trait",
                    __CLASS__
                )
            );
        }

        return in_array(
            $zoneService->getActiveZone()->getName(),
            $this->DiscountAvailabilityZones()->column('Name')
        );
    }

    /**
     * @return \Heystack\Ecommerce\Locale\Interfaces\ZoneServiceInterface
     */
    abstract function getZoneService();
}