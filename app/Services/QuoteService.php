<?php

declare(strict_types=1);

namespace App\Services;

class QuoteService
{
    public function randomQuote(): bool
    {
        $quotes = [
            'When there is no desire, all things are at peace. - Laozi',
            'Simplicity is the ultimate sophistication. - Leonardo da Vinci',
            'Simplicity is the essence of happiness. - Cedric Bledsoe',
            'Smile, breathe, and go slowly. - Thich Nhat Hanh',
            'Simplicity is an acquired taste. - Katharine Gerould',
            'Well begun is half done. - Aristotle',
            'He who is contented is rich. - Laozi',
            'Very little is needed to make a happy life. - Marcus Antoninus',
            'It is quality rather than quantity that matters. - Lucius Annaeus Seneca',
            'Genius is one percent inspiration and ninety-nine percent perspiration. - Thomas Edison',
            'Computer science is no more about computers than astronomy is about telescopes. - Edsger Dijkstra',
            'It always seems impossible until it is done. - Nelson Mandela',
            'Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - Immanuel Kant',
        ];

        echo $quotes[array_rand($quotes)];

        return true;
    }
}
