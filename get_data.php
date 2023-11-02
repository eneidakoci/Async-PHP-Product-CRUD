<?php
	include('config.php');
        $sql = "SELECT * FROM products"
		$result = $conn->query($sql);
		
		// Ruajme te dhenat e emrit dhe cmimit ne array
		while($row = $result->fetch_assoc()){
			$labels[] = $row['name'];
			$datas[] = $row['price'];
		}
		
		// Te dhenat e grafikut
		$data = array(
			'labels' => $labels,
			'datasets' => array(array(
								'label' => "Chart.JS", 
								'fill' => false, 
								'backgroundColor' => array('#ff0000', '#ff4000', '#ff8000', '#ffbf00', '#ffbf00', '#ffff00', '#bfff00', '#80ff00'), 
								'borderColor' => 'black', 
								'data' => $datas,

								)),
		);
		
		// Konvertimi dhe shfaqja e te dhenave ne formatin json
		echo json_encode($data);
	
?>