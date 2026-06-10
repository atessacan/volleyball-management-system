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

$players = $conn->query("
    SELECT id, full_name, position
    FROM players
    ORDER BY full_name
");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $player_id = $_POST['player_id'];
    $opponent = trim($_POST['opponent']);
    $match_date = $_POST['match_date'];

    $total_serves = $_POST['total_serves'];
    $aces = $_POST['aces'];
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

    // Aynı maç istatistiği var mı kontrol et
    $check_sql = "SELECT id FROM player_statistics
                  WHERE player_id = ?
                  AND opponent = ?
                  AND match_date = ?";

    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("iss", $player_id, $opponent, $match_date);
    $check_stmt->execute();

    if ($check_stmt->get_result()->num_rows > 0) {
        echo "<script>
                alert('Bu oyuncu için bu maça ait istatistik zaten mevcut!');
                window.location.href='add_statistics.php';
              </script>";
        exit();
    }

    $sql = "INSERT INTO player_statistics (
        player_id, opponent, match_date,
        total_serves, aces, service_errors,
        total_attacks, attack_kills, attack_errors, blocked_attacks,
        kill_blocks, block_errors, touch_blocks,
        total_receptions, perfect_receptions,
        positive_receptions, reception_errors,
        successful_digs, dig_errors
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "issiiiiiiiiiiiiiiii",
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
        $dig_errors
    );

    if ($stmt->execute()) {
        echo "<script>
                alert('İstatistik başarıyla kaydedildi!');
                window.location.href='dashboard.php';
              </script>";
        exit();
    }
}
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
            data-position="<?= $player['position'] ?>">

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
                           required>
                </div>

                <div class="mb-3">
                    <label>Maç Tarihi</label>

                    <input type="date"
                           name="match_date"
                           class="form-control"
                           required>
                </div>

                <hr>


                <div id="serviceSection">

                <h4>🎯 Servis</h4>

                <input type="number" placeholder="Toplam Servis" name="total_serves"  class="form-control mb-2" min="0">

                <input type="number" placeholder="Ace Sayısı" name="aces"  class="form-control mb-2" min="0">

                <input type="number" placeholder="Servis Hatası" name="service_errors"  class="form-control mb-2" min="0">

                <hr>

                </div>

                <div id="attackSection">

                <h4>🔥 Atak</h4>

                <input type="number" placeholder="Toplam Atak" name="total_attacks"  class="form-control mb-2" min="0">

                <input type="number" placeholder="Atak Sayısı" name="attack_kills"  class="form-control mb-2" min="0">

                <input type="number" placeholder="Atak Hatası" name="attack_errors"  class="form-control mb-2" min="0">

                <input type="number" placeholder="Bloklanan Atak" name="blocked_attacks"  class="form-control mb-2" min="0">

                <hr>

                </div>


                <div id="blockSection">

                <h4>🧱 Blok</h4>

                <input type="number" placeholder="Blok Sayısı" name="kill_blocks"  class="form-control mb-2" min="0">

                <input type="number" placeholder="Blok Hatası" name="block_errors"  class="form-control mb-2" min="0">

                <input type="number" placeholder="Blok Touch" name="touch_blocks"  class="form-control mb-2" min="0">

                <hr>

                </div>

                <div id="receptionSection">

                <h4>🛡️ Manşet</h4>

                <input type="number" placeholder="Toplam Manşet" name="total_receptions"  class="form-control mb-2" min="0">

                <input type="number" placeholder="Mükemmel Manşet"
                name="perfect_receptions"  class="form-control mb-2" min="0">

                <input type="number" placeholder="Pozitif Manşet" name="positive_receptions"  class="form-control mb-2" min="0">

                <input type="number" placeholder="Manşet Hatası" name="reception_errors"  class="form-control mb-2" min="0">

                <hr>

                </div>


                <div id="digSection">

                <h4>🏐 Savunma</h4>

                <input type="number" placeholder="Başarılı Dig" name="successful_digs"  class="form-control mb-2" min="0">

                <input type="number" placeholder="Dig Hatası" name="dig_errors"  class="form-control mb-2" min="0">

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