<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kalkulator Analog Dengan Riwayat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container mt-5">
        <div class="calculator mb-1">
            <div class="card">
                <div class="text-end mb-1">
                    <label class="form-check-label me-0 col-form-label-sm">Tema</label>
                    <div class="form-check form-switch d-inline-block">
                        <input class="form-check-input" type="checkbox" id="themeToggle">
                    </div>
                </div>
                <div class="card-header text-center bg-primary text-white">
                    <h4>Kalkulator Analog</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type="text" class="form-control mb-3 display" name="display" id="display" readonly
                            value="<?php

                                    use FFI\Exception;

                                    echo isset($_POST['display']) ? $_POST['display'] : ''; ?>">
                        <div class="row g-2 mb-2">
                            <?php
                            $buttons = [
                                ['7', '8', '9', '/'],
                                ['4', '5', '6', '*'],
                                ['1', '2', '3', '-'],
                                ['0', 'C', '=', '+']
                            ];
                            foreach ($buttons as $row) {
                                foreach ($row as $btn) {
                                    $class = is_numeric($btn) ? 'btn-number' : ($btn === 'C' || $btn === '=' ? 'btn-clear' : 'btn-operator');
                                    echo '<div class="col-3">';
                                    echo '<button type="submit" name="button" value="' . $btn . '" class="btn ' . $class . ' w-100">' . $btn . '</button>';
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>
                        <textarea class="form-control mb-3" name="history" rows="5" readonly>
                    <?php echo isset($_POST['history']) ? $_POST['history'] : ''; ?>
                    </textarea>
                        <button type="submit" name="clear_history" class="btn btn-clear-history w-100">CLEAR HISTORY</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $current = $_POST['display'] ?? '';
        $button = $_POST['button'] ?? '';
        $history = $_POST['history'] ?? '';
        if (isset($_POST['clear_history'])) {
            $history = '';
        } elseif ($button === 'C') {
            $current = '';
        } elseif ($button === '=') {
            try {
                $result = eval("return $current;");
                $history .= $current . ' = ' . $result . PHP_EOL;
                $current = $result;
            } catch (Exception $e) {
                $current = 'Error';
            }
        } else {
            $current .= $button;
        }
        echo "<script> 
        document.getElementById('display').value = '$current';
        document.getElementsByName('history')[0].value = `$history`;
        </script>";
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="script.js"></script>
</body>

</html>