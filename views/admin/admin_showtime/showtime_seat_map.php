<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Sơ đồ ghế - Suất chiếu <?php echo htmlspecialchars($showtime['id']); ?></title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
     <style>
          body {
               font-family: Arial, sans-serif;
               margin: 0;
               padding: 20px;
               background: #f4f4f4;
          }

          h1 {
               text-align: center;
               color: #333;
          }

          .legend {
               margin-bottom: 30px;
          }

          .legend h3 {
               font-size: 18px;
               color: #555;
               margin-bottom: 10px;
          }

          .legend-items {
               display: flex;
               gap: 20px;
               flex-wrap: wrap;
          }

          .legend-item {
               display: flex;
               align-items: center;
               gap: 8px;
               font-size: 14px;
               color: #666;
          }

          .seat {
               width: 50px;
               height: 50px;
               margin: 5px;
               display: inline-block;
               text-align: center;
               line-height: 50px;
               border: 2px solid #ddd;
               border-radius: 5px;
               font-size: 14px;
               font-weight: bold;
               transition: transform 0.2s ease, box-shadow 0.2s ease;
               cursor: default;
               position: relative;
          }

          .seat:hover {
               transform: scale(1.1);
               box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
          }

          .normal.available {
               background: #28a745;
               color: white;
               border-color: #218838;
          }

          .vip.available {
               background: #ffc107;
               color: black;
               border-color: #e0a800;
          }

          .normal.booked,
          .vip.booked {
               background: #dc3545;
               color: white;
               border-color: #c82333;
          }

          .normal.unavailable,
          .vip.unavailable {
               background: #6c757d;
               color: white;
               border-color: #5a6268;
          }

          .seat-map {
               text-align: center;
               margin: 0 auto;
               max-width: 100%;
               overflow-x: auto;
               padding: 20px;
               background: #f8f9fa;
               border-radius: 10px;
               box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
          }

          .btn-back {
               display: inline-block;
               margin-top: 20px;
               padding: 10px 20px;
               background: #6c757d;
               color: white;
               text-decoration: none;
               border-radius: 5px;
               transition: background 0.3s ease;
          }

          .btn-back:hover {
               background: #5a6268;
          }

          .btn-toggle {
               position: absolute;
               top: 2px;
               right: 2px;
               font-size: 10px;
               padding: 2px 5px;
               border-radius: 3px;
               border: none;
               cursor: pointer;
               color: white;
          }

          .btn-book {
               background: #dc3545;
          }

          .btn-cancel {
               background: #28a745;
          }
     </style>
</head>

<body>
     <h1>Sơ đồ ghế - Suất chiếu <?php echo htmlspecialchars($showtime['id']); ?> (Phim:
          <?php echo htmlspecialchars($showtime['movie_title']); ?>, Phòng:
          <?php echo htmlspecialchars($showtime['room_name']); ?>)</h1>

     <div class="legend">
          <h3>Chú thích:</h3>
          <div class="legend-items">
               <div class="legend-item">
                    <span class="seat normal available"></span> Ghế thường - Có thể sử dụng
               </div>
               <div class="legend-item">
                    <span class="seat vip available"></span> Ghế VIP - Có thể sử dụng
               </div>
               <div class="legend-item">
                    <span class="seat normal booked"></span> Ghế đã đặt
               </div>
               <div class="legend-item">
                    <span class="seat normal unavailable"></span> Ghế không khả dụng
               </div>
          </div>
     </div>

     <div class="seat-map">
          <?php
          for ($r = 1; $r <= $room['rows']; $r++) {
               for ($c = 1; $c <= $room['columns']; $c++) {
                    $seat = $seatMap[$r][$c] ?? null;
                    if ($seat) {
                         $class = $seat['type_seat'] . ' ' . $seat['showtime_status'];
                         $label = "R{$r}C{$c}";
                         $button_class = ($seat['showtime_status'] === 'available') ? 'btn-book' : 'btn-cancel';
                         $button_label = ($seat['showtime_status'] === 'available') ? 'Đặt' : 'Hủy';
                         echo "<div class='seat $class'>
                            $label
                            <form method='POST' action='index.php?controller=showtime&action=toggleSeatStatus' style='display:inline;'>
                                <input type='hidden' name='showtime_id' value='{$showtime['id']}'>
                                <input type='hidden' name='seat_id' value='{$seat['id']}'>
                                <input type='hidden' name='current_status' value='{$seat['showtime_status']}'>
                                <button type='submit' class='btn-toggle $button_class'>$button_label</button>
                            </form>
                          </div>";
                    } else {
                         $class = 'unavailable';
                         $label = 'X';
                         echo "<div class='seat $class'>$label</div>";
                    }
               }
               echo "<br>";
          }
          ?>
     </div>

     <a href="index.php?controller=showtime&action=index" class="btn-back">
          <i class="fas fa-arrow-left"></i> Quay Lại
     </a>
</body>

</html>