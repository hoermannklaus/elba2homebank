<?php

class ElbaHomeBankConverter {

	public $importHomebankDir;
	public $exportElbaDir;
	private $curDir;
	
	/**
	 * Constructor for new converter objects
	 */
	public function __construct() {
		$curDir = dirname(__FILE__) . "/";
	}
	
	/**
	 * Function starts the conversion
	 *
	 * @return void
	 */
	public function startConversion() {
		$exportElbaFiles = $this->removeUnwantedExportFiles(scandir($this->curDir . $this->exportElbaDir));
		foreach ($exportElbaFiles as $exportElbaFile) {
			if (!$this->checkIfHomebankImportFileExists($exportElbaFile)) {
				echo "convert";
			} else {
				echo "dont convert";
			}
		}
	}
	
	/**
	 * Checks if there is a converted file for homebank for the given elba export file.
	 *
	 * @param string $file Filename of the elba export file
	 * @return boolean True if there is already a file, false if not.
	 */
	private function checkIfHomebankImportFileExists($file) {
		return file_exists($this->curDir . $this->importHomebankDir . "/" . $this->getImportFilename($file));
	}
	
	/**
	 * Returns the import filename for a given elba export filename.
	 *
	 * @param string $exportFilename The filename of the elba export file.
	 * @return string The filename of the homebank import file.
	 */
	private function getImportFilename($exportFilename) {
		$parts = explode(".", $exportFilename);
		return $parts[0] . ".homebank." . $parts[1];
	}
	
	/**
	 * Function removes the files "." and "..", as well as hidden files, 
	 * starting with a dot. The first 2 are removed using "array_diff", the
	 * hidden files are removed comparing the first character.
	 *
	 * @param array $files The to be cleaned files
	 * @return array The cleaned export files in the given export directory
	 */
	private function removeUnwantedExportFiles($files) {
		$newFiles = array();
		$files = array_diff($files, array(".", ".."));
		foreach ($files as $file) {
			if ($file[0] != ".") {
				$newFiles[] = $file;
			}
		}
		return $newFiles;
	}
}

// Create
$converter = new ElbaHomeBankConverter();

// Configure
$converter->importHomebankDir = "importHomebank";
$converter->exportElbaDir = "exportElba";

// Execute
$converter->startConversion();

// 2. Check if files have a converted file in the folder "importHomebank"
// 3. If not, convert it
//		=> Create file with filename
// 		=> 

?>
