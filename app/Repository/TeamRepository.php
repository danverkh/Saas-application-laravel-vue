<?php

namespace App\Repository;

class TeamRepository
{
    /**
     * @return \string[][]
     */
    public static function all(): array
    {
        return [
            [
                'image' => 'https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=3&amp;h=375&amp;w=630',
                'name' => 'Oliver Aguilerra',
                'position' => 'Product Manager',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, beatae.',
                'twitter' => '#',
                'facebook' => '#',
            ],
            [
                'image' => 'https://images.pexels.com/photos/2381069/pexels-photo-2381069.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=2&amp;h=375&amp;w=630',
                'name' => 'Marta Clermont',
                'position' => 'Design Team Lead',
                'description' => 'Amet I love liquorice jujubes pudding croissant I love pudding.',
                'twitter' => '#',
                'facebook' => '#',
            ],
            [
                'image' => 'https://images.pexels.com/photos/3747435/pexels-photo-3747435.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=2&amp;h=375&amp;w=630',
                'name' => 'Alice Melbourne',
                'position' => 'Human Resources',
                'description' => 'Lorizzle ipsum bling bling sit amizzle, consectetuer adipiscing elit.',
                'twitter' => '#',
                'facebook' => '#',
            ],
            [
                'image' => 'https://images.pexels.com/photos/3931603/pexels-photo-3931603.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=2&amp;h=750&amp;w=1260',
                'name' => 'John Doe',
                'position' => 'Lead Developer',
                'description' => 'Bacon ipsum dolor sit amet salami jowl corned beef, andouille flank..',
                'twitter' => '#',
                'facebook' => '#',
            ],
        ];
    }
}
