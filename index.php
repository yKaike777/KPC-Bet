<?php 
// ==========================
// CONFIGURAÇÃO DA API
// ==========================
$apiKey = "d0b3dd0a8214e839996d981a6556177c";
$sport = "soccer_brazil.1";
$url = "https://api.the-odds-api.com/v4/sports/$sport/odds";
$url .= "?apiKey=$apiKey&regions=br&markets=h2h,totals&oddsFormat=decimal";

// ==========================
// REQUISIÇÃO C/ cURL
// ==========================
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if(curl_errno($ch)){
    die('Erro ao conectar na API: ' . curl_error($ch));
}

curl_close($ch);

// ==========================
// CONVERTE JSON EM ARRAY
// ==========================
$data = json_decode($response, true);
?>

<?php include 'header.php' ?>
<?php include 'navbar.php' ?>

<div class="container mt-4">
    <h2>Futebol - Série A do Brasil</h2>

    <div class="d-flex flex-row gap-3">
        <div class="flex-grow-1">
            <?php if (!$data || !is_array($data)): ?>
                <p>Erro ao carregar dados da API</p>
            <?php else: ?>
                <?php foreach($data as $partida): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <!-- Nomes dos times -->
                            <h5 class="card-title">
                                <?php echo htmlspecialchars($partida['home_team'] ?? 'Time Casa'); ?> 
                                X 
                                <?php echo htmlspecialchars($partida['away_team'] ?? 'Time Visitante'); ?>
                            </h5>

                            <?php
                            // Verifica se existem bookmakers
                            $bookmaker = $partida['bookmakers'][0] ?? null;

                            if ($bookmaker && is_array($bookmaker) && isset($bookmaker['markets']) && is_array($bookmaker['markets'])):

                                // ==========================
                                // Mercado H2H (vencedor)
                                // ==========================
                                $h2h = null;
                                foreach ($bookmaker['markets'] as $market) {
                                    if (isset($market['key']) && $market['key'] == 'h2h' && isset($market['outcomes']) && is_array($market['outcomes'])) {
                                        $h2h = $market['outcomes'];
                                        break;
                                    }
                                }

                                if ($h2h):
                                    echo "<div class='mb-2'><strong>Resultado:</strong> ";
                                    foreach ($h2h as $outcome):
                                        $btnClass = 'btn-secondary';
                                        if (($outcome['name'] ?? '') == ($partida['home_team'] ?? '')) $btnClass = 'btn-danger';
                                        if (($outcome['name'] ?? '') == ($partida['away_team'] ?? '')) $btnClass = 'btn-success';
                                        echo "<button class='btn $btnClass btn-sm me-1'>";
                                        echo htmlspecialchars($outcome['name'] ?? '-') . " → " . htmlspecialchars($outcome['price'] ?? '-');
                                        echo "</button>";
                                    endforeach;
                                    echo "</div>";
                                endif;

                                // ==========================
                                // Mercado Totals (Mais/Menos gols)
                                // ==========================
                                $totals = null;
                                foreach ($bookmaker['markets'] as $market) {
                                    if (isset($market['key']) && $market['key'] == 'totals' && isset($market['outcomes']) && is_array($market['outcomes'])) {
                                        $totals = $market['outcomes'];
                                        break;
                                    }
                                }

                                if ($totals):
                                    echo "<div><strong>Mais/Menos Gols:</strong> ";
                                    foreach ($totals as $total):
                                        echo "<button class='btn btn-info btn-sm me-1'>";
                                        echo htmlspecialchars($total['name'] ?? '-') . " → " . htmlspecialchars($total['price'] ?? '-');
                                        echo "</button>";
                                    endforeach;
                                    echo "</div>";
                                endif;

                            else:
                                echo "<p>Sem odds disponíveis</p>";
                            endif;
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- IFRAME DO WIDGET -->
        <div>
            <iframe class="float-end" src="https://widget.api-futebol.com.br/render/widget_80ddc7ee9c3a80bf" 
                    title="API Futebol - Widget" width="350" height="700" 
                    style="border:1px solid #E5E7EB;border-radius:0.375rem;background:transparent;width:350px;height:700px;" 
                    loading="lazy" referrerpolicy="unsafe-url" 
                    sandbox="allow-scripts allow-forms allow-popups allow-top-navigation-by-user-activation allow-popups-to-escape-sandbox">
            </iframe>
        </div>
    </div>
</div>

<?php include 'footer.php' ?>
