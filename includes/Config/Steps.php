<?php
namespace BuildingDesigner\Config;

class Steps {
    
    public static function get_steps() {
        return array(
            array(
                'id' => 'store-select',
                'label' => 'Store Select',
                'icon' => '',
                'order' => 1
            ),
            array(
                'id' => 'building-size',
                'label' => 'Building Size',
                'icon' => '',
                'order' => 2
            ),
            array(
                'id' => 'building-info',
                'label' => 'Building Info',
                'icon' => '',
                'order' => 3
            ),
            array(
                'id' => 'accessories',
                'label' => 'Accessories',
                'icon' => '',
                'order' => 4
            ),
            array(
                'id' => 'leans-openings',
                'label' => 'Leans & Openings',
                'icon' => '',
                'order' => 5
            ),
            array(
                'id' => 'summary',
                'label' => 'Summary',
                'icon' => '',
                'order' => 6
            ),
            array(
                'id' => 'delivery',
                'label' => 'Delivery',
                'icon' => '',
                'order' => 7
            )
        );
    }
}
