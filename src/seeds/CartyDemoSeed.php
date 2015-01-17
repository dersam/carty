<?php
use Illuminate\Database\Seeder;

class CartyDemoSeed extends Seeder{
    public function run(){
        \Dersam\Carty\Product::create(array(
            'name'=>'Arai Signet-Q Zero Helmet',
            'description'=>"The Signet-Q takes all the favorite features of the RX-Q and create a whole new series based on all the successes. On the outside, the Arai Signet-Q Helmet looks very similar to it's namesake, the RX-Q, but on the inside you can see and feel the difference. A longer shell shape on the Arai Signet-Q Helmet gives 5mm more space front to back allowing for a larger number of heads to fit comfortably.

The shape of the Arai Signet-Q Helmet releases forehead pressures and eliminate hot spots for a more comfortable fit every time. This shape works best for riders with a long oval headshape.",
            'price_per_unit'=>'899.00',
            'image_url'=>'packages/Dersam/Carty/img/arai_signet_q_zero_helmet.jpg',
        ));

        \Dersam\Carty\Product::create(array(
            'name'=>'Joe Rocket Speedmaster 12.0 Leather Jacket',
            'description'=>'1.2 to 1.4mm Premium Cowhide Leather',
            'price_per_unit'=>'399.99',
            'image_url'=>'packages/Dersam/Carty/img/SpeedMaster12_Jacket_whtsil_front.jpg'
        ));

        \Dersam\Carty\Product::create(array(
            'name'=>'Alpinestars Black Shadow Phantom Leather Jacket',
            'description'=>'The Alpinestars Black Shadow Phantom Jacket features minimal branding and maximum cool. Designed with a healthy dose of street style and track protection, the Alpinestars Phantom Jacket is constructed from 1.3mm full grain soft touch leather for maximum impact and abrasion resistance.',
            'price_per_unit'=>'899.95',
            'image_url'=>'packages/Dersam/Carty/img/alpinestars_black_shadow_phantom_jacket_black.jpg'
        ));

    }
}