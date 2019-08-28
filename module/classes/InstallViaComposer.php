<?php
namespace x51\bitrix\module\recaptchav3;
use Composer\Installer\PackageEvent;

class InstallViaComposer{
	
	protected static $bxName = 'x51.recaptchav3';
	
	static public function postPackageInstall(/*PackageEvent */$event) {
		echo "Install module bitrix-racaptcha-v3\n";
		$modulesDir = static::checkBxModulesDir($event->getComposer()->getPackage());
		$bxModuleDir = realpath(__DIR__.'/../');
		
		$slPath = $modulesDir.'/'.static::$bxName;
		
		if (file_exists($slPath) && is_link($slPath)) {
			@unlink($slPath);
		}
		
		if (!file_exists($slPath)) {
			//echo $bxModuleDir."\n".$slPath."\n";
			//$d = getcwd();
			chdir($modulesDir);
			symlink($bxModuleDir, static::$bxName);
			//chdir($d);
		} else {
			echo "Error. Found dir {static::$bxName}\n";
		}
	} // end postPackageInstall
	
	static public function postPackageUninstall(/*PackageEvent */$event) {
		echo "Uninstall module bitrix-racaptcha-v3\n";
		$modulesDir = static::checkBxModulesDir($event->getComposer()->getPackage());
		$slPath = $modulesDir.'/'.static::$bxName;
		if (file_exists($slPath) && is_link($slPath)) {
			@unlink($slPath);
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
	
		if (!$modulesDir) {
			$p = realpath(__DIR__.'/../../../../../modules');
			$modulesDir = is_dir($p) ? $p : '';
		}
		return $modulesDir;
	}	
	
} // end class