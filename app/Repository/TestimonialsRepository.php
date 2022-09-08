<?php

namespace App\Repository;

class TestimonialsRepository
{
    /**
     * @return \string[][]
     */
    public static function all(): array
    {
        return [
            [
                'title' => 'Eos obcaecati quae',
                'content' => 'Non quia vero eum dolores sapiente aut consequuntur assumenda. Qui quidem dolor qui tempora quaerat cum labore commodi eum beatae aspernatur.',
                'client' => 'Toni B. Samson',
            ],
            [
                'title' => 'Sed dolores sequi et',
                'content' => 'Est nisi quisquam aut voluptatum voluptas et minus dolor aut omnis animi. Non velit velit sit commodi quis ut dolores natus.',
                'client' => 'Abbie J. Carroll',
            ],
            [
                'title' => 'Et distinctio veritatis',
                'content' => 'Hic deleniti ipsam sit nostrum praesentium et iure sint id laborum ullam et perspiciatis beatae non delectus quasi eos voluptates inventore.',
                'client' => 'Larry P. Brewer',
            ],
            [
                'title' => 'Aut quam necessitatibus',
                'content' => 'Est omnis itaque et labore odit ut incidunt saepe sit sint rerum. Qui magnam expedita quo laboriosam asperiores eos natus vitae!',
                'client' => 'James M. McMillan',
            ],
            [
                'title' => 'In optio sint sit voluptatum',
                'content' => 'Vel blanditiis reprehenderit non maxime enim hic odio veritatis aut magnam in dolore aliquam praesentium non velit consequatur.',
                'client' => 'Jacquline D. McLeod',
            ],
        ];
    }
}
