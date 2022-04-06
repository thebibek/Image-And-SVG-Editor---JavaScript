<?php
	// To Date Ago
	function toDateAgo($date2){
            $arr = explode(" ", $date2);
            $dat = $arr[0];
            $tim = $arr[1];
        $c_y = date("Y");
            $c_m = date("m");
            $c_d = date("d");
            $m_days =cal_days_in_month(CAL_GREGORIAN,$c_m,$c_y);
            $p_date = strtotime($dat);
            $p_y = date("Y",$p_date);
            $p_m = date("m",$p_date);
            $p_d = date("d",$p_date);
            if($c_d >= $p_d){
                $f_d = $c_d - $p_d;
            } else {
                $c_d = $c_d + $m_days;
                $c_m -= 1;
                $f_d = $c_d - $p_d; 
            }
            if($c_m >= $p_m){
                $f_m = $c_m - $p_m;
            } else {
                $c_m = $c_m + 12;
                $c_y -= 1;
                $f_m = $c_m - $p_m; 
            }
            $f_y = $c_y - $p_y;
            if($f_y < 1){
                 if($f_m < 1){
                    if($f_d < 1){
                        $c_time = time();
                        $p_time = strtotime($tim);
                        $f_time = $c_time - $p_time;
                        $h = date('h',$f_time) -1;
                        $m = date('i',$f_time);
                        $s = date('s',$f_time);
                        if($h < 1){
                            if($m < 1){
                                $c_time = $s . " second";
                            } else {
                                $c_time = $m . " minutes";
                            }
                        } else {
                            $c_time = $h . " hours";
                        }
                    } else if($f_d == 1) {
                        $c_time = $f_d . " day";
                    } else {
                        $c_time = $f_d . " days";
                    }
                 } else if($f_m == 1) {
                    $c_time = $f_m . " month";
                 } else {
                    $c_time = $f_m . " months";
                 }
            } else if ($f_y == 1) {
                $c_time = $f_y . " year";
            } else {
                $c_time = $f_y . " years";
            }
            return $c_time . " ago";
	}
	// To Month Date
	function monthDate($date2){
		$date1 = date("Y-m-d");
		$date2 = explode(" ", $date2);
		$date2 = $date2[0];
		$date2 = date("d F, Y", strtotime($date2));
		return $date2;
	}
	// Success Msg
	function success($data, $redirect = "none"){
		if($redirect != "none"){
			return json_encode(array("status"=>"success", "data"=> $data, "redirect" => $redirect));
		} else {
			return json_encode(array("status"=>"success", "data"=> $data));
		}
	}
    // Error Msg
	function error($data = "Error Please Try Again!", $heading = false){
        if($heading){
            return json_encode(array("status"=> "error", "data"=> $data, "heading" => $heading));
        } else {
            return json_encode(array("status"=> "error", "data"=> $data));
        }
	}
    // Redirect To
    function redirectTo($url){
        echo '<script>location.assign("'. $url .'");</script>';
        die();
    }