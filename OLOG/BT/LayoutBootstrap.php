<?php

namespace OLOG\BT;

use OLOG\Layouts\InterfaceLayout;
use OLOG\Sanitize;

class LayoutBootstrap implements
	InterfaceLayout
{

static public function render($content_html, $action_obj = null) {

$page_toolbar_html = '';

// запрашиваем до начала вывода на страницу, потому что там может редирект или какая-то еще работа с хидерами
if ($action_obj) {
	if ($action_obj instanceof InterfacePageToolbarHtml) {
		$page_toolbar_html = $action_obj->pageToolbarHtml();
	}
}

?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
	      integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
	        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
	        crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
	<?php
	$application_title = BTConfig::getApplicationTitle();

	$menu_arr = [];
	$menu_classes_arr = BTConfig::getMenuClassesArr();

	if ($menu_classes_arr) {
		foreach ($menu_classes_arr as $menu_class) {
			if (in_array(InterfaceMenu::class, class_implements($menu_class))) {
				$menu_arr = array_merge($menu_arr, $menu_class::menuArr());
			}
			if (in_array(InterfaceMenu::class, class_implements($menu_class))) {
				$menu_arr = array_merge($menu_arr, $menu_class::menuArr());
			}
		}
	}

	?>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
				        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/"><?= $application_title ?></a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<?php
					foreach ($menu_arr as $menu_item_obj) {
						if ($menu_item_obj instanceof \OLOG\BT\MenuItem) {
							$children_arr = $menu_item_obj->getChildrenArr();

							$href = 'href="#"';
							if ($menu_item_obj->getUrl()) {
								$href = 'href="' . Sanitize::sanitizeUrl($menu_item_obj->getUrl()) . '"';
							}

							$icon = '';
							if ($menu_item_obj->getIconClassesStr()) {
								$icon = '<i class="' . $menu_item_obj->getIconClassesStr() . '"></i> ';
							}

							if (count($children_arr)) {
								?>
								<li class="dropdown">
									<a <?= $href ?> class="dropdown-toggle" data-toggle="dropdown" role="button"
									                aria-haspopup="true" aria-expanded="false">
										<?= $icon . Sanitize::sanitizeTagContent($menu_item_obj->getText()) ?> <span
											class="caret"></span>
									</a>
									<ul class="dropdown-menu">
										<?php
										/** @var  $child_menu_item_obj MenuItem */
										foreach ($children_arr as $child_menu_item_obj) {
											$children_href = '';
											if ($child_menu_item_obj->getUrl()) {
												$children_href = 'href="' . Sanitize::sanitizeUrl($child_menu_item_obj->getUrl()) . '"';
											}

											$children_icon = '';
											if ($child_menu_item_obj->getIconClassesStr()) {
												$children_icon = '<i class="' . $child_menu_item_obj->getIconClassesStr() . '"></i> ';
											}
											?>
											<li>
												<a <?= $children_href ?>><?= $children_icon . Sanitize::sanitizeTagContent($child_menu_item_obj->getText()) ?></a>
											</li>
											<?php
										}
										?>
									</ul>
								</li>
								<?php
							} else {
								?>
								<li>
									<a <?= $href ?>><?= $icon . Sanitize::sanitizeTagContent($menu_item_obj->getText()) ?></a>
								</li>
								<?php
							}
						}
						elseif ($menu_item_obj instanceof \OLOG\Layouts\MenuItem) {
							$children_arr = $menu_item_obj->getChildrenArr();

							$href = 'href="#"';
							if ($menu_item_obj->getUrl()) {
								$href = 'href="' . Sanitize::sanitizeUrl($menu_item_obj->getUrl()) . '"';
							}

							$icon = '';
							if ($menu_item_obj->getIconClassesStr()) {
								$icon = '<i class="' . $menu_item_obj->getIconClassesStr() . '"></i> ';
							}

							if (count($children_arr)) {
								?>
								<li class="dropdown">
									<a <?= $href ?> class="dropdown-toggle" data-toggle="dropdown" role="button"
									                aria-haspopup="true" aria-expanded="false">
										<?= $icon . Sanitize::sanitizeTagContent($menu_item_obj->getText()) ?> <span
											class="caret"></span>
									</a>
									<ul class="dropdown-menu">
										<?php
										/** @var  $child_menu_item_obj MenuItem */
										foreach ($children_arr as $child_menu_item_obj) {
											$children_href = '';
											if ($child_menu_item_obj->getUrl()) {
												$children_href = 'href="' . Sanitize::sanitizeUrl($child_menu_item_obj->getUrl()) . '"';
											}

											$children_icon = '';
											if ($child_menu_item_obj->getIconClassesStr()) {
												$children_icon = '<i class="' . $child_menu_item_obj->getIconClassesStr() . '"></i> ';
											}
											?>
											<li>
												<a <?= $children_href ?>><?= $children_icon . Sanitize::sanitizeTagContent($child_menu_item_obj->getText()) ?></a>
											</li>
											<?php
										}
										?>
									</ul>
								</li>
								<?php
							} else {
								?>
								<li>
									<a <?= $href ?>><?= $icon . Sanitize::sanitizeTagContent($menu_item_obj->getText()) ?></a>
								</li>
								<?php
							}
						}
						else {
							throw new \Exception('unsupported menu item object');
						}
					}
					?>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
	<?php


	$h1_str = '';
	//$breadcrumbs_arr = ConfWrapper::getOptionalValue(\OLOG\BT\BTConstants::MODULE_NAME . '.' . \OLOG\BT\BTConstants::BREADCRUMBS_PREFIX_ARR, []);
	$breadcrumbs_arr = BTConfig::getBreadcrumbsPrefixArr();

	if ($action_obj) {
		if ($action_obj instanceof InterfaceBreadcrumbs) {
			$breadcrumbs_arr = array_merge($breadcrumbs_arr, $action_obj->currentBreadcrumbsArr());
		}

		if ($action_obj instanceof InterfacePageTitle) {
			$h1_str = $action_obj->currentPageTitle();
		}
	}

	if (!empty($breadcrumbs_arr)) {
		echo BT::breadcrumbs($breadcrumbs_arr);
	}

	?>
	<div class="page-header">
		<h1><?= $h1_str ?></h1>
	</div>
	<?php

	if ($page_toolbar_html != '') {
		echo '<div>' . $page_toolbar_html . '</div>';
	}

	echo $content_html;
	?>
</div>
</body>
</html>
<?php
}
}
