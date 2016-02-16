<?php
class Debug {

	public function printify($array){
		$tab1	= '  ';
		$tab2	= '    ';
		$tab3	= '      ';
		$tab4	= '        ';
		$tab5	= '          ';
		$tab6	= '            ';
		$tab7	= '              ';
		$return	= "\n";

		$bg = '#393939';
		$white = '#fff';
		$green = '#93C97A';
		$tan = '#FEC66D';
		$yellow = '#BFBF2D';

		echo '<style>';
		echo 'pre { background-color: ' . $bg . '; border-radius: 5px; overflow: auto; padding: 10px; white-space: pre-wrap; width: 1200px; }';
		echo '.tan { color: ' . $tan . ' }';
		echo '.white { color: ' . $white . ' };';
		echo '.green { color: ' . $green . '; }';
		echo '.yellow { color: ' . $yellow. '; }';
		echo '</style>';
		echo '<pre>';
		
		// is object
		if(is_object($array)){
			self::_objectArray($return);
		}
		// is array
		if(is_array($array)){
			self::_array($return);
		}

		echo self::_openLine() . $return;
		foreach($array as $key => $value){
			if(is_object($value) || is_array($value)){
				echo $tab1;
				echo self::_keyLine($key);
				// is object
				if(is_object($value)){
					self::_objectArray($return);
				}
				// is array
				if(is_array($value)){
					self::_array($return);
				}
				echo $tab2 . self::_openLine() . $return;
				foreach($value as $ke => $valu){
					if(is_object($valu) || is_array($valu)){
						echo $tab3;
						echo self::_keyLine($ke);
						// is object
						if(is_object($valu)){
							self::_objectArray($return);
						}
						// is array
						if(is_array($valu)){
							self::_array($return);
						}
						echo $tab4 . self::_openLine() . $return;
						foreach($valu as $k => $val){
							if(is_object($val) || is_array($val)){
								echo $tab5;
								echo self::_keyLine($k);
								// is object
								if(is_object($val)){
									self::_objectArray($return);
								}
								// is array
								if(is_array($val)){
									self::_array($return);
								}
								echo $tab6 . self::_openLine() . $return;
								foreach($val as $keys => $va){
									if(is_object($va) || is_array($va)){
										echo $tab7;
										echo self::_keyLine($keys);
										// is object
										if(is_object($va)){
											self::_objectArray($return);
										}
										// is array
										if(is_array($va)){
											self::_array($return);
										}
									} else {
										self::_printOut($keys, $va, $tab7, $return);
									}
								}
								echo $tab6 . self::_closeLine() . $return;
							} else {
								self::_printOut($k, $val, $tab5, $return);
							}
						}
						echo $tab4 . self::_closeLine() . $return;
					} else {
						self::_printOut($ke, $valu, $tab3, $return);
					}
				}
				echo $tab2 . self::_closeLine() . $return;
			} else {
				self::_printOut($key, $value, $tab1, $return);
			}
		}
		echo self::_closeLine();
		echo '</pre>';

	}

	private function _printOut($key, $value, $tab, $return){
		echo $tab . self::_keyLine($key) . '<span class="tan">"' . $value . '"</span><span class="white">,</span>';
		echo $return;
	}

	private function _printArray(){

	}

	private function _objectArray($return){
		echo '<span class="tan">stdClass Object</span> ';
	}

	private function _array($return){
		echo '<span class="tan">Array</span> ';
	}

	private function _keyLine($key) {
		return '<span class="tan">[<span class="white">' . $key . '</span>]</span> <span class="yellow">=></span> ';
	}

	private function _openLine() {
		return '<span class="white">(</span>';
	}

	private function _closeLine() {
		return '<span class="white">)</span>';
	}
}
?>
