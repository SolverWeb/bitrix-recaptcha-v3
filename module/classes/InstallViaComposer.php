<?php
namespace x51\bitrix\module\recaptchav3;
use Composer\Installer\PackageEvent;

class InstallViaComposer{
	static public function postPackageInstall(PackageEvent $event) {
		$package = $event->getComposer()->getPackage();
		$packDir = $package->getTargetDir();
		$arPackExtra = $package->getExtra();
		
		
		
		
		
	} // end postPackageInstall
	
	static public function postPackageUninstall(PackageEvent $event) {
		$package = $event->getComposer()->getPackage();
		$packDir = $package->getTargetDir();		
		$packExtra = $package->getExtra();
		
	} // end postPackageUninstall\
	
	static public function test($event) {
		echo static::checkModulesDir($event->getComposer()->getPackage());
	}
	
	
	static protected function checkModulesDir($package) {
		$arPackExtra = $package->getExtra();
		$modulesDir = '';
		if (isset($arPackExtra['modulesDir'])) {
			$p = realpath($arPackExtra['modulesDir']);
			$modulesDir = is_dir($p) ? $p :;
		}
		if (!$modulesDir && isset($arPackExtra['documentRootDir'])) {
			$p = realpath($arPackExtra['documentRootDir']).'/bitrix/modules';
			$modulesDir = is_dir($p) ? $p :;
		}
		if (!$modulesDir) {
			$p = realpath($package->getTargetDir().'/../../modules');
			$modulesDir = is_dir($p) ? $p :;
		}
		return $modulesDir;
	}
	
	
} // end class