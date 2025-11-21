<?php
namespace BuildingDesigner\Config;

class Options {
    
    public static function get_options() {
        if (defined('BUILDING_DESIGNER_PLUGIN_FILE')) {
            $plugin_url = plugin_dir_url(BUILDING_DESIGNER_PLUGIN_FILE);
        } else {
            $plugin_url = plugin_dir_url(__FILE__) . '../../../';
        }
        
        return array(
            'building-size' => array(
                'building-use' => array(
                    'id' => 'building-use',
                    'label' => 'Building Use',
                    'question' => 'What will you use your building for?',
                    'type' => 'select',
                    'options' => array(
                        array(
                            'id' => 'residential',
                            'label' => 'Residential',
                            'image_url' => $plugin_url . 'assets/images/post-frame.jpg',
                            'description' => 'Perfect for garages, workshops, and storage buildings.'
                        ),
                        array(
                            'id' => 'agricultural',
                            'label' => 'Agricultural',
                            'image_url' => $plugin_url . 'assets/images/ladder-frame.jpg',
                            'description' => 'Ideal for barns, equipment storage, and farm buildings.'
                        ),
                        array(
                            'id' => 'commercial',
                            'label' => 'Commercial',
                            'image_url' => $plugin_url . 'assets/images/post-frame.jpg',
                            'description' => 'Great for retail, warehouses, and business facilities.'
                        )
                    )
                ),
                'construction-framing' => array(
                    'id' => 'construction-framing',
                    'label' => 'Framing Type',
                    'question' => 'Select framing type',
                    'type' => 'image-tile',
                    'options' => array(
                        array(
                            'id' => 'post-frame',
                            'label' => 'Post Frame',
                            'image_url' => $plugin_url . 'assets/images/post-frame.jpg',
                            'description' => '<ul><li>Uses treated lumber columns for vertical supports</li><li>Truss spacing available at 9\', 8\', 6\', or 4\' oc spacing</li><li>12\' to 70\' wide buildings available to choose from</li><li>8\' to 20\' tall buildings available to choose from</li></ul>'
                        ),
                        array(
                            'id' => 'ladder-frame',
                            'label' => 'Ladder Frame',
                            'image_url' => $plugin_url . 'assets/images/ladder-frame.jpg',
                            'description' => '<ul><li>Great alternative to stick-built buildings</li><li>Uses 2-ply or 3-ply studs 4\' oc with 4\' oc trusses</li><li>2x6 wall girts laid horizontally between wall studs</li><li>Tip up the wall sections on top of concrete</li><li>12\' to 60\' wide buildings available to choose from</li></ul>'
                        )
                    )
                ),
                'roof-pitch' => array(
                    'id' => 'roof-pitch',
                    'label' => 'Roof Pitch',
                    'question' => 'Roof pitch',
                    'type' => 'select',
                    'options' => array(
                        array(
                            'id' => '3-12',
                            'label' => '3:12 Pitch',
                            'image_url' => $plugin_url . 'assets/images/post-frame.jpg',
                            'description' => 'Standard pitch for most buildings.'
                        ),
                        array(
                            'id' => '4-12',
                            'label' => '4:12 Pitch',
                            'image_url' => $plugin_url . 'assets/images/ladder-frame.jpg',
                            'description' => 'Steeper pitch for better water runoff.'
                        ),
                        array(
                            'id' => '5-12',
                            'label' => '5:12 Pitch',
                            'image_url' => $plugin_url . 'assets/images/post-frame.jpg',
                            'description' => 'Higher pitch for areas with heavy snow.'
                        )
                    )
                ),
                'truss-spacing' => array(
                    'id' => 'truss-spacing',
                    'label' => 'Truss Spacing and Length',
                    'question' => 'Select truss spacing',
                    'type' => 'select',
                    'options' => array(
                        array(
                            'id' => '4-oc',
                            'label' => '4\' on center',
                            'image_url' => $plugin_url . 'assets/images/post-frame.jpg',
                            'description' => 'Provides maximum strength and durability.'
                        ),
                        array(
                            'id' => '6-oc',
                            'label' => '6\' on center',
                            'image_url' => $plugin_url . 'assets/images/ladder-frame.jpg',
                            'description' => 'Balanced strength and cost efficiency.'
                        ),
                        array(
                            'id' => '8-oc',
                            'label' => '8\' on center',
                            'image_url' => $plugin_url . 'assets/images/post-frame.jpg',
                            'description' => 'Cost-effective spacing for lighter loads.'
                        )
                    )
                ),
                'building-length' => array(
                    'id' => 'building-length',
                    'label' => 'Building Length',
                    'question' => 'Choose length of building',
                    'type' => 'select',
                    'options' => array(
                        array(
                            'id' => '20',
                            'label' => '20 feet',
                            'image_url' => $plugin_url . 'assets/images/post-frame.jpg',
                            'description' => 'Compact building size.'
                        ),
                        array(
                            'id' => '30',
                            'label' => '30 feet',
                            'image_url' => $plugin_url . 'assets/images/ladder-frame.jpg',
                            'description' => 'Standard building size.'
                        ),
                        array(
                            'id' => '40',
                            'label' => '40 feet',
                            'image_url' => $plugin_url . 'assets/images/post-frame.jpg',
                            'description' => 'Large building size.'
                        )
                    )
                ),
                'width' => array(
                    'id' => 'width',
                    'label' => 'Width',
                    'question' => 'Choose width of building',
                    'type' => 'select',
                    'options' => array(
                        array(
                            'id' => '12',
                            'label' => '12 feet',
                            'image_url' => $plugin_url . 'assets/images/post-frame.jpg',
                            'description' => 'Narrow width, great for storage.'
                        ),
                        array(
                            'id' => '16',
                            'label' => '16 feet',
                            'image_url' => $plugin_url . 'assets/images/ladder-frame.jpg',
                            'description' => 'Standard width for most applications.'
                        ),
                        array(
                            'id' => '24',
                            'label' => '24 feet',
                            'image_url' => $plugin_url . 'assets/images/post-frame.jpg',
                            'description' => 'Wide width for larger vehicles or equipment.'
                        )
                    )
                )
            )
        );
    }
}
