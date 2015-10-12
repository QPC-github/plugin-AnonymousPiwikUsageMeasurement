<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\AnonymousPiwikUsageMeasurement\Tracker;

use Piwik\Common;
use Piwik\Plugins\AnonymousPiwikUsageMeasurement\Settings;
use Piwik\Plugins\AnonymousPiwikUsageMeasurement\Tracker;
use Piwik\SettingsPiwik;

/**
 * Defines Settings for AnonymousPiwikUsageMeasurement.
 */
class Targets
{
    /**
     * @var Settings
     */
    private $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function getTargets()
    {
        $targets = array();

        if ($this->settings->trackToPiwik->getValue()) {
            $targets[] = array(
                'url' => 'http://demo.piwik.org/piwik.php',
                'idSite' => 51,
                'cookieDomain' => '*.piwik.org'
            );
        }

        $ownSiteId = $this->settings->ownPiwikSiteId->getValue();
        if ($ownSiteId) {
            $piwikUrl = SettingsPiwik::getPiwikUrl();
            if (!Common::stringEndsWith($piwikUrl, '/')) {
                $piwikUrl .= '/';
            }
            $targets[] = array(
                'url' => $piwikUrl . 'piwik.php',
                'idSite' => (int) $ownSiteId,
                'cookieDomain' => ''
            );
        }

        $customUrl = $this->settings->customPiwikSiteUrl->getValue();
        $customSiteId = $this->settings->customPiwikSiteId->getValue();
        if ($customUrl && $customSiteId) {
            $targets[] = array(
                'url' => $customUrl,
                'idSite' => (int) $customSiteId,
                'cookieDomain' => ''
            );
        }

        return $targets;
    }

}
