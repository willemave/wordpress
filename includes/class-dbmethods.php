<?php
if (!class_exists('BF_DBMethods')) {

	class BF_DBMethods {
		public function __construct(){
			global $wpdb;
			// $this->TablePrefix = $wpdb->prefix.'bf_';
			$this->OptionsTable = $wpdb->prefix.'options';
			// $this->pluginDir  = dirname(__FILE__) . '/includes/class-pluginmethods.php'
		 }

		 /**
		 * Create Bookfresh Database Tables
		 */
		function CreateBookfreshTables(){
			global $wpdb;

			if (!empty($wpdb->charset))
					$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
			if (!empty($wpdb->collate))
					$charset_collate .= " COLLATE {$wpdb->collate}";
			
			$table = $this->OptionsTable;
			$structure = "CREATE TABLE IF NOT EXISTS `{$table}` (
					`ID` bigint(20) NOT NULL AUTO_INCREMENT,
					`option_name` varchar(64) NOT NULL,
					`option_value` longtext NOT NULL,
					`autoload` varchar(20) NOT NULL DEFAULT 'yes',
					PRIMARY KEY (`ID`),
					UNIQUE KEY `option_name` (`option_name`),
					KEY `autoload` (`autoload`)
				) {$charset_collate}";
			$wpdb->query($structure);
		}

		/**
		 * Retrieves an option's value
		 * @param string $option The name of the option
		 * @return string The option value
		 */
		function GetOption($option){
			global $wpdb;

			$row=$wpdb->get_row($wpdb->prepare("SELECT `option_value` FROM `{$this->OptionsTable}` WHERE `option_name`='%s'",$option));
			if(!is_object($row)) return false;
			$value = $row->option_value;

			$value=maybe_unserialize($value);

			return $value;
		}

		/**
		 * Deletes the option names passed as parameters
		 */
		function DeleteOption($option) {
		  global $wpdb;
		  $wpdb->query($wpdb->prepare("DELETE FROM `{$this->OptionsTable}` WHERE `option_name`='%s'", $option));
		}

		/**
		 * Saves an option
		 * @param string $option Name of the option
		 * @param string $value Value of option
		 */
		function SaveOption($option,$value){
			global $wpdb;

			$result =$this->GetOption($option);
			if($result === false){
				$result = $this->AddOption($option,$value);
				return $result ? true : false;
			}elseif($result != $value){
				$data=array(
					'option_name'=>$option,
					'option_value'=>maybe_serialize($value)
				);
				$where=array(
					'option_name'=>$option
				);
				$result = $wpdb->update($this->OptionsTable,$data,$where);
				
				return $result? true : false;
			}
		}

		/**
		 * Adds a new option. Will not add it if the option already exists.
		 * @param string $option Name of the option
		 */
		function AddOption($option,$value){
			global $wpdb;
	        
	        $data=array(
	          'option_name'=>$option,
	          'option_value'=>maybe_serialize($value)
	        );

	        $result = $wpdb->insert($this->OptionsTable,$data);
			return $result ? true : false;
		}
	}
}
?>