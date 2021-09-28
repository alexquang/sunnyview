<?php

/*
|--------------------------------------------------------------------------
| Authentication Language Lines
|--------------------------------------------------------------------------
|
| The following language lines are used during authentication for various
| messages that we need to display to the user. You are free to modify
| these language lines according to your application's requirements.
|
*/

return [
    'admin' => [
        'dashboard' => trans('labels.dashboard'),
        'home' => 'ホーム',
        'companies' => [
            'index' => trans('labels.company'),
            'show' => trans('labels.info'),
            'create' => '契約企業の' . trans('labels.signup'),
            'users' => [
                'index' => trans('labels.user'),
                'create' => trans('labels.user') . 'の' . trans('labels.signup'),
                'edit' => trans('labels.user') . 'の' . trans('labels.modify'),
            ],
            'settings' => [
                'index' => trans('labels.company') . trans('labels.setting'),
            ],
            'groups' => [
                'index' => 'グループ管理',
                'create' => 'グループ管理',
            ],
        ],
        'invoices' => [
            'releases' => [
                'index' => 'リリース',
                'show' => trans('labels.nav.invoice') . trans('labels.info'),
                'overrides' => [
                    'index' => trans('labels.manual') . trans('labels.nav.invoice'),
                ],
                'fees' => [
                    'index' => '追加料金',
                ],
            ],
            'downloads' => [
                'index' => 'ダウンロード',
                'settings' => [
                    'index' => 'ダウンロード' . trans('labels.setting'),
                ],
            ],
            'rates' => [
                'index' => trans('labels.rate') . trans('labels.setting'),
            ],
            'settings' => [
                'downloads' => [
                    'index' => 'ダウンロード' . trans('labels.setting'),
                ],
                'visibilities' => [
                    'index' => '表示' . trans('labels.setting'),
                ],
                'notices' => [
                    'index' => '通知' . trans('labels.setting'),
                ],
            ],
        ],
        'aws' => [
            'accounts' => [
                'index' => trans('labels.account'),
            ],
        ],
        'supports' => [
            'faqs' => [
                'index' => 'FAQ',
            ],
        ],
        'auth' => [
            'permissions' => [
                'index' => trans('labels.permission'),
            ],
            'roles' => [
                'index' => trans('labels.role'),
                'show' => trans('labels.role') . trans('labels.info'),
                'users' => [
                    'index' => 'Role Users',
                    'assign' => [
                        'form' => 'Assign Users',
                    ],
                ],
                'permissions' => [
                    'index' => 'Role Permissions',
                    'attach' => [
                        'form' => 'Attach Permissions',
                    ]
                ]
            ],
            'users' => [
                'create' => trans('labels.user') . '作成',
                'edit' => trans('labels.user') . '編集',
                'index' => trans('labels.user'),
                'show' => trans('labels.user') . trans('labels.info'),
                'roles' => [
                    'index' => 'ユーザーのロール',
                    'attach' => [
                        'form' => '割当ロール'
                    ],
                ],
                'permissions' => [
                    'index' => 'ユーザーの権限',
                    'attach' => [
                        'form' => '割当権限',
                    ]
                ]
            ],
        ],
        'aws' => [
            'accounts' => [
                'index' => trans('labels.account'),
            ],
        ],
        'companies' => [
            'index' => trans('labels.company'),
            'show' => trans('labels.info'),
            'groups' => [
                'index' => 'グループ管理',
                'create' => 'グループ管理',
            ],
            'settings' => [
                'index' => trans('labels.company') . trans('labels.setting'),
            ],
            'users' => [
                'index' => trans('labels.user'),
                'create' => trans('labels.user') . 'の' . trans('labels.signup'),
                'edit' => trans('labels.user') . 'の' . trans('labels.modify'),
            ],
        ],
        'invoices' => [
            'downloads' => [
                'index' => 'ダウンロード',
                'settings' => [
                    'index' => 'ダウンロード' . trans('labels.setting'),
                ],
            ],
            'rates' => [
                'index' => trans('labels.rate') . trans('labels.setting'),
            ],
            'releases' => [
                'index' => 'リリース',
                'show' => trans('labels.nav.invoice') . trans('labels.info'),
                'fees' => [
                    'index' => '追加料金',
                ],
                'overrides' => [
                    'index' => trans('labels.manual') . trans('labels.nav.invoice'),
                ],
            ],
            'settings' => [
                'downloads' => [
                    'index' => 'ダウンロード' . trans('labels.setting'),
                ],
                'notices' => [
                    'index' => '通知' . trans('labels.setting'),
                ],
                'visibilities' => [
                    'index' => '表示' . trans('labels.setting'),
                ],
            ],
        ],
        'supports' => [
            'faqs' => [
                'index' => 'FAQ',
            ],
        ],
        'systems' => [
            'logs' => [
                'index' => '監査ログ',
            ],
            'messages' => [
                'index' => 'メッセージ',
            ],
            'schedules' => [
                'index' => 'スケジュール',
            ],
            'settings' => [
                'index' => '設定',
            ],
        ],
    ],
    'frontend' => [
        'apps' => trans('labels.nav.apps'),
        'dashboard' => trans('labels.dashboard'),
        'logout' => 'ログアウト',
        'aws' => [
            'accounts' => [
                'index' => 'AWSアカウント' . trans('labels.management'),
            ],
            'amis' => [
                'index' => 'AMI' . trans('labels.management'),
            ],
            'cloudwatches' => [
                'rules' => [
                    'index' => 'バックアップ・ルール' . trans('labels.management'),
                ],
            ],
            'eips' => [
                'index' => 'EIP' . trans('labels.management'),
            ],
            'elbs' => [
                'index' => 'ELB設定情報',
            ],
            'lifecycles' => [
                'index' => 'ライフサイクルポリシー' . trans('labels.management'),
            ],
            'regions' => [
                'index' => trans('labels.region') . trans('labels.management'),
            ],
            'trusted-advisors' => [
                'reports' => [
                    'index' => 'レポート',
                ],
                'settings' => [
                    'index' => trans('labels.setting'),
                ],
            ],
        ],
        'contact' => [
            'index' => '連絡先',
        ],
        'ec2' => [
            'instances' => [
                'registered' => [
                    'index' => 'EC2インスタンス一覧',
                ],
                'requests' => [
                    'index' => 'EC2インスタンス申請一覧',
                ],
                'types' => [
                    'index' => 'インスタンスタイプ' . trans('labels.management'),
                ],
            ],
        ],
        'faqs' => [
            'index' => 'FAQ',
        ],
        'help' => [
            'manual' => 'マニュアル',
            'specs' => 'サービス仕様書',
            'terms' => 'サービス利用規約',
        ],
        'groups' => [
            'index' => trans('labels.group') . trans('labels.management'),
        ],
        'invoices' => [
            'csv' => 'コスト配分タグ',
            'pdf' => 'ご請求書',
        ],
        'login' => [
            'confirm' => 'AWSアカウント選択',
        ],
        'logs' => [
            'index' => '監査ログ',
        ],
        'notifications' => [
            'index' => 'お知らせ',
        ],
        'projects' => [
            'index' => trans('labels.project') . trans('labels.management'),
        ],
        'profile' => [
            'index' => 'プロフィール',
        ],
        'rds' => [
            'instances' => [
                'registered' => [
                    'index' => 'RDSインスタンス一覧',
                ],
                'requests' => [
                    'index' => 'RDSインスタンス申請一覧',
                ],
            ],
        ],
        'settings' => [
            'index' => 'システム' . trans('labels.setting'),
        ],
        'users' => [
            'index' => trans('labels.user') . trans('labels.management'),
        ],
    ],
];
