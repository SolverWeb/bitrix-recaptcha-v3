<?php
namespace x51\bitrix\module\recaptchav3;
use Composer\Installer\PackageEvent;

class InstallViaComposer{
	
	protected static $bxName = 'x51.recaptchav3';
	
	static public function postPackageInstall(/*PackageEvent */$event) {
		
		$package = $event->getOperation()->getPackage();
		if ($package->getName() == 'quanzo/bitrix-recaptcha-v3') {
			echo "Install module bitrix-racaptcha-v3\n";
			$modulesDir = static::checkBxModulesDir($event->getComposer()->getPackage());
			$bxModuleDir = realpath(__DIR__.'/../');		
			$slPath = $modulesDir.'/'.static::$bxName;
		
			if (file_exists($slPath) && is_link($slPath)) {
				@unlink($slPath);
			}
		
			if (!file_exists($slPath)) {
				chdir($modulesDir);
				symlink($bxModuleDir, static::$bxName);
			} else {
				echo "Error. Found dir {static::$bxName}\n";
			}
		}
	} // end postPackageInstall
	
	static public function prePackageUninstall(/*PackageEvent */$event) {
		$package = $event->getOperation()->getPackage();
		if ($package->getName() == 'quanzo/bitrix-recaptcha-v3') {
			echo "Uninstall module bitrix-recaptcha-v3\n";
			$modulesDir = static::checkBxModulesDir($package);
			$slPath = $modulesDir.'/'.static::$bxName;
			if (file_exists($slPath) && is_link($slPath)) {
				@unlink($slPath);
			}
		}
	} // end postPackageUninstall\	
	
	static protected function checkBxModulesDir($package) {
		$arPackExtra = $package->getExtra();
		$modulesDir = '';
		if (isset($arPackExtra['modulesDir'])) {
			$p = realpath($arPackExtra['modulesDir']);
			$modulesDir = is_dir($p) ? $p : '';
		}
		if (!$modulesDir && isset($arPackExtra['documentRootDir'])) {
			$p = realpath($arPackExtra['documentRootDir']).'/bitrix/modules';
			$modulesDir = is_dir($p) ? $p : '';
		}
		if (!$modulesDir && isset($arPackExtra['docRoot'])) {
			$p = realpath($arPackExtra['docRoot']).'/bitrix/modules';
			$modulesDir = is_dir($p) ? $p : '';
		}
	
		if (!$modulesDir) {
			$p = realpath(__DIR__.'/../../../../../modules');
			$modulesDir = is_dir($p) ? $p : '';
		}
		return $modulesDir;
	}	
	
} // end class