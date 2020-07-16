<?php
/**
 * Plugin Name:     SearchWP Block
 * Plugin URI:      https://horttcore.de
 * Description:     A SearchWP Block
 * Author:          Ralf Hortt
 * Author URI:      https://horttcore.de
 * Text Domain:     searchwp-block
 * Domain Path:     /languages
 * Version:         1.0
 *
 * @package RalfHortt/SearchWPBlock
 */

namespace RalfHortt\SearchWPBlock;

use RalfHortt\SearchWPBlock\Block\SearchWPBlock;
use RalfHortt\Plugin\PluginFactory;
use RalfHortt\TranslatorService\Translator;
use RalfHortt\Assets\EditorScript;

// ------------------------------------------------------------------------------
// Prevent direct file access
// ------------------------------------------------------------------------------
if (!defined('WPINC')) :
    die;
endif;

// ------------------------------------------------------------------------------
// Autoloader
// ------------------------------------------------------------------------------
$autoloader = dirname(__FILE__).'/vendor/autoload.php';

if (is_readable($autoloader)) :
    require_once $autoloader;
endif;

// ------------------------------------------------------------------------------
// Bootstrap
// ------------------------------------------------------------------------------
PluginFactory::create()
    ->addService(Translator::class, 'searchwp-block', dirname(plugin_basename(__FILE__)).'/languages/')
    ->addService(EditorScript::class, 'searchwp-block', plugins_url('/dist/js/searchwp-block.js', __FILE__), ['wp-blocks', 'wp-element', 'wp-components'], true, true)
    ->addService(SearchWPBlock::class)
    ->boot();
