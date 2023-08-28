<?php

namespace App\Services;

class RouteCalculatorService
{
    public function calculateRoute($pickerLocation, $itemLocations): array
    {
        $route = [];
        $currentLocation = $pickerLocation;

        while (!empty($itemLocations)) {
            $nearestItem = $this->findNearestItem($currentLocation, $itemLocations);
            $route[] = $nearestItem;
            $currentLocation = $nearestItem; // Move to the nearest item
            unset($itemLocations[array_search($nearestItem, $itemLocations)]);
        }

        return $route;
    }

    public function findNearestItem($currentLocation, $itemLocations)
    {
        $nearestDistance = PHP_INT_MAX;
        $nearestItem = null;

        foreach ($itemLocations as $itemLocation) {
            $distance = $this->distance($currentLocation, $itemLocation);
            if ($distance < $nearestDistance) {
                $nearestDistance = $distance;
                $nearestItem = $itemLocation;
            }
        }

        return $nearestItem;
    }

    public function distance($location1, $location2)
    {
        $x1 = $location1['latitude'];
        $y1 = $location1['longitude'];
        $x2 = $location2['latitude'];
        $y2 = $location2['longitude'];

        // Euclidean distance formula
        return sqrt(pow($x2 - $x1, 2) + pow($y2 - $y1, 2));
    }

}
