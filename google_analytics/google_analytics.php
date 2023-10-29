<?php
/**
 * Google Analytics plugin.
 * Adds tracking code on each page.
 */

use Shaarli\Plugin\PluginManager;

/**
 * Initialization function.
 * It will be called when the plugin is loaded.
 * This function can be used to return a list of initialization errors.
 *
 * @param $conf ConfigManager instance.
 *
 * @return array List of errors (optional).
 */
function google_analytics_init($conf)
{
    $googleAnalyticsTrackingID = $conf->get('plugins.GA_TRACKINGID');
    if (empty($googleAnalyticsTrackingID)) {
        $error = 'Google Analytics plugin error: ' .
            'Please define GA_TRACKINGID in the plugin administration page.';
        return array($error);
    }
}

/**
 * Hook render_footer.
 * Executed on every page redering.
 *
 * Template placeholders:
 *   - text
 *   - endofpage
 *   - js_files
 *
 * Data:
 *   - _PAGE_: current page
 *   - _LOGGEDIN_: true/false
 *
 * @param array $data data passed to plugin
 *
 * @return array altered $data.
 */
function hook_google_analytics_render_footer($data, $conf)
{
    $googleAnalyticsTrackingID = $conf->get('plugins.GA_TRACKINGID');
    if (empty($googleAnalyticsTrackingID)) {
        return $data;
    }

	$data['endofpage'][] = '<script async src="https://www.googletagmanager.com/gtag/js?id=' . $googleAnalyticsTrackingID . '"></script>' .
'	<script>'.
'	window.dataLayer = window.dataLayer || [];'.
'	function gtag(){dataLayer.push(arguments);}'.
'	gtag("js", new Date());'.
'	gtag("config", "' . $googleAnalyticsTrackingID . '");'.
'	</script>';

	return $data;
}
?>
