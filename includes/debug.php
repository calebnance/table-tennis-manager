<?php
class Debug {

	public function printify($array){
		$tab1	= '    ';
		$tab2	= '        ';
		$tab3	= '            ';
		$tab4	= '                ';
		$tab5	= '                    ';
		$tab6	= '                        ';
		$tab7	= '                            ';
		$return	= "\n";

		$bg = '#393939';
		$white = '#C4E3E3';
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

		//print_r($array);
		//echo '<br /><br />';

		// is object
		if(is_object($array)){
			self::_objectArray($return);
		}
		// is array
		if(is_array($array)){
			self::_array($return);
		}

		echo '<span class="white">(</span>' . $return;
		foreach($array as $key => $value){
			if(is_object($value) || is_array($value)){
				echo $tab1;
				echo '<span class="tan">[' . $key . ']</span> <span class="yellow">=></span> ';
				// is object
				if(is_object($value)){
					self::_objectArray($return);
				}
				// is array
				if(is_array($value)){
					self::_array($return);
				}
				echo $tab2 . '<span class="white">(</span>' . $return;
				foreach($value as $ke => $valu){
					if(is_object($valu) || is_array($valu)){
						echo $tab3;
						echo '<span class="tan">[' . $ke . ']</span> <span class="yellow">=></span> ';
						// is object
						if(is_object($valu)){
							self::_objectArray($return);
						}
						// is array
						if(is_array($valu)){
							self::_array($return);
						}
						echo $tab4 . '<span class="white">(</span>' . $return;
						foreach($valu as $k => $val){
							if(is_object($val) || is_array($val)){
								echo $tab5;
								echo '<span class="tan">[' . $k . ']</span> <span class="yellow">=></span> ';
								// is object
								if(is_object($val)){
									self::_objectArray($return);
								}
								// is array
								if(is_array($val)){
									self::_array($return);
								}
								echo $tab6 . '<span class="white">(</span>' . $return;
								foreach($val as $keys => $va){
									if(is_object($va) || is_array($va)){
										echo $tab7;
										echo '<span class="tan">[' . $keys . ']</span> <span class="yellow">=></span> ';
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
								echo $tab6 . '<span class="white">)</span>' . $return;
							} else {
								self::_printOut($k, $val, $tab5, $return);
							}
						}
						echo $tab4 . '<span class="white">)</span>' . $return;
					} else {
						self::_printOut($ke, $valu, $tab3, $return);
					}
				}
				echo $tab2 . '<span class="white">)</span>' . $return;
			} else {
				self::_printOut($key, $value, $tab1, $return);
			}
		}
		echo '<span class="white">)</span>';
		echo '</pre>';

	}

	private function _printOut($key, $value, $tab, $return){
		echo $tab . '<span class="tan">[' . $key . ']</span> <span class="yellow">=></span> <span class="tan">"' . $value . '"</span><span class="white">,</span>';
		echo $return;
	}

	private function _printArray(){

	}

	private function _objectArray($return){
		echo '<span class="tan">stdClass Object</span>' . $return;
	}

	private function _array($return){
		echo '<span class="tan">Array</span>' . $return;
	}
}
?>
