<?php
function render_initial_form() {
  echo <<<HTML
    <html>
      <head>
          <title>Soal 1</title>
          <style>
              .mb-2 {
                  margin-bottom: 8px;
              }
          </style>
      </head> 
      <body>
          <form action="soal1.php" method="post">
              <input type="hidden" name="form" value="INITIAL_FORM" />
              <div class="mb-2">
                  <label>Inputkan Jumlah Baris:</label>
                  <input type="number" name="row" />
              </div> 
              <div class="mb-2">
                  <label>Inputkan Jumlah Kolom:</label>
                  <input type="number" name="col" />
              </div> 
              <div>
                  <button>SUBMIT</button>
              </div>
          </form>
      </body>
  </html>
  HTML;
}

function render_second_form($row, $col) {
  $fields = "";
  for ($i = 0; $i < $row; $i++) {
    $fields .= '<div style="display: flex; margin-top: 8px;">';
    for ($j = 0; $j < $col; $j++) {
      $rowIndex = $i + 1;
      $colIndex = $j + 1;
      $fields .= <<<HTML
                <div style="margin-right: 8px;">
                  <label>$rowIndex.$colIndex</label>
                  <input type="text" name="v-$i-$j" />
                </div>
                HTML; 
    }
    $fields .= "</div>";
  }

  echo <<<HTML
    <html>
      <head>
          <title>Soal 1 - Second Form</title>
      </head> 
      <body>
          <form action="soal1.php" method="post">
              <input type="hidden" name="form" value="SECOND_FORM" />
              $fields 
              <div style="margin-top: 8px;">
                  <button>SUBMIT</button>
              </div>
          </form>
      </body>
  </html>
  HTML;
}

function render_result($data) {
  $ret = "";
  foreach ($data as $d) {
    $row = $d['row'] + 1;
    $col = $d['col'] + 1;
    $value = htmlspecialchars($d['value'], ENT_QUOTES);

    $ret .= <<<HTML
        <p style="margin-top: 0px; margin-bottom: 4px;">$row.$col: $value</p>
      HTML;
  }

  echo <<<HTML
    <html>
      <head>
          <title>Soal 1 - Result</title>
      </head> 
      <body>
          $ret
      </body>
  </html>
  HTML;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $form = $_POST['form'];
  if ($form === 'INITIAL_FORM') {
    $row = $_POST['row'] ?? 0;
    $col = $_POST['col'] ?? 0;
    render_second_form($row, $col);
  } else if ($form === 'SECOND_FORM') {
    $data = [];

    foreach ($_POST as $key => $value) {
      if (! str_starts_with($key, 'v-')) {
        continue; 
      }
      $parts = explode('-', $key);
      if (count($parts) !== 3) {
        continue; 
      }

      $data[] = [
        'row' => $parts[1], 
        'col' => $parts[2], 
        'value' => $value
      ];
    }

    render_result($data);
  }
} else {
  render_initial_form();
}
?>
