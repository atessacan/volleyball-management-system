<?php
session_start();
if ($_SESSION['role'] != 'statistician') {
    header("Location: statistics.php");
    exit();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config/db.php';

if (!isset($_GET['id'])) {
    header("Location: statistics.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT *
    FROM player_statistics
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: statistics.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $player_id = $_POST['player_id'];
    $opponent = trim($_POST['opponent']);
    $match_date = $_POST['match_date'];

    $aces = $_POST['aces'];

    $total_serves = $_POST['total_serves'];
$service_errors = $_POST['service_errors'];

$total_attacks = $_POST['total_attacks'];
$attack_kills = $_POST['attack_kills'];
$attack_errors = $_POST['attack_errors'];
$blocked_attacks = $_POST['blocked_attacks'];

$kill_blocks = $_POST['kill_blocks'];
$block_errors = $_POST['block_errors'];
$touch_blocks = $_POST['touch_blocks'];

$total_receptions = $_POST['total_receptions'];
$perfect_receptions = $_POST['perfect_receptions'];
$positive_receptions = $_POST['positive_receptions'];
$reception_errors = $_POST['reception_errors'];

$successful_digs = $_POST['successful_digs'];
$dig_errors = $_POST['dig_errors'];
    $stmt = $conn->prepare("
    UPDATE player_statistics
    SET player_id = ?,
        opponent = ?,
        match_date = ?,
        total_serves = ?,
        aces = ?,
        service_errors = ?,
        total_attacks = ?,
        attack_kills = ?,
        attack_errors = ?,
        blocked_attacks = ?,
        kill_blocks = ?,
        block_errors = ?,
        touch_blocks = ?,
        total_receptions = ?,
        perfect_receptions = ?,
        positive_receptions = ?,
        reception_errors = ?,
        successful_digs = ?,
        dig_errors = ?
    WHERE id = ?
");

    $stmt->bind_param(
    "issiiiiiiiiiiiiiiiii",
    $player_id,
    $opponent,
    $match_date,
    $total_serves,
    $aces,
    $service_errors,
    $total_attacks,
    $attack_kills,
    $attack_errors,
    $blocked_attacks,
    $kill_blocks,
    $block_errors,
    $touch_blocks,
    $total_receptions,
    $perfect_receptions,
    $positive_receptions,
    $reception_errors,
    $successful_digs,
    $dig_errors,
    $id
);

    if ($stmt->execute()) {
        echo "<script>
                alert('İstatistik güncellendi!');
                window.location.href='statistics.php';
              </script>";
        exit();
    }
}

$statistics = $result->fetch_assoc();

$players = $conn->query("
    SELECT id, full_name, position
    FROM players
    ORDER BY full_name
");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İstatistik Ekle</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h2>📊 Maç İstatistiği Ekle</h2>
        </div>

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">
                    <label>Oyuncu</label>

                    <select name="player_id" class="form-select" required>

                        <?php while($player = $players->fetch_assoc()): ?>

    <option value="<?= $player['id'] ?>"
        data-position="<?= $player['position'] ?>"
        <?= ($player['id'] == $statistics['player_id']) ? 'selected' : '' ?>>

    <?= $player['full_name'] ?>

</option>

<?php endwhile; ?>

                    </select>
                </div>

                <div class="mb-3">
                    <label>Rakip Takım</label>

                    <input type="text"
       name="opponent"
       class="form-control"
       value="<?= htmlspecialchars($statistics['opponent']) ?>"
       required>
                </div>

                <div class="mb-3">
                    <label>Maç Tarihi</label>

                    <input type="date"
       name="match_date"
       class="form-control"
       value="<?= $statistics['match_date'] ?>"
       required>
                </div>

                <hr>


                <div id="serviceSection">

                <h4>🎯 Servis</h4>

                <input type="number" placeholder="Toplam Servis" name="total_serves"  class="form-control mb-2" min="0" value="<?= $statistics['total_serves'] ?>">

                <input type="number"
       placeholder="Ace Sayısı"
       name="aces"
       class="form-control mb-2"
       min="0"
       value="<?= $statistics['aces'] ?>">

                <input type="number" placeholder="Servis Hatası" name="service_errors"  class="form-control mb-2" min="0" value="<?= $statistics['service_errors'] ?>">

                <hr>

                </div>

                <div id="attackSection">

                <h4>🔥 Atak</h4>

                <input type="number" placeholder="Toplam Atak" name="total_attacks"  class="form-control mb-2" min="0" value="<?= $statistics['total_attacks'] ?>">

                <input type="number" placeholder="Atak Sayısı" name="attack_kills"  class="form-control mb-2" min="0" value="<?= $statistics['attack_kills'] ?>">

                <input type="number" placeholder="Atak Hatası" name="attack_errors"  class="form-control mb-2" min="0" value="<?= $statistics['attack_errors'] ?>">

                <input type="number" placeholder="Bloklanan Atak" name="blocked_attacks"  class="form-control mb-2" min="0" value="<?= $statistics['blocked_attacks'] ?>">

                <hr>

                </div>


                <div id="blockSection">

                <h4>🧱 Blok</h4>

                <input type="number" placeholder="Blok Sayısı" name="kill_blocks"  class="form-control mb-2" min="0" value="<?= $statistics['kill_blocks'] ?>">

                <input type="number" placeholder="Blok Hatası" name="block_errors"  class="form-control mb-2" min="0" value="<?= $statistics['block_errors'] ?>">

                <input type="number" placeholder="Blok Touch" name="touch_blocks"  class="form-control mb-2" min="0" value="<?= $statistics['touch_blocks'] ?>">

                <hr>

                </div>

                <div id="receptionSection">

                <h4>🛡️ Manşet</h4>

                <input type="number" placeholder="Toplam Manşet" name="total_receptions"  class="form-control mb-2" min="0" value="<?= $statistics['total_receptions'] ?>">

                <input type="number" placeholder="Mükemmel Manşet"
                name="perfect_receptions"  class="form-control mb-2" min="0" value="<?= $statistics['perfect_receptions'] ?>">

                <input type="number" placeholder="Pozitif Manşet" name="positive_receptions"  class="form-control mb-2" min="0" value="<?= $statistics['positive_receptions'] ?>">

                <input type="number" placeholder="Manşet Hatası" name="reception_errors"  class="form-control mb-2" min="0" value="<?= $statistics['reception_errors'] ?>">

                <hr>

                </div>


                <div id="digSection">

                <h4>🏐 Savunma</h4>

                <input type="number" placeholder="Başarılı Dig" name="successful_digs"  class="form-control mb-2" min="0" value="<?= $statistics['successful_digs'] ?>">

                <input type="number" placeholder="Dig Hatası" name="dig_errors"  class="form-control mb-2" min="0" value="<?= $statistics['dig_errors'] ?>">

                </div>

                <button type="submit" class="btn btn-success mt-3">
                    İstatistikleri Kaydet
                </button>

            </form>

        </div>

    </div>

</div>


<script>

const playerSelect = document.querySelector('select[name="player_id"]');

const serviceSection = document.getElementById('serviceSection');
const attackSection = document.getElementById('attackSection');
const blockSection = document.getElementById('blockSection');
const receptionSection = document.getElementById('receptionSection');
const digSection = document.getElementById('digSection');

function updateSections() {

    const selectedOption = playerSelect.options[playerSelect.selectedIndex];

    const position = selectedOption.dataset.position;

    // Önce hepsini göster
    serviceSection.style.display = 'block';
    attackSection.style.display = 'block';
    blockSection.style.display = 'block';
    receptionSection.style.display = 'block';
    digSection.style.display = 'block';

    // Libero
    if (position === 'Libero') {

        serviceSection.style.display = 'none';
        attackSection.style.display = 'none';
        blockSection.style.display = 'none';

    }

    // Pasör
    else if (position === 'Pasör') {

        receptionSection.style.display = 'none';

    }

    

}

playerSelect.addEventListener('change', updateSections);

// Sayfa ilk açıldığında da çalıştır
updateSections();

</script>

<script>

document.querySelector('form').addEventListener('submit', function(e) {

    const totalServes = parseInt(document.querySelector('[name="total_serves"]').value) || 0;
    const aces = parseInt(document.querySelector('[name="aces"]').value) || 0;
    const serviceErrors = parseInt(document.querySelector('[name="service_errors"]').value) || 0;

    if (aces + serviceErrors > totalServes) {

        alert('Ace + Servis Hatası Toplam Servisi aşamaz!');
        e.preventDefault();
        return;
    }

    const totalAttacks = parseInt(document.querySelector('[name="total_attacks"]').value) || 0;
    const attackKills = parseInt(document.querySelector('[name="attack_kills"]').value) || 0;
    const attackErrors = parseInt(document.querySelector('[name="attack_errors"]').value) || 0;
    const blockedAttacks = parseInt(document.querySelector('[name="blocked_attacks"]').value) || 0;

    if (attackKills + attackErrors + blockedAttacks > totalAttacks) {

        alert('Atak istatistikleri Toplam Atağı aşamaz!');
        e.preventDefault();
        return;
    }

    const totalReceptions = parseInt(document.querySelector('[name="total_receptions"]').value) || 0;
    const perfectReceptions = parseInt(document.querySelector('[name="perfect_receptions"]').value) || 0;
    const positiveReceptions = parseInt(document.querySelector('[name="positive_receptions"]').value) || 0;
    const receptionErrors = parseInt(document.querySelector('[name="reception_errors"]').value) || 0;

    if (perfectReceptions + positiveReceptions + receptionErrors > totalReceptions) {

        alert('Manşet istatistikleri Toplam Manşeti aşamaz!');
        e.preventDefault();
        return;
    }

});

</script>
</body>
</html>