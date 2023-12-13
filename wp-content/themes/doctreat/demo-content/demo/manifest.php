<?php if (!defined('FW')) die('Forbidden');
/**
 * @var string $uri Demo directory url
 */

$manifest = array();
$manifest['title'] = esc_html__('Doctreat Main', 'doctreat');
$manifest['screenshot'] = get_template_directory_uri(). '/demo-content/images/screenshot.jpg';
$manifest['preview_link'] = 'http://amentotech.com/projects/doctreat/';