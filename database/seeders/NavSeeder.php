<?php

namespace Database\Seeders;

use App\Models\Navigation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;

class NavSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configs = [
            'admin' => [
                [
                    'name' => 'labels.dashboard',
                    'icon' => 'chart-pie',
                    'link' => 'dashboard',
                    'group' => 'dashboard',
                    'is_dev_feature' => false,
                ],
                [
                    'name' => 'labels.company',
                    'icon' => 'user-group',
                    'link' => 'companies.index',
                    'group' => 'companies',
                    'is_dev_feature' => false,
                ],
                [
                    'name' => 'labels.nav.invoice',
                    'icon' => 'receipt-tax',
                    'group' => 'invoices',
                    'is_dev_feature' => false,
                    'subs' => [
                        [
                            'group' => 'invoices.releases',
                            'is_dev_feature' => false,
                        ],
                        [
                            'group' => 'invoices.downloads',
                            'is_dev_feature' => false,
                        ],
                        [
                            'group' => 'invoices.settings.notices',
                            'is_dev_feature' => false,
                        ],
                        [
                            'group' => 'invoices.settings.visibilities',
                            'is_dev_feature' => false,
                        ],
                        [
                            'group' => 'invoices.rates',
                            'is_dev_feature' => false,
                        ],
                    ],
                ],
                [
                    'name' => 'labels.nav.aws',
                    'icon' => 'cloud',
                    'group' => 'aws',
                    'is_dev_feature' => false,
                    'subs' => [
                        [
                            'group' => 'aws.accounts',
                            'is_dev_feature' => false,
                        ],
                    ],
                ],
                [
                    'name' => 'labels.nav.support',
                    'icon' => 'support',
                    'group' => 'support',
                    'is_dev_feature' => false,
                    'subs' => [
                        [
                            'group' => 'supports.faqs',
                            'is_dev_feature' => false,
                        ],
                    ],
                ],
                [
                    'name' => 'labels.nav.auth',
                    'icon' => 'finger-print',
                    'group' => 'auth',
                    'is_dev_feature' => false,
                    'subs' => [
                        [
                            'group' => 'auth.users',
                            'is_dev_feature' => true,
                        ],
                        [
                            'group' => 'auth.roles',
                            'is_dev_feature' => true,
                        ],
                        [
                            'group' => 'auth.permissions',
                            'is_dev_feature' => true,
                        ],
                    ]
                ],
                [
                    'name' => 'labels.nav.system',
                    'icon' => 'server',
                    'group' => 'systems',
                    'is_dev_feature' => false,
                    'subs' => [
                        [
                            'group' => 'systems.logs',
                            'is_dev_feature' => false,
                        ],
                        [
                            'group' => 'systems.messages',
                            'is_dev_feature' => false,
                        ],
                        [
                            'group' => 'systems.schedules',
                            'is_dev_feature' => false,
                        ],
                        [
                            'group' => 'systems.settings',
                            'is_dev_feature' => false,
                        ],
                    ],
                ]
            ],
            'frontend' => [
                [
                    'icon' => 'fas fa-chart-pie',
                    'link' => 'dashboard',
                    'group' => 'dashboard',
                    'is_dev_feature' => false,
                ],
                [
                    'icon' => 'fas fa-bell',
                    'link' => 'notifications.index',
                    'group' => 'notifications',
                    'is_dev_feature' => false,
                ],
                [
                    'icon' => 'fas fa-file-pdf',
                    'link' => 'invoices.pdf',
                    'group' => 'invoices.pdf',
                    'is_dev_feature' => false,
                ],
                [
                    'icon' => 'fas fa-file-csv',
                    'link' => 'invoices.csv',
                    'group' => 'invoices.csv',
                    'is_dev_feature' => false,
                ],
                [
                    'name' => 'labels.nav.ec2',
                    'icon' => 'fas fa-microchip',
                    'group' => 'ec2.instances',
                    'is_dev_feature' => false,
                    'subs' => [
                        [
                            'group' => 'ec2.instances.registered',
                            'is_dev_feature' => false,
                        ],
                        [
                            'group' => 'ec2.instances.requests',
                            'is_dev_feature' => false,
                        ],
                    ],
                ],
                [
                    'name' => 'labels.nav.rds',
                    'icon' => 'fas fa-database',
                    'group' => 'rds.instances',
                    'is_dev_feature' => false,
                    'subs' => [
                        [
                            'group' => 'rds.instances.registered',
                            'is_dev_feature' => false,
                        ],
                        [
                            'group' => 'rds.instances.requests',
                            'is_dev_feature' => false,
                        ],
                    ],
                ],
                [
                    'icon' => 'fas fa-network-wired',
                    'link' => 'aws.elbs.index',
                    'group' => 'aws.elbs',
                    'is_dev_feature' => false,
                ],
                [
                    'icon' => 'fas fas fa-history',
                    'link' => 'logs.index',
                    'group' => 'logs',
                    'is_dev_feature' => false,
                ],
                [
                    'icon' => 'fas fas fas fa-cog',
                    'link' => 'settings.index',
                    'group' => 'settings',
                    'is_dev_feature' => false,
                ],
                [
                    'name' => 'Trusted Advisor',
                    'icon' => 'fas fa-user-check',
                    'group' => 'aws.trusted-advisors',
                    'is_dev_feature' => false,
                    'subs' => [
                        [
                            'group' => 'aws.trusted-advisors.settings',
                            'is_dev_feature' => false,
                        ],
                        [
                            'group' => 'aws.trusted-advisors.reports',
                            'is_dev_feature' => false,
                        ],
                    ],
                ],
                [
                    'name' => 'labels.nav.apps',
                    'icon' => 'fas fa-layer-group',
                    'link' => 'apps',
                    'group' => 'apps',
                    'is_dev_feature' => false,
                ],
                // headers
                [
                    'name' => 'labels.nav.help',
                    'icon' => 'fas fa-question-circle',
                    'group' => 'help',
                    'position' => 'header',
                    'is_dev_feature' => false,
                    'subs' => [
                        [
                            'icon' => 'fas fa-comments',
                            'group' => 'faqs',
                            'is_dev_feature' => false,
                        ],
                        [
                            'icon' => 'fas fa-book',
                            'group' => 'help.manual',
                            'is_dev_feature' => false,
                        ],
                        [
                            'icon' => 'fas fa-info',
                            'group' => 'help.specs',
                            'is_dev_feature' => false,
                        ],
                        [
                            'icon' => 'fas fa-check',
                            'group' => 'help.terms',
                            'is_dev_feature' => false,
                        ],
                    ],
                ],
                [
                    'name' => 'labels.user',
                    'icon' => 'fas fa-user-circle',
                    'group' => null,
                    'position' => 'header',
                    'is_dev_feature' => false,
                    'subs' => [
                        [
                            'icon' => 'fas fa-at',
                            'group' => 'contact',
                            'is_dev_feature' => false,
                        ],
                        [
                            'icon' => 'fas fa-id-card',
                            'group' => 'profile',
                            'is_dev_feature' => false,
                        ],
                        [
                            'icon' => 'fas fa-exchange-alt',
                            'group' => 'login.confirm',
                            'is_dev_feature' => false,
                        ],
                        [
                            'icon' => 'fas fa-sign-out-alt',
                            'group' => 'logout',
                            'is_dev_feature' => false,
                        ],
                    ],
                ],
            ],
        ];

        $navigations = [];

        foreach ($configs as $site => $items) {
            foreach ($items as $item) {
                $subs = $item['subs'] ?? [];
                unset($item['subs']);
                // prepend site to all group & link
                $item['group'] = "{$site}.{$item['group']}";
                $item['link'] = isset($item['link']) ? "{$site}.{$item['link']}" : null;
                !isset($item['name']) && $item['name'] = "routes.{$item['link']}";
                isset($item['position']) || $item['position'] = 'sidebar';
                $item['site'] = $site;
                $item['parent'] = null;

                $navigations[] = $item;

                if ($subs) {
                    foreach ($subs as $subItem) {
                        $subItem['group'] = "{$site}.{$subItem['group']}";
                        $link = $subItem['group'] . '.index';
                        if (!Route::has($link)) {
                            $link = $subItem['group'];
                        }
                        $name = 'routes.' . $link;

                        $navigations[] = [
                            'name' => $name,
                            'icon' => $subItem['icon'] ?? null,
                            'link' => $link,
                            'group' => $subItem['group'],
                            'parent' => $item['name'],
                            'is_dev_feature' => $subItem['is_dev_feature'],
                            'position' => $item['position'],
                            'site' => $site,
                        ];
                    }
                }
            }
        }

        Navigation::truncate();
        Navigation::insert($navigations);

        cache()->forget('admin.navigations');
        cache()->forget('frontend.navigations');
        cache()->forget('frontend.headers');
    }
}
