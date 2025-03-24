<!DOCTYPE html>
<html lang="vi">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Sơ đồ ghế</title>
     <link rel="stylesheet" href="/public/css/admin.css">
     <link rel="stylesheet" href="/public/css/table.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
     <style>
          .seat-map {
               border-collapse: collapse;
               margin: 20px auto;
               text-align: center;
          }

          .row-label {
               font-weight: bold;
               padding: 5px;
               text-align: center;
               width: 30px;
          }

          .seat,
          .empty-seat {
               width: 40px;
               height: 40px;
               text-align: center;
               border: 1px solid #ccc;
               font-size: 16px;
               font-weight: bold;
               cursor: pointer;
          }

          .normal-seat {
               background-color: #b0b0b0;
               color: white;
          }

          .vip-seat {
               background-color: #f39c12;
               color: white;
          }

          .booked {
               opacity: 0.5;
          }

          .unavailable {
               background-color: #ff0000 !important;
               color: white;
          }

          .seat-legend {
               display: flex;
               justify-content: center;
               gap: 20px;
               margin-bottom: 10px;
          }

          .legend {
               width: 20px;
               height: 20px;
               display: inline-block;
               border: 1px solid black;
          }

          .normal-seat.legend {
               background-color: #b0b0b0;
          }

          .vip-seat.legend {
               background-color: #f39c12;
          }

          .unavailable.legend {
               background-color: #ff0000;
          }

          .seat-form {
               display: inline;
          }

          .seat-button {
               border: none;
               padding: 0;
               margin: 0;
               background: none;
               width: 100%;
               height: 100%;
               cursor: pointer;
               font-size: 16px;
               font-weight: bold;
          }
     </style>
</head>

<body>
     <h2 style="text-align: center; margin-bottom: 10px;">Màn hình</h2>

     <div class="seat-legend">
          <span class="legend normal-seat"></span> Ghế Thường
          <span class="legend vip-seat"></span> Ghế VIP
          <span class="legend unavailable"></span> Ghế Không Sử Dụng
     </div>

     <table class="seat-map">
          <?php
          $alphabet = range('A', 'Z');
          for ($r = 1; $r <= $max_row; $r++) {
               echo "<tr>";
               echo "<td class='row-label'>{$alphabet[$r - 1]}</td>";

               for ($c = 1; $c <= $max_column; $c++) {
                    $seat_found = null;
                    foreach ($seats as $seat) {
                         if ($seat['row'] == $r && $seat['column'] == $c) {
                              $seat_found = $seat;
                              break;
                         }
                    }

                    if ($seat_found) {
                         $seat_class = ($seat_found['type_seat'] == 'vip') ? 'vip-seat' : 'normal-seat';
                         $status_class = $seat_found['status'] == 'booked' ? 'booked' : ($seat_found['status'] == 'unavailable' ? 'unavailable' : '');
                         $new_type = ($seat_found['type_seat'] == 'vip') ? 'normal' : 'vip';
                         $new_status = ($seat_found['status'] == 'available') ? 'booked' : ($seat_found['status'] == 'booked' ? 'unavailable' : 'available');

                         echo "<td class='seat $seat_class $status_class'>
                        <form class='seat-form' method='POST' action='index.php?controller=seat&action=updateSeatType'>
                            <input type='hidden' name='id' value='{$seat_found['id']}'>
                            <input type='hidden' name='type_seat' value='$new_type'>
                            <input type='hidden' name='theater_id' value='$theater_id'>
                            <button type='submit' class='seat-button'>{$alphabet[$r - 1]}{$c}</button>
                        </form>
                        <form class='seat-form' method='POST' action='index.php?controller=seat&action=updateSeatStatus'>
                            <input type='hidden' name='id' value='{$seat_found['id']}'>
                            <input type='hidden' name='status' value='$new_status'>
                            <input type='hidden' name='theater_id' value='$theater_id'>
                            <button type='submit' class='seat-button' style='display:none;'>{$alphabet[$r - 1]}{$c}</button>
                        </form>
                    </td>";
                    } else {
                         echo "<td class='empty-seat'>
                        <form class='seat-form' method='POST' action='index.php?controller=seat&action=addSeat'>
                            <input type='hidden' name='theater_id' value='$theater_id'>
                            <input type='hidden' name='row' value='$r'>
                            <input type='hidden' name='column' value='$c'>
                            <button type='submit' class='seat-button'>{$alphabet[$r - 1]}{$c}</button>
                        </form>
                    </td>";
                    }
               }
               echo "</tr>";
          }
          ?>
     </table>
     <a href="index.php?controller=seat&action=index" class="btn-back">
          <i class="fas fa-arrow-left"></i> Quay Lại
     </a>
     <script>
          document.querySelectorAll('.seat').forEach(seat => {
               seat.addEventListener('click', (e) => {
                    e.preventDefault();
                    seat.querySelector('form[action*="updateSeatType"]').submit();
               });

               seat.addEventListener('contextmenu', (e) => {
                    e.preventDefault();
                    seat.querySelector('form[action*="updateSeatStatus"]').submit();
               });
          });

          document.querySelectorAll('.empty-seat').forEach(emptySeat => {
               emptySeat.addEventListener('click', (e) => {
                    e.preventDefault();
                    emptySeat.querySelector('form[action*="addSeat"]').submit();
               });
          });
     </script>
</body>

</html>