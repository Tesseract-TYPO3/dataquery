<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

// Register as Data Provider service
// Note that the subtype corresponds to the name of the database table
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
        'dataquery',
        // Service type
        'dataprovider',
        // Service key
        'tx_dataquery_dataprovider',
        array(
                'title' => 'Data Query',
                'description' => 'Data Provider for Data Query',

                'subtype' => 'tx_dataquery_queries',

                'available' => true,
                'priority' => 50,
                'quality' => 50,

                'os' => '',
                'exec' => '',

                'className' => \Tesseract\Dataquery\Component\DataProvider::class,
        )
);

// Register the dataquery cache table to be deleted when all caches are cleared
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearAllCache_additionalTables']['tx_dataquery_cache'] = 'tx_dataquery_cache';

// Register a hook to clear the cache for a given page
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearPageCacheEval']['tx_dataquery'] = \Tesseract\Dataquery\Cache\CacheHandler::class . '->clearCache';

// Register a hook with datafilter to handle the extra field added by dataquery
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['datafilter']['postprocessReturnValue']['tx_dataquery'] = \Tesseract\Dataquery\Hook\DataFilterHook::class;
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['datafilter']['postprocessEmptyFilterCheck']['tx_dataquery'] = \Tesseract\Dataquery\Hook\DataFilterHook::class;

// Register query check wizard
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1495802337] = [
        'class' => \Tesseract\Dataquery\Wizard\QueryCheckWizard::class,
        'nodeName' => 'dataqueryCheckWizard',
        'priority' => 50
];