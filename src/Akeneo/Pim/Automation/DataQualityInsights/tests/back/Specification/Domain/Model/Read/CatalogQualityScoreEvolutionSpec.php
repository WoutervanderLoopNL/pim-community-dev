<?php

declare(strict_types=1);

namespace Specification\Akeneo\Pim\Automation\DataQualityInsights\Domain\Model\Read;

use PhpSpec\ObjectBehavior;

final class CatalogQualityScoreEvolutionSpec extends ObjectBehavior
{
    public function it_returns_catalog_score_evolution()
    {
        $year = date('Y');
        $month = date('m');
        $currentMonth = (new \DateTime())->format('Y-m-t');
        $lastMonth = (new \DateTime(sprintf('%d-%d-15', $year, $month - 1)))->format('Y-m-t');
        $twoMonthsAgo = (new \DateTime(sprintf('%d-%d-15', $year, $month - 2)))->format('Y-m-t');
        $threeMonthsAgo = (new \DateTime(sprintf('%d-%d-15', $year, $month - 3)))->format('Y-m-t');
        $fourMonthsAgo = (new \DateTime(sprintf('%d-%d-15', $year, $month - 4)))->format('Y-m-t');
        $fiveMonthsAgo = (new \DateTime(sprintf('%d-%d-15', $year, $month - 5)))->format('Y-m-t');
        $sixMonthsAgo = (new \DateTime(sprintf('%d-%d-15', $year, $month - 6)))->format('Y-m-t');

        $scores = [
            'average_ranks' => [
                'print' => [
                    'en_US' => 'rank_3',
                ],
            ],
            'monthly' => [
                $sixMonthsAgo => [
                    'print' => [
                        'en_US' => [
                            'rank_1' => 2,
                            'rank_2' => 5,
                            'rank_3' => 4,
                            'rank_4' => 3,
                            'rank_5' => 2,
                        ],
                    ],
                ],
                $fiveMonthsAgo => [
                    'print' => [
                        'en_US' => [
                            'rank_1' => 2,
                            'rank_2' => 5,
                            'rank_3' => 4,
                            'rank_4' => 3,
                            'rank_5' => 2,
                        ],
                    ],
                ],
                $fourMonthsAgo => [
                    'print' => [
                        'en_US' => [
                            'rank_1' => 2,
                            'rank_2' => 5,
                            'rank_3' => 4,
                            'rank_4' => 4,
                            'rank_5' => 2,
                        ],
                    ],
                ],
                $threeMonthsAgo => [
                    'print' => [
                        'en_US' => [
                            'rank_1' => 2,
                            'rank_2' => 4,
                            'rank_3' => 4,
                            'rank_4' => 40,
                            'rank_5' => 2,
                        ],
                    ],
                ],
                $twoMonthsAgo => [
                    'print' => [
                        'en_US' => [
                            'rank_1' => 2,
                            'rank_2' => 5,
                            'rank_3' => 30,
                            'rank_4' => 4,
                            'rank_5' => 2,
                        ],
                    ],
                ],
                $lastMonth => [
                    'print' => [
                        'en_US' => [
                            'rank_1' => 30,
                            'rank_2' => 5,
                            'rank_3' => 4,
                            'rank_4' => 3,
                            'rank_5' => 2,
                        ],
                    ],
                ],
            ],
        ];

        $this->beConstructedWith($scores, 'print', 'en_US');

        $this->toArray()->shouldBeLike([
            'average_rank' => 'C',
            'data' => [
                $fiveMonthsAgo => 'C',
                $fourMonthsAgo => 'C',
                $threeMonthsAgo => 'D',
                $twoMonthsAgo => 'C',
                $lastMonth => 'B',
                $currentMonth => 'C',
            ],
        ]);
    }
}
