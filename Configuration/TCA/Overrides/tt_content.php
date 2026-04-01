<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die('¯\_(ツ)_/¯');

/* --------------------------------------------------------------------------
 * Add H5P content element types to the CType selector
 * ------------------------------------------------------------------------ */
ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:h5p/Resources/Private/Language/Tca.xlf:h5p.wizard.title',
        'value' => 'h5p_view',
        'icon'  => 'h5p-logo',
        'group' => 'H5P',
        'description' => 'LLL:EXT:h5p/Resources/Private/Language/Tca.xlf:h5p.wizard.description',
    ]
);

ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:h5p/Resources/Private/Language/Tca.xlf:h5p.statistics',
        'value' => 'h5p_statistics',
        'icon'  => 'h5p-logo',
        'group' => 'H5P',
        'description' => 'LLL:EXT:h5p/Resources/Private/Language/Tca.xlf:h5p.statistics.description',
    ]
);

/* --------------------------------------------------------------------------
 * Add new columns to tt_content
 * ------------------------------------------------------------------------ */
ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    [
        'tx_h5p_content' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:h5p/Resources/Private/Language/Tca.xlf:tt_content.tx_h5p_content',
            'config'  => [
                'type'          => 'group',
                'allowed'       => 'tx_h5p_domain_model_content',
                'foreign_table' => 'tx_h5p_domain_model_content',
                'default'       => 0,
                'size'          => 1,
                'minitems'      => 0,
                'maxitems'      => 1,
                // Der 'suggest' Wizard ist seit TYPO3 12+ für 'group' Felder Standard
                // und benötigt keine explizite 'wizards' Definition mehr.
            ],
        ],
        'tx_h5p_display_options' => [
            'exclude' => true,
            'label'   => 'LLL:EXT:h5p/Resources/Private/Language/Tca.xlf:tt_content.tx_h5p_display_options',
            'config'  => [
                'type'    => 'check',
                'items'   => [
                    [
                        'label' => 'LLL:EXT:h5p/Resources/Private/Language/Tca.xlf:tt_content.tx_h5p_display_options.I.0',
                        'value' => 1,
                    ],
                    [
                        'label' => 'LLL:EXT:h5p/Resources/Private/Language/Tca.xlf:tt_content.tx_h5p_display_options.I.1',
                        'value' => 2,
                    ],
                    [
                        'label' => 'LLL:EXT:h5p/Resources/Private/Language/Tca.xlf:tt_content.tx_h5p_display_options.I.2',
                        'value' => 4,
                    ],
                    [
                        'label' => 'LLL:EXT:h5p/Resources/Private/Language/Tca.xlf:tt_content.tx_h5p_display_options.I.3',
                        'value' => 8,
                    ],
                    [
                        'label' => 'LLL:EXT:h5p/Resources/Private/Language/Tca.xlf:tt_content.tx_h5p_display_options.I.4',
                        'value' => 16,
                    ],
                ],
                'cols'    => 2,
                // Falls H5PCore hier nicht verfügbar ist (Namespace), harten Wert nutzen oder Konstante korrekt importieren
                'default' => 9,
            ],
        ],
    ]
);

/* --------------------------------------------------------------------------
 * Palette and Type Configuration
 * ------------------------------------------------------------------------ */
ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'h5p',
    'tx_h5p_content, --linebreak--, tx_h5p_display_options'
);

$GLOBALS['TCA']['tt_content']['types']['h5p_view'] = [
    'showitem' => '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;general,
            --palette--;;header,
            --palette--;LLL:EXT:h5p/Resources/Private/Language/Tca.xlf:tt_content.tx_h5p_display_options;h5p,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
            --palette--;;frames,
            --palette--;;appearanceLinks,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;;access,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ',
];
